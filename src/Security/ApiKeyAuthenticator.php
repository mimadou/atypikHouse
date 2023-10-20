<?php

// src/Security/ApiKeyAuthenticator.php
namespace App\Security;
// require __DIR__.'/vendor/autol

use App\Enum\UserType;
use App\Repository\AccountRepository;
use App\Repository\SuperAdminRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Kreait\Firebase\Factory;

class ApiKeyAuthenticator extends AbstractAuthenticator
{

    private $firebase;
    private $account;
    private $admin;
    

    public function __construct( UserRepository $account, SuperAdminRepository $admin)
    {
        $firebase = (new Factory)->withServiceAccount(__DIR__ .'/atypick-house-firebase-adminsdk-g69x3-4ef0e33028.json')->createAuth();
        $this->firebase = $firebase;;
        $this->account = $account;
        $this->admin = $admin;
    }
    /**
     * Called on every request to decide if this authenticator should be
     * used for the request. Returning `false` will cause this authenticator
     * to be skipped.
     */
    public function supports(Request $request): ?bool
    {
        return $request->headers->has('Authorization');
        // || $request->headers->has('authorization');
        // dd("you are here");
        // return true;
    }

    public function authenticate(Request $request): Passport
    {
        $apiToken = $request->headers->get('Authorization');
       

        if (null === $apiToken) {
            throw new CustomUserMessageAuthenticationException('No API token provided');
        }

        return new SelfValidatingPassport(new UserBadge($apiToken, function($apiToken){
            
            $typeOfUser = null;
            $token = null;

            preg_match('/^('.UserType::CLIENT.'|'.UserType::OWNER.'|'.UserType::ADMIN.'|'.UserType::SUPERADMIN.')/', $apiToken, $matches);
            if(isset($matches[0])){
                $typeOfUser = $matches[0];
                $token = str_replace($typeOfUser.' ', '', $apiToken);  
            }

            
            if ($typeOfUser === 'superAdmin') {
                $admin = $this->admin->findOneBy(['uid' => $token]);
                if ($admin != null) {
                    return $admin;
                }
            }
            
            $uid = $this->verifyTokenAndGetUid($token);
            $user = $this->account->findUsersOfTypeWithUID(UserType::getClassTypeFromUserType($typeOfUser), $uid);
            // dd($user);
            if (!$user) {
                throw new UserNotFoundException();
            }
            return $user;
        }));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        
        $data = [
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())
        ];
        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    public function verifyTokenAndGetUid(string $token)
    {
        // $firebase = Auth::verifyIdToken($token)->claims()->get('sub');
        // dd($firebase);
        $uid =  $this->firebase->verifyIdToken($token)->claims()->get('sub');     
        // $user = $this->firebase->getUser($uid);
        return $uid;
    }

}