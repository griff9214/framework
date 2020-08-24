<?php

use App\Entity\Post\Content;
use App\Entity\Post\Meta;
use App\Entity\Post\Post;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class BlogFixture extends AbstractFixture
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 50; $i++) {
            $post = new Post(
                DateTimeImmutable::createFromMutable($faker->dateTime),
                $title = $faker->sentence,
                new Content($faker->text(100), $faker->paragraphs(5, true)),
                new Meta($title, $faker->words(6, true), $faker->sentences(3, true))
            );
            for ($a = 0; $a < rand(1, 10); $a++) {
                $post->addComment(
                    DateTimeImmutable::createFromMutable($faker->dateTime),
                    $title = $faker->name,
                    $faker->text(150),
                    );
            }
            $manager->persist($post);
        }
        $manager->flush();
    }
}