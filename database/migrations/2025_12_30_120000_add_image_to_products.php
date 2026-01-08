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
        if (Schema::hasTable('products') && !Schema::hasColumn('products', 'image')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('image')->nullable()->after('stock');
            });

            // Backfill existing products with sensible filenames if images exist in public/images
            $products = DB::table('products')->select('id')->get();
            foreach ($products as $p) {
                $candidate = 'product' . $p->id . '.jpg';
                if (file_exists(public_path('images/' . $candidate))) {
                    DB::table('products')->where('id', $p->id)->update(['image' => $candidate]);
                } else {
                    // try png
                    $candidatePng = 'product' . $p->id . '.png';
                    if (file_exists(public_path('images/' . $candidatePng))) {
                        DB::table('products')->where('id', $p->id)->update(['image' => $candidatePng]);
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
        if (Schema::hasColumn('products', 'image')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('image');
            });
        }
    }
};
