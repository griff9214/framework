<?php


use Phinx\Seed\AbstractSeed;

class PostsSeed extends AbstractSeed
{
    public function run()
    {
        $this->table('posts')->truncate();

        $faker = Faker\Factory::create();
        $posts = [];
        for ($i = 0; $i < 50; $i++) {
            $posts[] = [
                'date' => $faker->date('Y-m-d H:i:s'),
                'title' => trim($faker->sentence()),
                'content' => trim($faker->text(500))
            ];
        }
        $this->insert('posts', $posts);
    }
}
