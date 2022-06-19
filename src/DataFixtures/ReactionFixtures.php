<?php

namespace App\DataFixtures;

use App\Entity\Reaction;
use App\Entity\Ticket;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Security\Core\Exception\ExceptionInterface;

class ReactionFixtures extends Fixture implements DependentFixtureInterface
{
    private Generator $faker;

    public function __construct(private SluggerInterface $slugger)
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        for ($ticketId = 0; $ticketId < 10; $ticketId++) {
            for($userId = 0; $userId < 4; $userId++){
                /** @var User $randomUser */
                $randomUser = $this->getReference('user-' . $userId);

                /** @var Ticket $randomTicket */
                $randomTicket = $this->getReference('ticket-' . $ticketId);

                $reaction = (new Reaction())
                ->setTicket($randomTicket)
                ->setUser($randomUser)
                ->setIsLike($this->faker->boolean());

                $manager->persist($reaction);
                $this->setReference('reaction-' . $ticketId, $reaction);
            }
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
