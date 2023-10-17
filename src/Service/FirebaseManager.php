<?php
namespace App\Service;

use Exception;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Exception\FirebaseException;

class FirebaseManager 
{
    private $firebase;

    public function __construct()
    {
        // We get the firebase parameters
   
        $firebase = (new Factory)
            ->withServiceAccount(__DIR__ . '/../../google-service-account.json')
            ->createAuth();
          $this->firebase = $firebase;  
    }
    
    public function verifyTokenAndUid($token, $uid)
    {
        $auth = $this->firebase;
        try {
            $verifiedIdToken = $auth->verifyIdToken($token);
        } catch (FirebaseException $e) {
            echo 'The token is invalid: '.$e->getMessage();
        }
        
       $uid = $verifiedIdToken->claims();
        
        $user = $auth->getUser($uid);
}


}