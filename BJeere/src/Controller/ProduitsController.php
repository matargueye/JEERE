<?php

namespace App\Controller;

use App\Entity\Produits;
use App\Repository\UsersRepository;
use App\Repository\ProduitsRepository;
use App\Repository\VendeursRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SoucategorieRepository;
use App\Repository\CategorieProduiRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ProduitsController extends AbstractController
{

    public function __construct(TokenStorageInterface $tokenStorage,UserPasswordEncoderInterface $encoder)
    {
        
    $this->tokenStorage = $tokenStorage;
    $this->encoder = $encoder;
    }
    /**
     * @Route("api/ajout/produits", name="produits",methods={"POST"})
    
     */
    
    public function AjoutProduit(Request $request, EntityManagerInterface $manager,UserPasswordEncoderInterface $passwordEncode,ProduitsRepository $ProduitsRepository,CategorieProduiRepository $CategorieRepository,VendeursRepository $VendeurRepository,UsersRepository $UserRepository,SoucategorieRepository $soucategorieRepository)
    {
     
        $user = $this->tokenStorage->getToken()->getUser();
        $values = json_decode($request->getContent());
        $vendeur=$VendeurRepository->findOneBy(array('users' => $user));
        //$categories =$CategorieRepository->findOneBy(array('id'=>$values->categorie));
        //$typeproduits=$typeProduitRepository->findOneBy(array('id'=>$values->type_produit));

        $dateJours = new \DateTime();
        $Produits= new Produits;
        $image = $request->files->get("image");
        

        $image = fopen($image->getRealPath(),"rb");
        $nom = $request->request->all()["designation"];
        $prix_unitaire = $request->request->all()["prixunitaire"];
        $quantite_stock = $request->request->all()["quantitestock"];
        $caracteristique = $request->request->all()["caracteristique"];
        $description = $request->request->all()["description"];
        $isActive= $request->request->all()["isActive"];
        $categorie=$request->request->all()["categorie"];

        $categories =$CategorieRepository->findOneBy(array('id'=>$categorie));
        $soucategorie=$request->request->all()["soucategorie"];
        $soucategorie=$soucategorieRepository->findOneBy(array('id'=>$soucategorie));

        $Produits->setDesignation($nom);
        $Produits->setPrixunitaire($prix_unitaire);

        
        $Produits->setQuantitestock($quantite_stock);
        $Produits->setCaracteristique($caracteristique);
        $Produits->setDescription($description);
        $Produits->setCategorie($categories);
        $Produits->setDateAjout( $dateJours);
        $Produits->setIsActive($isActive);
        $Produits->setSoucategorie($soucategorie);
        $Produits->setImage($image);
         
        $Produits->setVendeur( $vendeur);
        $Produits->setDateAjout($dateJours);
     
    
                 $manager->persist($Produits);
                 $manager->flush();
                 fclose($image);
      

               $data = [
                'status' => 201,
                'message' => 'produit ajouter'];
    
                return new JsonResponse($data, 201);
                
     

        }
    /**
     * @Route("/liste/produits", name="list" ,methods={"GET"})
     */
    public function index( SerializerInterface $serializer,EntityManagerInterface $manager,UserPasswordEncoderInterface $passwordEncode,ProduitsRepository $ProduitsRepository,CategorieProduiRepository $CategorieRepository,VendeursRepository $VendeurRepository,UsersRepository $UserRepository ): Response
    {
        $data = $ProduitsRepository->findAll();
       
        $images = [];
        foreach ($data as $key => $entity) {
           // $images[$key] = base64_encode(stream_get_contents($entity->getImage()));
            $entity->setImage((base64_encode(stream_get_contents($entity->getImage()))));
        }
        
        $images= $serializer->serialize($data, 'json');

        return new Response($images, 200, [
            'Content-Type' => 'application/json'
        ]);

    }

    /**
     * @Route("/liste/produits/{id}", name="list_id" ,methods={"GET"})
     */
    public function Produit($id, SerializerInterface $serializer,EntityManagerInterface $manager,UserPasswordEncoderInterface $passwordEncode,ProduitsRepository $ProduitsRepository,CategorieProduiRepository $CategorieRepository,VendeursRepository $VendeurRepository,UsersRepository $UserRepository): Response
    {
        $data = $ProduitsRepository->findAll($id);
       
        $images = [];
        foreach ($data as $key => $entity) {
           // $images[$key] = base64_encode(stream_get_contents($entity->getImage()));
            $entity->setImage((base64_encode(stream_get_contents($entity->getImage()))));
        }
        
        $images= $serializer->serialize($data, 'json');

        return new Response($images, 200, [
            'Content-Type' => 'application/json'
        ]);

    }

    /**
     * @Route("/liste/appareilles", name="appareille" ,methods={"GET"})
     */

    public function CategorieA( SerializerInterface $serializer,EntityManagerInterface $manager,ProduitsRepository $ProduitsRepository): Response
    {
        $data = $ProduitsRepository->findAll();
        $datap=[];
        $images = [];
        foreach ($data as $key => $entity) {
           // $images[$key] = base64_encode(stream_get_contents($entity->getImage()));
      
            
           if ($entity->getCategorie()->getLibelle() == "Appareilles") {
            $datap[] =$entity ;
           }
           $entity->setImage((base64_encode(stream_get_contents($entity->getImage()))));
        }
        
        $images= $serializer->serialize($datap, 'json');

        return new Response($images, 200, [
            'Content-Type' => 'application/json'
        ]);

    }
     /**
     * @Route("/liste/fruits", name="fruit" ,methods={"GET"})
     */
    public function Fruit( SerializerInterface $serializer,EntityManagerInterface $manager,ProduitsRepository $ProduitsRepository): Response
    {
        $data = $ProduitsRepository->findAll();
        $datap=[];
        $images = [];
        foreach ($data as $key => $entity) {
           // $images[$key] = base64_encode(stream_get_contents($entity->getImage()));
      
            
           if ($entity->getCategorie()->getLibelle() == "Fruits" ) {
            $datap[] =$entity ;
           }
           $entity->setImage((base64_encode(stream_get_contents($entity->getImage()))));
        }
        
        $images= $serializer->serialize($datap, 'json');

        return new Response($images, 200, [
            'Content-Type' => 'application/json'
        ]);

    }
     /**
     * @Route("/liste/legumes", name="legume" ,methods={"GET"})
     */

    public function Légume( SerializerInterface $serializer,EntityManagerInterface $manager,ProduitsRepository $ProduitsRepository): Response
    {
        $data = $ProduitsRepository->findAll();
        $datap=[];
        $images = [];
        foreach ($data as $key => $entity) {
           // $images[$key] = base64_encode(stream_get_contents($entity->getImage()));
      
            
           if ($entity->getCategorie()->getLibelle() == "Legumes" ) {
            $datap[] =$entity ;
           }
           $entity->setImage((base64_encode(stream_get_contents($entity->getImage()))));
        }
        
        $images= $serializer->serialize($datap, 'json');

        return new Response($images, 200, [
            'Content-Type' => 'application/json'
        ]);

    }


 /**
     * @Route("/liste/vetement", name="vetement" ,methods={"GET"})
     */

    public function Vetement( SerializerInterface $serializer,EntityManagerInterface $manager,ProduitsRepository $ProduitsRepository): Response
    {
        $data = $ProduitsRepository->findAll();
        $datap=[];
        $images = [];
        foreach ($data as $key => $entity) {
           // $images[$key] = base64_encode(stream_get_contents($entity->getImage()));
      
            
           if ($entity->getCategorie()->getLibelle() == "Vetements" ) {
            $datap[] =$entity ;
           }
           $entity->setImage((base64_encode(stream_get_contents($entity->getImage()))));
        }
        
        $images= $serializer->serialize($datap, 'json');

        return new Response($images, 200, [
            'Content-Type' => 'application/json'
        ]);

    }


 /**
     * @Route("/liste/vetement/homme", name="V_homme" ,methods={"GET"})
     */

    public function VetementHomme( SerializerInterface $serializer,EntityManagerInterface $manager,ProduitsRepository $ProduitsRepository): Response
    {
        $data = $ProduitsRepository->findAll();
        $datap=[];
        $images = [];
        foreach ($data as $key => $entity) {
           // $images[$key] = base64_encode(stream_get_contents($entity->getImage()));
      
            
           if ($entity->getCategorie()->getLibelle() == "Vetements"  && $entity-> getSoucategorie()->getLibelle() == "homme") {
            $datap[] =$entity ;
           }
           $entity->setImage((base64_encode(stream_get_contents($entity->getImage()))));
        }
        
        $images= $serializer->serialize($datap, 'json');

        return new Response($images, 200, [
            'Content-Type' => 'application/json'
        ]);

    
    }
    /**
     * @Route("/liste/vetement/femme", name="V_femme" ,methods={"GET"})
     */

    public function VetementFemme( SerializerInterface $serializer,EntityManagerInterface $manager,ProduitsRepository $ProduitsRepository): Response
    {
        $data = $ProduitsRepository->findAll();
        $datap=[];
        $images = [];
        foreach ($data as $key => $entity) {
           // $images[$key] = base64_encode(stream_get_contents($entity->getImage()));
      
            
           if ($entity->getCategorie()->getLibelle() == "Vetements"  && $entity-> getSoucategorie()->getLibelle() == "femme") {
            $datap[] =$entity ;
           }
           $entity->setImage((base64_encode(stream_get_contents($entity->getImage()))));
        }
        
        $images= $serializer->serialize($datap, 'json');

        return new Response($images, 200, [
            'Content-Type' => 'application/json'
        ]);
    }

     /**
     * @Route("/liste/vetement/enfant", name="V_enfant" ,methods={"GET"})
     */

    public function VetementEnfant( SerializerInterface $serializer,EntityManagerInterface $manager,ProduitsRepository $ProduitsRepository): Response
    {
        $data = $ProduitsRepository->findAll();
        $datap=[];
        $images = [];
        foreach ($data as $key => $entity) {
           // $images[$key] = base64_encode(stream_get_contents($entity->getImage()));
      
            
           if ($entity->getCategorie()->getLibelle() == "Vetements"  && $entity-> getSoucategorie()->getLibelle() == "enfant") {
            $datap[] =$entity ;
           }
           $entity->setImage((base64_encode(stream_get_contents($entity->getImage()))));
        }
        
        $images= $serializer->serialize($datap, 'json');

        return new Response($images, 200, [
            'Content-Type' => 'application/json'
        ]);

    
    }
    // Acessoire

    /**
     * @Route("/liste/accessoire", name="accessoire" ,methods={"GET"})
     */

    public function Acessoire( SerializerInterface $serializer,EntityManagerInterface $manager,ProduitsRepository $ProduitsRepository): Response
    {
        $data = $ProduitsRepository->findAll();
        $datap=[];
        $images = [];
        foreach ($data as $key => $entity) {
           // $images[$key] = base64_encode(stream_get_contents($entity->getImage()));
      
            
           if ($entity->getCategorie()->getLibelle() == "Accessoires" ) {
            $datap[] =$entity ;
           }
           $entity->setImage((base64_encode(stream_get_contents($entity->getImage()))));
        }
        
        $images= $serializer->serialize($datap, 'json');

        return new Response($images, 200, [
            'Content-Type' => 'application/json'
        ]);

    }


 /**
     * @Route("/liste/accessoire/homme", name="accessoire_homme" ,methods={"GET"})
     */

    public function AcessoireHomme( SerializerInterface $serializer,EntityManagerInterface $manager,ProduitsRepository $ProduitsRepository): Response
    {
        $data = $ProduitsRepository->findAll();
        $datap=[];
        $images = [];
        foreach ($data as $key => $entity) {
           // $images[$key] = base64_encode(stream_get_contents($entity->getImage()));
      
            
           if ($entity->getCategorie()->getLibelle() == "Accessoires" && $entity->getSoucategorie()->getLibelle() == "homme" ) {
            $datap[] =$entity ;
           }
           $entity->setImage((base64_encode(stream_get_contents($entity->getImage()))));
        }
        
        $images= $serializer->serialize($datap, 'json');

        return new Response($images, 200, [
            'Content-Type' => 'application/json'
        ]);

    }
    
    
    /**
     * @Route("/liste/accessoire/femme", name="accessoire_femme" ,methods={"GET"})
     */

    public function AcessoireFemme( SerializerInterface $serializer,EntityManagerInterface $manager,ProduitsRepository $ProduitsRepository): Response
    {
        $data = $ProduitsRepository->findAll();
        $datap=[];
        $images = [];
        foreach ($data as $key => $entity) {
           // $images[$key] = base64_encode(stream_get_contents($entity->getImage()));
      
            
           if ($entity->getCategorie()->getLibelle() == "Accessoires" && $entity->getSoucategorie()->getLibelle() == "femme" ) {
            $datap[] =$entity ;
           }
           $entity->setImage((base64_encode(stream_get_contents($entity->getImage()))));
        }
        
        $images= $serializer->serialize($datap, 'json');

        return new Response($images, 200, [
            'Content-Type' => 'application/json'
        ]);

    }
    /**
     * @Route("/liste/accessoire/enfant", name="accessoire_enfant" ,methods={"GET"})
     */

    public function AcessoireEnfant( SerializerInterface $serializer,EntityManagerInterface $manager,ProduitsRepository $ProduitsRepository): Response
    {
        $data = $ProduitsRepository->findAll();
        $datap=[];
        $images = [];
        foreach ($data as $key => $entity) {
           // $images[$key] = base64_encode(stream_get_contents($entity->getImage()));
      
            
           if ($entity->getCategorie()->getLibelle() == "Accessoires" && $entity->getSoucategorie()->getLibelle() == "enfant" ) {
            $datap[] =$entity ;
           }
           $entity->setImage((base64_encode(stream_get_contents($entity->getImage()))));
        }
        
        $images= $serializer->serialize($datap, 'json');

        return new Response($images, 200, [
            'Content-Type' => 'application/json'
        ]);

    }

    // Chaussures

    /**
     * @Route("/liste/chaussure", name="chaussure" ,methods={"GET"})
     */

    public function Chaussure( SerializerInterface $serializer,EntityManagerInterface $manager,ProduitsRepository $ProduitsRepository): Response
    {
        $data = $ProduitsRepository->findAll();
        $datap=[];
        $images = [];
        foreach ($data as $key => $entity) {
           // $images[$key] = base64_encode(stream_get_contents($entity->getImage()));
      
            
           if ($entity->getCategorie()->getLibelle() == " Chaussures" ) {
            $datap[] =$entity ;
           }
           $entity->setImage((base64_encode(stream_get_contents($entity->getImage()))));
        }
        
        $images= $serializer->serialize($datap, 'json');

        return new Response($images, 200, [
            'Content-Type' => 'application/json'
        ]);

    
    }

     /**
     * @Route("/liste/chaussure/homme", name="chaussure_homme" ,methods={"GET"})
     */

    public function ChaussureHomme( SerializerInterface $serializer,EntityManagerInterface $manager,ProduitsRepository $ProduitsRepository): Response
    {
        $data = $ProduitsRepository->findAll();
        $datap=[];
        $images = [];
        foreach ($data as $key => $entity) {
           // $images[$key] = base64_encode(stream_get_contents($entity->getImage()));
      
            
           if ($entity->getCategorie()->getLibelle() == " Chaussures" && $entity->getSoucategorie()->getLibelle() == "homme" ) {
            $datap[] =$entity ;
           }
           $entity->setImage((base64_encode(stream_get_contents($entity->getImage()))));
        }
        
        $images= $serializer->serialize($datap, 'json');

        return new Response($images, 200, [
            'Content-Type' => 'application/json'
        ]);

    
    }


     /**
     * @Route("/liste/chaussure/femme", name="chaussure_femme" ,methods={"GET"})
     */

    public function Chaussurefemme( SerializerInterface $serializer,EntityManagerInterface $manager,ProduitsRepository $ProduitsRepository): Response
    {
        $data = $ProduitsRepository->findAll();
        $datap=[];
        $images = [];
        foreach ($data as $key => $entity) {
           // $images[$key] = base64_encode(stream_get_contents($entity->getImage()));
      
            
           if ($entity->getCategorie()->getLibelle() == " Chaussures" && $entity->getSoucategorie()->getLibelle() == "femme" ) {
            $datap[] =$entity ;
           }
           $entity->setImage((base64_encode(stream_get_contents($entity->getImage()))));
        }
        
        $images= $serializer->serialize($datap, 'json');

        return new Response($images, 200, [
            'Content-Type' => 'application/json'
        ]);

    }

    
     /**
     * @Route("/liste/chaussure/enfant", name="chaussure_enfant" ,methods={"GET"})
     */

    public function Chaussurenfant( SerializerInterface $serializer,EntityManagerInterface $manager,ProduitsRepository $ProduitsRepository): Response
    {
        $data = $ProduitsRepository->findAll();
        $datap=[];
        $images = [];
        foreach ($data as $key => $entity) {
           // $images[$key] = base64_encode(stream_get_contents($entity->getImage()));
      
            
           if ($entity->getCategorie()->getLibelle() == " Chaussures" && $entity->getSoucategorie()->getLibelle() == "enfant" ) {
            $datap[] =$entity ;
           }
           $entity->setImage((base64_encode(stream_get_contents($entity->getImage()))));
        }
        
        $images= $serializer->serialize($datap, 'json');

        return new Response($images, 200, [
            'Content-Type' => 'application/json'
        ]);

    }
}
