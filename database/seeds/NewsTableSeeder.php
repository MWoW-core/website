<?php

use App\News;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\WithFaker;

class NewsTableSeeder extends Seeder
{
    use WithFaker;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->setUpFaker();

        factory(News::class)->state('with image')->times(3)->create();
        factory(News::class)->times(20)->create();

        foreach (News::query()->take(rand(10,15))->inRandomOrder()->cursor() as $news) {
            $numComments = rand(1,5);
            for ($i = 0; $i < $numComments; $i++) {
                /** @var News $news */
                $news->commentAsUser(
                    User::query()->inRandomOrder()->firstOr(fn () => factory(User::class)->create()),
                    $this->faker->paragraph
                );
            }
        }
    }
}
