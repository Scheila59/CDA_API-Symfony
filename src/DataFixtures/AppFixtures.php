<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\Author;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
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

            $book->setAuthor($listAuthor[array_rand($listAuthor)]);
            $manager->persist($book);
            // on lie le livre à un auteur pris au hasard dans le tableau des auteurs
        }

        $manager->flush();
    }
}