<?php

namespace App\Controller;

use App\Entity\Users;
use App\Entity\Vendeurs;
use App\Repository\RoleRepository;
use App\Repository\UsersRepository;
use App\Repository\VendeursRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\MediaObjectRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class VendeursController extends AbstractController
{

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
    
    $this->encoder = $encoder;
    }
    /**
     * @Route("/new/vendeurs", name="vendeurs", methods={"POST"})
     */
    public function newCompte(Request $request, EntityManagerInterface $manager,UserPasswordEncoderInterface $passwordEncode,RoleRepository $roleRepository,UsersRepository $userRepository,VendeursRepository $VendeursRepository)
    {
     
        $values = json_decode($request->getContent());
        $dateJours = new \DateTime();
        $user = new Users();
        $Vendeurs= new Vendeurs();
        $role = $roleRepository->findOneBy(array('Libelle' => 'ROLE_VENDEUR'));
      
      
        $user = new Users();
        $user->setUsername($values->username);
        $user->setRole($role);
        $user->setPassword($this->encoder->encodePassword($user,$values->password));
        $user->setPrenom($values->prenom);
        $user->setNom($values->nom);
        $user->getRoles();
      
        $Vendeurs->setAdresseVendeur($values->adresse_vendeur)
        ->setTelVendeur($values->tel_vendeur)
        ->setCNI($values->CNI)
        ->SetUsers($user)
        ->getUsers();
       

                 $manager->persist($user);
                 $manager->persist($Vendeurs);
                 $manager->flush();

               $data = [
                'status' => 201,
                'message' => 'création compte réussi'];
    
                return new JsonResponse($data, 201);
                



        }

    




      
}
