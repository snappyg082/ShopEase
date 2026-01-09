<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $defaultImage = 'user1.jpg';
        $imagePath = public_path('storage/profile-photos' . $defaultImage);

        // Ensure the image exists before updating
        if (!File::exists($imagePath)) {
            return;
        }

        // Update all users with NULL image
        DB::table('users')
            ->whereNull('image')
            ->update([
                'image' => $defaultImage
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('users')->update(['image' => null]);
    }
};
