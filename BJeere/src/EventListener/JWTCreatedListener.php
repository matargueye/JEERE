<?php
namespace App\EventListener;


use App\Repository\UsersRepository;
use App\Repository\ClientsRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JWTCreatedListener
{  
    /**
     * @var RequestStack
     */
    private $requestStack;
    private $restoRepository;
    private $userRepository;
    private $clientsRepository;
    /**
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack, UsersRepository $userRepository,ClientsRepository $ClientsRepository)
    {
        $this->requestStack = $requestStack;
        $this->userRepository = $userRepository;
      
    }
    /**
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
       
        /** @var $user \AppBundle\Entity\User */

        $user = $event->getUser();
    
      
        if($user->getRole()->getLibelle() == "ROLE_CLIENT"){
         
           
            $data = $this->userRepository->findOneBy(["id" => $user]);
           
    
            $payload = array_merge(
                $event->getData(),
                    [
                        'nom' => $data->getNom(),
                        'prenom' => $data->getPrenom()
                    ]
            );

            $event->setData($payload);
            
        }
       
  
    }   
}