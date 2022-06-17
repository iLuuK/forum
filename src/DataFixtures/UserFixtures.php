<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class UserFixtures extends Fixture
{
    private Generator $faker;

    public function __construct(private UserPasswordHasherInterface $passwordEncoder,
    private SluggerInterface $slugger)
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        $count = $this->faker->numberBetween(5, 20);
        for ($a = 0; $a < $count; $a++) {
            $this->createUser($manager);
        }

        $this->createUser($manager, [
            'username' => 'admin',
            'roles' => ['ROLE_USER', 'ROLE_ADMINISTRATOR'],
            'password' => 'admin',
            'firstname' => 'Lucas',
            'lastname' => 'GIL',
            'address' => '0 rue de bordeaux',
            'postal_code' => '33000',
            'email' => 'contactgillucas@gmail.com',
            'phone_number' => '0000000000',
            'is_close' => false,
            'is_ban' => false
        ]);

        $manager->flush();
    }

    public function createUser(ObjectManager $manager, array $data = [])
    {
        static $index = 0;

        $data = array_replace(
            [
                'username' => $this->faker->userName(),
                'roles' => ['ROLE_USER'],
                'password' => $this->faker->password(),
                'firstname' => $this->faker->firstName(),
                'lastname' => $this->faker->lastName(),
                'address' => $this->faker->streetAddress(),
                'postal_code' => $this->faker->postcode(),
                'email' => $this->faker->email(),
                'phone_number' => $this->faker->numberBetween(1000000000,9999999999),
                'is_close' => false,
                'is_ban' => false
            ],
            $data,
        );
        $user = (new User())
            ->setUsername($data['username'])
            ->setRoles($data['roles'])
            ->setFirstname($data['firstname'])
            ->setLastname($data['lastname'])
            ->setAddress($data['address'])
            ->setPostalCode($data['postal_code'])
            ->setEmail($data['email'])
            ->setPhoneNumber($data['phone_number'])
            ->computeSlug($this->slugger);

        $user->setPassword($this->passwordEncoder->hashPassword($user, $data['password']));
        $manager->persist($user);
        $this->setReference('user-' . $index++, $user);
    }
}
