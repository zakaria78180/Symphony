<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Album;
use App\Entity\Artiste;
use App\Entity\Morceau;
use App\Entity\Style;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker=Factory::create("fr_FR");

        $lesStyles=$this->chargeFichier("style.csv");
        foreach ($lesStyles as $key => $value){
            $style=new Style();
            $style    ->setId(intval($value[0]))
                        ->setNom($value[1])
                        ->setCouleur($faker->safeColorName());
            $manager->persist($style);
            $this->addReference("style".$style->getId(),$style);
        }

        $lesArtistes=$this->chargeFichier("artiste.csv");


        $genre=["men", "women"];
        foreach ($lesArtistes as $key => $value){
            $artiste=new Artiste();
            $artiste    ->setId(intval($value[0]))
                        ->setNom($value[1])
                        ->setDescription("<p>". join("</p><p>",$faker->paragraphs(5)). "</p>")
                        ->setSite($faker->url())
                        ->setImage('https://randomuser.me/api/portraits/'.$faker->randomElement($genre)."/".mt_rand(1,99).".jpg")
                        ->SetType($value[2]);
            $manager->persist($artiste);
            $this->addReference("artiste".$artiste->getId(),$artiste);
        }
        $lesAlbums=$this->chargeFichier("album.csv");
        foreach ($lesAlbums as $value){
            $album=new Album();
            $album ->setId(intval($value[0]))
                   ->setNom($value[1])
                   ->setDate(intval($value[2]))
                   ->setImage($faker->imageUrl(640,480))
                   ->addStyle($this->getReference("style".$value[3]))
                   ->setArtiste($this->getReference("artiste".$value[4]));
            $manager->persist($album);
            $this->addReference("album".$album->getId(), $album );
        }
        
        $lesMorceaux = $this->chargeFichier("morceau.csv");
        foreach ($lesMorceaux as $value){
            $morceau=new Morceau();
            $morceau ->setId (intval($value[0]))
                   ->setTitre ($value[2])
                   ->setAlbum($this->getReference("album".$value[1]))
                   ->setDuree(date("i:s"), $value[3]);
            $manager->persist($morceau);
            $this->addReference("morceau".$morceau->getId(), $morceau );
        }
        $manager->flush();
    }
    public function chargeFichier($fichier){
        $fichierCsv=fopen(__DIR__."/". $fichier,"r");
        while (!feof($fichierCsv)){
            $data[]=fgetcsv($fichierCsv);
        }
        fclose($fichierCsv);
        return $data;
        
        
    }
}