<?php

use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category1= factory(App\Category::class, 'admin1')->create();
        $category2= factory(App\Category::class, 'admin2')->create();
        $category3= factory(App\Category::class, 'admin3')->create();

        factory(App\Article::class, 'admin1', 100)->create()->each(function ($article) use($category1){
            $category1->articles()->attach($article);
        });
        factory(App\Article::class, 'admin2', 10)->create()->each(function ($article) use($category2){
            $category2->articles()->attach($article);
        });
        factory(App\Article::class, 'admin3', 10)->create()->each(function ($article) use($category3){
            $category3->articles()->attach($article);
        });
    }
}

