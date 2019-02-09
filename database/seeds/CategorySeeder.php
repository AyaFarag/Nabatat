<?php

use Illuminate\Database\Seeder;
use App\Models\Category as Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Yard',
                    'children' => [
                        [    
                            'name' => 'sub yard'
                        ],
                        [    
                            'name' => 'Textbooks'
                        ],
                    ],
                ],
                [
                    'name' => 'Electronics',
                        'children' => [
                        [
                            'name' => 'TV'
                        ],
                        [
                            'name' => 'Mobile'
                        ],
                    ],
                ],
        ];
        foreach($categories as $category)
        {
            Category::create($category);
        }
    }
}
