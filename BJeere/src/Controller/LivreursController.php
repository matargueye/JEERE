<?php

namespace App\Controller;

use App\Entity\Users;
use App\Entity\Livreurs;
use App\Repository\RoleRepository;
use App\Repository\UsersRepository;
use App\Repository\VillesRepository;
use App\Repository\LivreursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class LivreursController extends AbstractController
{

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
    
    $this->encoder = $encoder;
    }
    /**
     * @Route("/new/livreurs", name="livreurs")
     */
    public function newCompte(Request $request, EntityManagerInterface $manager,UserPasswordEncoderInterface $passwordEncode,RoleRepository $roleRepository,UsersRepository $userRepository,LivreursRepository $LivreursRepository,VillesRepository $VillesRepository)
    {
     
        $values = json_decode($request->getContent());
        $dateJours = new \DateTime();
        $user = new Users();
        $Livreurs= new Livreurs;
        $role = $roleRepository->findOneBy(array('Libelle' =>'ROLE_LIVREUR'));
        $ville=$VillesRepository->findOneBy(array('id' =>$values->ville));
         
        $user = new Users();
        $user->setUsername($values->username);
        $user->setRole($role);
        $user->setPassword($this->encoder->encodePassword($user,$values->password));
        $user->setPrenom($values->prenom);
        $user->setNom($values->nom);
        $user->getRoles();
        $manager->persist($user);
        $Livreurs->setAdresseLivreur($values->adresse_livreur);
        $Livreurs ->setTelLivreur($values->tel_livreur);
        $Livreurs->SetUsers($user);
        $Livreurs->setVille($ville);
        $Livreurs-> setCNI($values->cni);
      
       
        
     
        $manager->persist($Livreurs);
        $manager->flush();

        $data = [
       'status' => 201,
       'message' => 'commande envoyer'];

       return new JsonResponse($data, 201);
       
      
      
       

             
               



        }
}
