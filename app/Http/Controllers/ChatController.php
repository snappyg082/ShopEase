<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Show chat page
    public function index()
    {
        return view('chat');
    }

    // Handle sending a message
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $userId = Auth::id();
        $userMessage = $request->message;

        // Save user message
        Message::create([
            'role' => 'user',
            'content' => $userMessage,
            'user_id' => $userId,
        ]);

        /**
         * Build conversation history for Gemini
         */
        $history = Message::where('user_id', $userId)
            ->latest()
            ->take(10)
            ->get()
            ->reverse();

        $contents = [];

        foreach ($history as $msg) {
            $contents[] = [
                'role' => $msg->role === 'assistant' ? 'model' : 'user',
                'parts' => [
                    ['text' => $msg->content],
                ],
            ];
        }

        // Call Gemini API (CORRECT + SAFE)
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])
            ->post(
                'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent',
                [
                    'contents' => $contents,
                    'generationConfig' => [
                        'temperature' => 0.7,
                        'maxOutputTokens' => 500,
                    ],
                ],
                [
                    'query' => [
                        'key' => env('GEMINI_API_KEY'),
                    ],
                ]
            );

        /** @var \Illuminate\Http\Client\Response $response   */

        // 🔴 LOG REAL GEMINI ERRORS
        if (!$response->successful()) {
            Log::error('GEMINI API ERROR', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            // Return 200 so frontend does NOT break
            return response()->json([
                'reply' => 'The AI service is currently unavailable. Please try again later.',
            ]);
        }

        $data = $response->json();

        // ✅ SAFE RESPONSE HANDLING
        if (
            empty($data['candidates']) ||
            !isset($data['candidates'][0]['content']['parts'][0]['text'])
        ) {
            Log::warning('GEMINI EMPTY RESPONSE', $data);

            return response()->json([
                'reply' => 'The AI could not generate a response. Please try again.',
            ]);
        }

        $reply = $data['candidates'][0]['content']['parts'][0]['text'];

        // Save assistant reply
        Message::create([
            'role' => 'assistant',
            'content' => $reply,
            'user_id' => $userId,
        ]);

        return response()->json([
            'reply' => $reply,
        ]);
    }
}
