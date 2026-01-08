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
        // Update products with NULL image to have default images
        $products = DB::table('products')->whereNull('image')->get();
        foreach ($products as $product) {
            $imageName = 'product' . $product->id . '.png';
            if (file_exists(public_path('images/' . $imageName))) {
                DB::table('products')->where('id', $product->id)->update(['image' => $imageName]);
            } else {
                $imageNameJpg = 'product' . $product->id . '.jpg';
                if (file_exists(public_path('images/' . $imageNameJpg))) {
                    DB::table('products')->where('id', $product->id)->update(['image' => $imageNameJpg]);
                } else {
                    // Set a default image if no specific image exists
                    DB::table('products')->where('id', $product->id)->update(['image' => 'default.png']);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Optionally, set back to NULL, but since the column is nullable, this is fine
        // DB::table('products')->update(['image' => null]);
    }
};
