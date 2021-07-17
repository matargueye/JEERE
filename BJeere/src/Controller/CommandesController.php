<?php

namespace App\Controller;


use App\Entity\Commandes;
use App\Entity\CommandesProduits;
use App\Repository\LivreursRepository;
use App\Repository\ProduitsRepository;
use App\Repository\CommandesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\CommandesProduitsRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CommandesController extends AbstractController
{   
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        
    $this->tokenStorage = $tokenStorage;

    }
    /**
     * 
     * @Route("/api/add/commande", name="commandes",methods={"POST"})
     */
    public function newCommande(Request $request,EntityManagerInterface $manager,CommandesRepository $CommandeRepository,LivreursRepository $livreurs,ProduitsRepository $ProduitsRepository)
    {
     
   
        $values = json_decode($request->getContent());
        $commande_id = $this->getLastId() + 1 ;
        $numCommande =str_pad($commande_id, 9 ,"0",STR_PAD_LEFT);
        $user = $this->tokenStorage->getToken()->getUser();
        $dateJours = new \DateTime();
        $time =  $dateJours->format('H:i');
      
        
        $commande=new Commandes();
        $commande->setDateCommande($dateJours);
        $commande->setNumcommande( $numCommande );
        $commande->setEtat(0);
        $commande->setUser( $user);
       
      
      
     
        $manager->persist($commande);
   
        $produits=array_count_values($values->produit);
       
        $resultat=[];

        foreach($produits as $key=>$value){
            $resultat[]=[
            "produit"=> $ProduitsRepository->find($key),
            "quantite"=>$value
        ];
        $commandeProduit= new CommandesProduits();
        $commandeProduit->setcommande($commande);
        foreach( $resultat as $key =>$val){
         
       
        $commandeProduit->setQuantite($val['quantite']);  
        $commandeProduit->setProduit($val['produit']);  
        
       
        }
        $manager->persist( $commandeProduit); 
        }
        $manager->flush();

        $data = [
        'status' => 201,
        'message' => 'commade envoyer'];

        return new JsonResponse($data, 201);
        }
        public function getLastId() 
        {
        $repository = $this->getDoctrine()->getRepository(Commandes::class);
        // look for a single Product by name
        $res = $repository->findBy([], ['id' => 'DESC']) ;
        if($res == null){
        return 0;
        }else{
        return $res[0]->getId();
            }
        }


         /**
     * @Route("/api/liste/commandes", name="liste_commandes",methods={"GET"})
     */
    public function ListeCommande(Request $request,SerializerInterface $serializer,EntityManagerInterface $manager,CommandesRepository $CommandesRepository ,CommandesProduitsRepository $CommandesProduitsRepository):Response
    {
        $id = $this->tokenStorage->getToken()->getUser()->getId();
        $data = $CommandesRepository->FinByUser($id);
      
        $resultat=[];
        foreach (array_unique( $data , SORT_REGULAR) as $value) {
        $resultat[]=$value;
        
     }
        $commandes = $serializer->serialize($resultat, 'json');
    
        
        return new Response( $commandes, 200, [
            'Content-Type' => 'application/json'
        ]);
    }



    /**
    * @Route("/api/commandes/{id}", name="edit_commande", methods={"DELETE"}))
    * 
     */
    public function edite(Request $request, EntityManagerInterface $manager, $id ,CommandesRepository $CommandeRepository, CommandesProduitsRepository $CommandesProduitsRepository)
    {

    
      $commande =$CommandeRepository->Delete($id);

      $data = [

        'status' => 201,
        'message' => 'Commande anuler avec succes. '
    ];

    return new JsonResponse($data, 201);

    }

}
