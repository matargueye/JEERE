<?php

namespace App\Controller;

use App\Entity\Users;
use App\Entity\Clients;
use App\Repository\RoleRepository;
use App\Repository\UsersRepository;
use App\Repository\ClientsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ClientController extends AbstractController
{


    public function __construct(TokenStorageInterface $tokenStorage,UserPasswordEncoderInterface $encoder)

    {
    $this->tokenStorage = $tokenStorage;
    $this->encoder = $encoder;
    }
    /**
    * @Route("/new/clients", name="clients", methods={"POST"}))
    * 
     */
    public function newCompte(Request $request, EntityManagerInterface $manager,UserPasswordEncoderInterface $passwordEncode,RoleRepository $roleRepository,UsersRepository $userRepository,ClientsRepository $ClientsRepository)
    {
     
        $values = json_decode($request->getContent());
        $user = new Users();
        $client = new Clients();
     
        $role = $roleRepository->findOneBy(array('Libelle' => 'ROLE_CLIENT'));
        $client_existant = $ClientsRepository->findOneBy(array('username' => $values->username));
        
        if ( $client_existant = null) {
    #   $user = new Users();
        $user->setUsername($values->username);
        $user->setRole($role);
        $user->setPassword($this->encoder->encodePassword($user,$values->password));
        $user->setPrenom($values->prenom);
        $user->setNom($values->nom);
        $user->getRoles();
    
        $client->setAdresseClient($values->adresse_client)
        ->setTelClient($values->tel_client)
        ->SetUsers($user)
        ->getUsers();
        $manager->persist($user);
        $manager->persist($client);
        $manager->flush();

        $data = [
        'status' => 201,
        'message' => 'création compte réussi'];

        return new JsonResponse($data, 201);
            

          }else {
            $data = [
                'status' => 500,
                'message' => 'Ce nom d \'utilisateur exite '];
        
                return new JsonResponse($data, 201);
              
          }
        
        }
    /**
    * @Route("/api/clients/edit", name="edit_clients", methods={"PUT"}))
    * 
     */
    public function edite(Request $request, EntityManagerInterface $manager,UserPasswordEncoderInterface $passwordEncode,RoleRepository $roleRepository,UsersRepository $userRepository,ClientsRepository $ClientsRepository)
    {

      $values = json_decode($request->getContent());
      $userConnecte = $this->tokenStorage->getToken()->getUser();
      $user = $userRepository->find($userConnecte);
      $client = $ClientsRepository->findOneBy(["users" => $user]);
      
      foreach ($values as $key => $value){
          if($key && !empty($value)) {
              if (property_exists(Users::class, $key)) {
                  $name = ucfirst($key);
                  $setter = 'set'.$name;
                  $user->$setter($value);
                
                  
              }
          }
      }
      foreach ($values as $key => $value){
          if($key && !empty($value)) {
              if (property_exists(Clients::class, $key)) {
                  $name = ucfirst($key);
                  $setter = 'set'.$name;
                  $client->$setter($value);
                  dd($client);
              }
          }
      }
      
      $manager->flush();
      $data = [

          'status' => 201,
          'message' => 'Compte  modifié avec succes. '
      ];

      return new JsonResponse($data, 201);

    }


}
