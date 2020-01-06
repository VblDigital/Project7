<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class ProductFixtures
 * @package App\DataFixtures
 */
class ProductFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load( ObjectManager $manager)
    {
        $product = new Product();
        $product
            ->setName("Samsung Galaxy S7 32Go Noir")
            ->setReference("S00001_32N")
            ->setDescription("Acheter un Samsung Galaxy S7 revient à s’offrir l’un des smartphones les plus performants du 
                moment. L’accent a ici été mis sur le design, avec une finition exemplaire et un écran incurvé de haute 
                volée. Les performances n’ont pour autant pas été oubliées par le fabricant : une très bonne qualité de 
                photo, une autonomie sans précédent et une étanchéité de l’appareil vous permettant de braver sans 
                soucis les intempéries")
            ->setPrice("69990")
            ->setStock("22");
        $product->addClient($this->getReference('client1'));
        $manager->persist($product);
        $this->addReference("S00001_32N", $product);

        $product = new Product();
        $product
            ->setName("Samsung Galaxy S7 32Go Rose")
            ->setReference("S00002_32R")
            ->setDescription("Acheter un Samsung Galaxy S7 revient à s’offrir l’un des smartphones les plus performants du 
                moment. L’accent a ici été mis sur le design, avec une finition exemplaire et un écran incurvé de haute 
                volée. Les performances n’ont pour autant pas été oubliées par le fabricant : une très bonne qualité de 
                photo, une autonomie sans précédent et une étanchéité de l’appareil vous permettant de braver sans 
                soucis les intempéries")
            ->setPrice("69990")
            ->setStock("12");
        $product->addClient($this->getReference('client1'));
        $manager->persist($product);
        $this->addReference("S00002_32R", $product);

        $product = new Product();
        $product
            ->setName("Samsung Galaxy S7 32Go Argent")
            ->setReference("S00003_32A")
            ->setDescription("Acheter un Samsung Galaxy S7 revient à s’offrir l’un des smartphones les plus performants du 
                moment. L’accent a ici été mis sur le design, avec une finition exemplaire et un écran incurvé de haute 
                volée. Les performances n’ont pour autant pas été oubliées par le fabricant : une très bonne qualité de 
                photo, une autonomie sans précédent et une étanchéité de l’appareil vous permettant de braver sans 
                soucis les intempéries")
            ->setPrice("69990")
            ->setStock("10");
        $product->addClient($this->getReference('client1'));
        $manager->persist($product);
        $this->addReference("S00003_32A", $product);

        $product = new Product();
        $product
            ->setName("Samsung Galaxy S7 64Go Noir")
            ->setReference("S00004_64N")
            ->setDescription("Acheter un Samsung Galaxy S7 revient à s’offrir l’un des smartphones les plus performants du 
                moment. L’accent a ici été mis sur le design, avec une finition exemplaire et un écran incurvé de haute 
                volée. Les performances n’ont pour autant pas été oubliées par le fabricant : une très bonne qualité de 
                photo, une autonomie sans précédent et une étanchéité de l’appareil vous permettant de braver sans 
                soucis les intempéries")
            ->setPrice("79900")
            ->setStock("15");
        $product->addClient($this->getReference('client1'));
        $manager->persist($product);
        $this->addReference("S00004_64N", $product);

        $product = new Product();
        $product
            ->setName("Samsung Galaxy S7 64Go Rose")
            ->setReference("S00005_64R")
            ->setDescription("Acheter un Samsung Galaxy S7 revient à s’offrir l’un des smartphones les plus performants du 
                moment. L’accent a ici été mis sur le design, avec une finition exemplaire et un écran incurvé de haute 
                volée. Les performances n’ont pour autant pas été oubliées par le fabricant : une très bonne qualité de 
                photo, une autonomie sans précédent et une étanchéité de l’appareil vous permettant de braver sans 
                soucis les intempéries")
            ->setPrice("79900")
            ->setStock("25");
        $product->addClient($this->getReference('client1'));
        $manager->persist($product);
        $this->addReference("S00005_64R", $product);

        $product = new Product();
        $product
            ->setName("Samsung Galaxy S7 64Go Argent")
            ->setReference("S00006_64A")
            ->setDescription("Acheter un Samsung Galaxy S7 revient à s’offrir l’un des smartphones les plus performants du 
                moment. L’accent a ici été mis sur le design, avec une finition exemplaire et un écran incurvé de haute 
                volée. Les performances n’ont pour autant pas été oubliées par le fabricant : une très bonne qualité de 
                photo, une autonomie sans précédent et une étanchéité de l’appareil vous permettant de braver sans 
                soucis les intempéries")
            ->setPrice("79900")
            ->setStock("16");
        $product->addClient($this->getReference('client1'));
        $manager->persist($product);
        $this->addReference("S00006_64A", $product);

        $product = new Product();
        $product
            ->setName("iPhone 7 128Go Noir")
            ->setReference("I00001_128N")
            ->setDescription("L’iPhone 7 est le dernier né de la célèbre gamme de smartphones d’Apple. Si 
            celui-ci reprend les mêmes dimensions et à peu près le même aspect que son prédécesseur l’iPhone 6s, il le 
            surpasse de loin. En effet, un iPhone 7 noir 128 go embarque plusieurs innovations, que ce soit au niveau du 
            chipset, de l’écran, des capteurs photographiques et de l’iPhone en lui-même. Sous sa belle coque élégante, 
            l’iPhone 7 cache un redoutable chipset, qui est l’Apple A10 Fusion. Son processeur central intègre deux cœurs 
            à haute performance et deux cœurs à haute efficacité énergétique. La vitesse d’exécution de applications est 
            alors deux fois supérieure à celle de l’Apple A8 de l’iPhone 6 et le SoC consomme jusqu’à cinq fois moins 
            d’énergie.")
            ->setPrice("49990")
            ->setStock("12");
        $product->addClient($this->getReference('client1'));
        $manager->persist($product);
        $this->addReference("I00001_128N", $product);

        $product = new Product();
        $product
            ->setName("iPhone 7 128Go Rose")
            ->setReference("I00002_128R")
            ->setDescription("L’iPhone 7 est le dernier né de la célèbre gamme de smartphones d’Apple. Si 
            celui-ci reprend les mêmes dimensions et à peu près le même aspect que son prédécesseur l’iPhone 6s, il le 
            surpasse de loin. En effet, un iPhone 7 noir 128 go embarque plusieurs innovations, que ce soit au niveau du 
            chipset, de l’écran, des capteurs photographiques et de l’iPhone en lui-même. Sous sa belle coque élégante, 
            l’iPhone 7 cache un redoutable chipset, qui est l’Apple A10 Fusion. Son processeur central intègre deux cœurs 
            à haute performance et deux cœurs à haute efficacité énergétique. La vitesse d’exécution de applications est 
            alors deux fois supérieure à celle de l’Apple A8 de l’iPhone 6 et le SoC consomme jusqu’à cinq fois moins 
            d’énergie.")
            ->setPrice("49990")
            ->setStock("5");
        $product->addClient($this->getReference('client1'));
        $manager->persist($product);
        $this->addReference("I00002_128R", $product);

        $product = new Product();
        $product
            ->setName("iPhone 7 128Go Argent")
            ->setReference("I00003_128A")
            ->setDescription("L’iPhone 7 est le dernier né de la célèbre gamme de smartphones d’Apple. Si 
            celui-ci reprend les mêmes dimensions et à peu près le même aspect que son prédécesseur l’iPhone 6s, il le 
            surpasse de loin. En effet, un iPhone 7 noir 128 go embarque plusieurs innovations, que ce soit au niveau du 
            chipset, de l’écran, des capteurs photographiques et de l’iPhone en lui-même. Sous sa belle coque élégante, 
            l’iPhone 7 cache un redoutable chipset, qui est l’Apple A10 Fusion. Son processeur central intègre deux cœurs 
            à haute performance et deux cœurs à haute efficacité énergétique. La vitesse d’exécution de applications est 
            alors deux fois supérieure à celle de l’Apple A8 de l’iPhone 6 et le SoC consomme jusqu’à cinq fois moins 
            d’énergie.")
            ->setPrice("49990")
            ->setStock("9");
        $product->addClient($this->getReference('client1'));
        $manager->persist($product);
        $this->addReference("I00003_128A", $product);

        $product = new Product();
        $product
            ->setName("iPhone 7 256Go Noir")
            ->setReference("I00004_256N")
            ->setDescription("L’iPhone 7 est le dernier né de la célèbre gamme de smartphones d’Apple. Si 
            celui-ci reprend les mêmes dimensions et à peu près le même aspect que son prédécesseur l’iPhone 6s, il le 
            surpasse de loin. En effet, un iPhone 7 noir 128 go embarque plusieurs innovations, que ce soit au niveau du 
            chipset, de l’écran, des capteurs photographiques et de l’iPhone en lui-même. Sous sa belle coque élégante, 
            l’iPhone 7 cache un redoutable chipset, qui est l’Apple A10 Fusion. Son processeur central intègre deux cœurs 
            à haute performance et deux cœurs à haute efficacité énergétique. La vitesse d’exécution de applications est 
            alors deux fois supérieure à celle de l’Apple A8 de l’iPhone 6 et le SoC consomme jusqu’à cinq fois moins 
            d’énergie.")
            ->setPrice("49990")
            ->setStock("11");
        $product->addClient($this->getReference('client1'));
        $manager->persist($product);
        $this->addReference("I00004_256N", $product);

        $product = new Product();
        $product
            ->setName("iPhone 7 256Go Rose")
            ->setReference("I00005_256R")
            ->setDescription("L’iPhone 7 est le dernier né de la célèbre gamme de smartphones d’Apple. Si 
            celui-ci reprend les mêmes dimensions et à peu près le même aspect que son prédécesseur l’iPhone 6s, il le 
            surpasse de loin. En effet, un iPhone 7 noir 128 go embarque plusieurs innovations, que ce soit au niveau du 
            chipset, de l’écran, des capteurs photographiques et de l’iPhone en lui-même. Sous sa belle coque élégante, 
            l’iPhone 7 cache un redoutable chipset, qui est l’Apple A10 Fusion. Son processeur central intègre deux cœurs 
            à haute performance et deux cœurs à haute efficacité énergétique. La vitesse d’exécution de applications est 
            alors deux fois supérieure à celle de l’Apple A8 de l’iPhone 6 et le SoC consomme jusqu’à cinq fois moins 
            d’énergie.")
            ->setPrice("49990")
            ->setStock("15");
        $product->addClient($this->getReference('client1'));
        $manager->persist($product);
        $this->addReference("I00005_256R", $product);

        $product = new Product();
        $product
            ->setName("iPhone 7 256Go Argent")
            ->setReference("I00006_256A")
            ->setDescription("L’iPhone 7 est le dernier né de la célèbre gamme de smartphones d’Apple. Si 
            celui-ci reprend les mêmes dimensions et à peu près le même aspect que son prédécesseur l’iPhone 6s, il le 
            surpasse de loin. En effet, un iPhone 7 noir 128 go embarque plusieurs innovations, que ce soit au niveau du 
            chipset, de l’écran, des capteurs photographiques et de l’iPhone en lui-même. Sous sa belle coque élégante, 
            l’iPhone 7 cache un redoutable chipset, qui est l’Apple A10 Fusion. Son processeur central intègre deux cœurs 
            à haute performance et deux cœurs à haute efficacité énergétique. La vitesse d’exécution de applications est 
            alors deux fois supérieure à celle de l’Apple A8 de l’iPhone 6 et le SoC consomme jusqu’à cinq fois moins 
            d’énergie.")
            ->setPrice("49990")
            ->setStock("10");
        $product->addClient($this->getReference('client1'));
        $manager->persist($product);
        $this->addReference("I00006_256A", $product);

        $manager->flush();
    }
}
