<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')

            ->chunkById(50, function ($users) {
                foreach ($users as $user) {

                    // Search for any file starting with user{id}. in public/img
                    $matches = glob(public_path("img/user{$user->id}.*"));

                    $image = 'default.png'; // fallback

                    if (!empty($matches)) {
                        $image = basename($matches[0]); // take the first matching file
                    }

                    DB::table('users')
                        ->where('id', $user->id)
                        ->update(['image' => $image]);
                }
            });
    }
}
