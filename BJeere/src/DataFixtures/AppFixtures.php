<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\Users;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $role_admin_systeme= new Role();
        $role_admin_systeme->setLibelle("ROLE_ADMIN");
   
        $manager->persist( $role_admin_systeme);
        $manager->flush();  

        $role_vendeur = new Role();
        $role_vendeur->setLibelle("ROLE_VENDEUR");
     
        $manager->persist( $role_vendeur);
        $manager->flush();

        $role_livreur= new Role();
        $role_livreur->setLibelle("ROLE_LIVREUR");
       
        $manager->persist( $role_livreur);
        $manager->flush();  

        $role_client= new Role();
        $role_client->setLibelle("ROLE_CLIENT");
         
        $manager->persist( $role_client);
        $manager->flush();  


        $user = new Users();
        $user->setUsername("pendabbalde@gmail.com");
        $user->setRole($role_admin_systeme);
        $user->setPassword($this->encoder->encodePassword($user,'balde'));
        $user->setPrenom("penda");
        $user->setNom("balde");
        $manager->persist($user);
        $user->getRoles();
        
        $manager->flush();

    }
}
