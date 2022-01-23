<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Product;
use App\Entity\Customer;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordEncoder;
    private SluggerInterface $slugger;

    public function __construct(UserPasswordHasherInterface $passwordEncoder, SluggerInterface $slugger )
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->slugger = $slugger;
    }
    public function load(ObjectManager $manager): void
    {
        $admin = new Client;
        $admin->setEmail('admin@bilemo.fr')
            ->setUsername('admin')
            ->setRoles(array('ROLE_ADMIN'))
            ->setPassword($this->passwordEncoder->hashPassword($admin,'password'))
            ->setCompany('Bilemo')
            ->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($admin);

        for ($c=1; $c <=3 ; $c++) { 
            $client = new Client();
            $client->setEmail("client_$c@bilemo.fr")
                ->setUsername("client$c")
                ->setPassword($this->passwordEncoder->hashPassword($client,'password'))
                ->setCompany("Compagnie_$c")
                ->setCreatedAt(new \DateTimeImmutable());

            $manager->persist($client);

            for ($i=1; $i <= mt_rand(3,10) ; $i++) { 
                $customer = new Customer();
                $customer->setEmail("customer_$c-$i@bilemo.fr")
                    ->setFirstname("Firstname_$c-$i")
                    ->setLastname("lastname_$c-$i")
                    ->setClient($client)
                    ->setCreatedAt(new \DateTimeImmutable());

                $manager->persist($customer);
            }

        }
        for ($p=1; $p <=10 ; $p++) { 

            $product = new Product();
            $product->setName("Phone_$p")
                ->setDescription("Phone_$p description")
                ->setManufacturer("Manufacturer_$p : Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer viverra aliquam elit vel mollis.")
                ->setPrice(mt_rand(100, 1200))
                ->setCreatedAt(new \DateTimeImmutable())
                ->setStorage(mt_rand(32,512))
                ->setColor("Color_$p")
                ->setSlug($this->slugger->slug(strtolower($product->getName())). '-' .uniqid())
                ->setScreen(mt_rand(3,7))
                ->setDas(0.970)
                ->setWeight(mt_rand(80,200))
                ->setLenght(14.67)
                ->setWidht(7.15)
                ->setHeight(0.77);

            $manager->persist($product);
        }
        
        $manager->flush();
    }
}
