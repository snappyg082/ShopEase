<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Get all users without an image
        $users = DB::table('users')->whereNull('image')->get();

        foreach ($users as $user) {
            // Check if the .jfif image exists
            $imageJfif = 'user' . $user->id . '.jfif';
            $imagePng  = 'user' . $user->id . '.png';

            if (file_exists(public_path('img/' . $imageJfif))) {
                $imageToUse = $imageJfif;
            } elseif (file_exists(public_path('img/' . $imagePng))) {
                $imageToUse = $imagePng;
            } else {
                $imageToUse = 'default.png';
            }

            // Update the user record
            DB::table('users')->where('id', $user->id)->update(['image' => $imageToUse]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('users')->update(['image' => null]);
    }
};
