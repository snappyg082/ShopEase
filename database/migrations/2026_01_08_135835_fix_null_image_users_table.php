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
            // Check if the .jpg image exists
            $imageJpg = 'user' . $user->id . '.jpg';
            $imagePng  = 'user' . $user->id . '.png';

            if (file_exists(public_path('img/' . $imageJpg))) {
                $imageToUse = $imageJpg;
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
