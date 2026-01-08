<?php

namespace App\Http\Controllers;

use App\Models\Sms;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SmsController extends Controller
{
    // List messages by type
    public function index(Request $request)
    {
        $type = $request->query('type', 'inbox'); // default inbox
        $sms = Sms::where('user_id', Auth::id())
            ->where('type', $type)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('sms.index', compact('sms', 'type'));
    }

    // Show single message
    public function show(Sms $sms)
    {
        // Check if the SMS belongs to the current user
        if ($sms->user_id !== Auth::id()) {
            abort(403); // Forbidden
        }

        $sms->update(['read' => true]);

        return view('sms.show', compact('sms'));
    }
}
