<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Gender;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shoes = [
            [
                'name' => json_encode(['en' => 'Shoes', 'de' => 'Schuhe']),
                'description' => json_encode(['en' => 'Casual desc', 'de' => 'Beiläufig desc']),
                'active' => 1,
                'parent_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
                'created_by' => null,
                'updated_by' => null,
                'deleted_by' => null,
            ],
            [
                'name' => json_encode(['en' => 'Sneakers', 'de' => 'Turnschuhe']),
                'description' => json_encode(['en' => 'Sneakers desc', 'de' => 'Turnschuhe desc']),
                'active' => 1,
                'parent_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
                'created_by' => null,
                'updated_by' => null,
                'deleted_by' => null,
            ],
            [
                'name' => json_encode(['en' => 'Running shoes', 'de' => 'Laufschuhe']),
                'description' => json_encode(['en' => 'Running shoes desc', 'de' => 'Laufschuhe desc']),
                'active' => 1,
                'parent_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
                'created_by' => null,
                'updated_by' => null,
                'deleted_by' => null,
            ],
            [
                'name' => json_encode(['en' => 'Sandals & Slippers', 'de' => 'Sandalen und Hausschuhe']),
                'description' => json_encode(
                    ['en' => 'Sandals & Slippers desc', 'de' => 'Sandalen und Hausschuhe desc']
                ),
                'active' => 1,
                'parent_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
                'created_by' => null,
                'updated_by' => null,
                'deleted_by' => null,
            ]
        ];
        $clothes = [
            [
                'name' => json_encode(['en' => 'Clothes', 'de' => 'Kleider']),
                'description' => json_encode(['en' => 'Clothes desc', 'de' => 'Kleider desc']),
                'active' => 1,
                'parent_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
                'created_by' => null,
                'updated_by' => null,
                'deleted_by' => null,
            ],
            [
                'name' => json_encode(['en' => 'Pants', 'de' => 'Turnschuhe']),
                'description' => json_encode(['en' => 'Pants desc', 'de' => 'Turnschuhe desc']),
                'active' => 1,
                'parent_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
                'created_by' => null,
                'updated_by' => null,
                'deleted_by' => null,
            ],
            [
                'name' => json_encode(['en' => 'Hoodies & Sweatshirts', 'de' => 'Hoodies & Sweatshirts']),
                'description' => json_encode(
                    ['en' => 'Hoodies & Sweatshirts desc', 'de' => 'Hoodies & Sweatshirts desc']
                ),
                'active' => 1,
                'parent_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
                'created_by' => null,
                'updated_by' => null,
                'deleted_by' => null,
            ],
            [
                'name' => json_encode(['en' => 'Jackets', 'de' => 'Jacken']),
                'description' => json_encode(['en' => 'Jackets desc', 'de' => 'Jacken desc']),
                'active' => 1,
                'parent_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
                'created_by' => null,
                'updated_by' => null,
                'deleted_by' => null,
            ],
            [
                'name' => json_encode(['en' => 'Underwear', 'de' => 'Unterwäsche']),
                'description' => json_encode(['en' => 'Underwear category', 'de' => 'Unterwäsche desc']),
                'active' => 1,
                'parent_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
                'created_by' => null,
                'updated_by' => null,
                'deleted_by' => null,
            ]
        ];

        DB::table('categories')->insert($shoes);
        DB::table('categories')->insert($clothes);

        $genders = Gender::all();
        foreach ($genders as $gender) {
            $gender->categories()->attach(Category::all()->pluck('id')->toArray());
        }

        $femaleClothes = [
            [
                'name' => ['en' => 'Leggings & Tights', 'de' => 'Leggings & Strumpfhosen'],
                'description' => ['en' => 'Leggings & Tights category', 'de' => 'Leggings & Strumpfhosen desc'],
                'active' => 1,
                'parent_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
                'created_by' => null,
                'updated_by' => null,
                'deleted_by' => null,
            ],
            [
                'name' => ['en' => 'Skirts & Dresses', 'de' => 'Röcke & Kleider'],
                'description' => ['en' => 'Skirts & Dresses category', 'de' => 'Röcke & Kleider desc'],
                'active' => 1,
                'parent_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
                'created_by' => null,
                'updated_by' => null,
                'deleted_by' => null,
            ],
            [
                'name' => ['en' => 'Bras', 'de' => 'BHs'],
                'description' => ['en' => 'Bras category', 'de' => 'BHs desc'],
                'active' => 1,
                'parent_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
                'created_by' => null,
                'updated_by' => null,
                'deleted_by' => null,
            ]
        ];

        foreach ($femaleClothes as $item) {
            $category = Category::create($item);

            $category->genders()->attach(2);
        }
    }
}
