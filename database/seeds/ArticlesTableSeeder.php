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
        $category1= factory(App\Category::class, 'test1')->create();
        $category2= factory(App\Category::class, 'test2')->create();
        $category3= factory(App\Category::class, 'test3')->create();

        factory(App\Article::class, 'test1', 10)->create()->each(function ($article) use($category1){
            $category1->articles()->attach($article);
        });
        factory(App\Article::class, 'test2', 10)->create()->each(function ($article) use($category2){
            $category2->articles()->attach($article);
        });
        factory(App\Article::class, 'test3', 100)->create()->each(function ($article) use($category3){
            $category3->articles()->attach($article);
        });
    }
}

