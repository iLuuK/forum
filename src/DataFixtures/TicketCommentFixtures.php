<?php

namespace App\DataFixtures;

use App\Entity\TicketComment;
use App\Entity\Ticket;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\String\Slugger\SluggerInterface;

class TicketCommentFixtures extends Fixture implements DependentFixtureInterface
{
    private Generator $faker;

    public function __construct(private SluggerInterface $slugger)
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        $count = $this->faker->numberBetween(10, 50);
        for ($a = 0; $a < $count; $a++) {
            $randomUserId = $this->faker->numberBetween(0, 4);
            /** @var User $randomUser */
            $randomUser = $this->getReference('user-' . $randomUserId);

            $randomTicketId = $this->faker->numberBetween(0, 10);
            /** @var Ticket $randomTicket */
            $randomTicket = $this->getReference('ticket-' . $randomTicketId);

            $ticketComment = (new TicketComment())
                ->setTicket($randomTicket)
                ->setContent($this->faker->realText(300))
                ->setAuthor($randomUser);

            $manager->persist($ticketComment);
            $this->setReference('ticketComment-' . $a, $ticketComment);
        }

        $manager->flush();
    }

    public function getDependencies() : array
    {
        return [
            UserFixtures::class,
            CategoryFixtures::class,
            TicketFixtures::class,
        ];
    }

}