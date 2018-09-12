<?php
/**
 * Created by PhpStorm.
 * User: pdolinaj
 * Date: 12/09/18
 * Time: 20:42
 */

namespace App\Controller\Api\v1;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class TokenController extends Controller
{

    public function newTokenAction(Request $request)
    {
        //get username from POST or if user is logged in use getUser()
        $username = $request->get('username', $request->getUser());
        //get username from POST or if user is logged in use getPassword()
        $password = $request->get('password', $request->getPassword());

        $user = $this->getDoctrine()
            ->getRepository('App:User')
            ->findOneBy(['username' => $username]);

        if (!$user) {
            throw $this->createNotFoundException();
        }

        $isValid = $this->get('security.password_encoder')
            ->isPasswordValid($user, $password);

        if (!$isValid) {
            throw new BadCredentialsException();
        }

        $token = $this->get('lexik_jwt_authentication.encoder')
            ->encode([
                'username' => $user->getUsername(),
                'exp' => time() + 3600 // 1 hour expiration
            ]);
        return new JsonResponse(['token' => $token]);
    }
}