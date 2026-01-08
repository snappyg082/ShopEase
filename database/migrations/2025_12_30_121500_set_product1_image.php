<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('products')->where('id', 1)->update(['image' => 'product1.png']);
    }

    public function down(): void
    {
        DB::table('products')->where('id', 1)->update(['image' => null]);
    }
};
