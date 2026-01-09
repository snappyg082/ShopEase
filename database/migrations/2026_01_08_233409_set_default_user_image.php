<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')
            ->where(function ($q) {
                $q->whereNull('image')
                    ->orWhere('image', '');
            })
            ->update([
                'image' => 'user1.jpg'
            ]);
    }

    public function down(): void
    {
        DB::table('users')->update(['image' => null]);
    }
};
