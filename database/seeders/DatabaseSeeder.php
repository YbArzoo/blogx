<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;              // ✅ add
use App\Models\Blog;              // ✅ add (optional, for clarity)
use App\Models\BlogCategory;      // ✅ add (optional)

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(                       // ✅ short name
            ['email' => 'admin@example.com'],
            ['name' => 'Admin', 'password' => bcrypt('password'), 'is_admin' => true, 'status' => 1]
        );

        $cats = collect(['General','Tech','Life'])
            ->map(fn ($n) => BlogCategory::firstOrCreate(   // ✅ short name
                ['name' => $n],
                ['status' => 1]
            ));

        foreach (range(1, 6) as $i) {
            Blog::create([                                  // ✅ short name
                'title'        => "Sample Blog {$i}",
                'category_id'  => $cats->random()->id,
                'operator_id'  => $admin->id,
                'description'  => str_repeat("This is a sample blog {$i}. ", 10),
                'thumbnail'    => 'thumbs/sample.webp',
                'status'       => 1,
            ]);
        }
    }
}
