<?php

use Illuminate\Database\Seeder;
use App\Models\Page;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Page::class)->create([
            'title' => 'About Us',
            'type' => Page::ABOUT
        ],1);
        factory(Page::class)->create([
            'title' => 'Privacy',
            'type' => Page::PRIVACY
        ],1);
    }
}
