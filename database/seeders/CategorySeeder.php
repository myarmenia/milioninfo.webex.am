<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories =[ [
            'id'=>1,
            'path'=>'public/categories/1/f865d78ac4c4875e85d0d842de0aaeab.png',
            'created_at'=>NULL,
            'updated_at'=>NULL
        ],
        [
                'id'=>2,
                'path'=>'public/categories/2/534b73452f58ff5de5a5eb6e161abb66.png',
                'created_at'=>NULL,
                'updated_at'=>NULL
        ],
        [
                'id'=>3,
                'path'=>'public/categories/3/589855f9bfe49f0fb81b152145d9d05b.png',
                'created_at'=>NULL,
                'updated_at'=>NULL
        ],
     [
            'id'=>4,
            'path'=>'public/categories/4/1c25506e85c37834e601af00426f4563.png',
            'created_at'=>NULL,
            'updated_at'=>NULL
    ], [
            'id'=>5,
            'path'=>'public/categories/5/abf49783270711009f9c4c099011ff85.png',
            'created_at'=>NULL,
            'updated_at'=>NULL
    ],[
            'id'=>6,
            'path'=>'public/categories/6/e3be6febe46f5b62fe2740f8ad5ad2da.png',
            'created_at'=>NULL,
            'updated_at'=>NULL
    ],[
            'id'=>7,
            'path'=>'public/categories/7/8a699809386d467d6bfb3773b0b7e6bf.png',
            'created_at'=>NULL,
            'updated_at'=>NULL
    ],
     [
            'id'=>8,
            'path'=>'public/categories/8/f4c9072a50984b57f3c9d26083425bb4.png',
            'created_at'=>NULL,
            'updated_at'=>NULL
     ]
    ];
     foreach ($categories as $category) {
        Category::updateOrCreate($category);
      }

    }
}
