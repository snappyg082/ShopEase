<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'image')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('image')->nullable()->after('id');
            });

            // Backfill existing products with sensible filenames if images exist in public/images
            $users = DB::table('users')->select('id')->get();
            foreach ($users as $user) {
                $candidate = 'user' . $user->id . '.jfif';
                if (file_exists(public_path('img/' . $candidate))) {
                    DB::table('users')->where('id', $user->id)->update(['image' => $candidate]);
                } else {
                    // try png
                    $candidatePng = 'user' . $user->id . '.png';
                    if (file_exists(public_path('img/' . $candidatePng))) {
                        DB::table('users')->where('id', $user->id)->update(['image' => $candidatePng]);
                    }
                }
            }
        }
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('users', 'image')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('image');
            });
        }
    }
};
