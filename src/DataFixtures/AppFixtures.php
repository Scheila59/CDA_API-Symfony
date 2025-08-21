<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\User;
use App\Entity\Author;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // création d'un user "normal"
        $user = new User();
        $user->setEmail("user@bookapi.com");
        $user->setRoles(["ROLE_USER"]);

        $user->setPassword($this->userPasswordHasher->hashPassword($user, "password"));
        $manager->persist($user);

        // création d'un user admin
        $userAdmin = new User();
        $userAdmin->setEmail("admin@bookapi.com");
        $userAdmin->setRoles(["ROLE_ADMIN"]);

        $userAdmin->setPassword($this->userPasswordHasher->hashPassword($userAdmin, "password"));
        $manager->persist($userAdmin);

        $listAuthor = [];

        // Création des auteurs
        for ($i = 1; $i < 11; $i++) {
            // creation de l'auteur lui-même.
            $author = new Author();
            $author->setFirstName("Prénom " . $i);
            $author->SetLastName("Nom " . $i);
            $manager->persist($author);
            // on ajoute l'auteur crée dans le tableau.
            $listAuthor[] = $author;
        }

        // boucle pour créer des livres
        for ($i = 1; $i < 21; $i++) {
            $book = new Book();
            $book->setTitle("Livre " . $i);
            $book->setCoverText("Quatrième de couverture numéro : " . $i);

            $book->setComment("Commentaire du bibliothécaire " . $i);
            $book->setAuthor($listAuthor[array_rand($listAuthor)]);
            $manager->persist($book);
            // on lie le livre à un auteur pris au hasard dans le tableau des auteurs
        }

        $manager->flush();
    }
}