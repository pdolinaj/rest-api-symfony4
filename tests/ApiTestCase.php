<?php
/**
 * Created by PhpStorm.
 * User: pdolinaj
 * Date: 12/09/18
 * Time: 11:16
 */

namespace App\Tests;

//Access Services: https://symfony.com/blog/new-in-symfony-4-1-simpler-service-testing
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
//use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\User;

use GuzzleHttp\Client;

class ApiTestCase extends WebTestCase
{
    private static $staticClient;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * @var Client
     */
    protected $client;

    public static function setUpBeforeClass()
    {
        self::$staticClient = new Client([
            'base_uri' => 'http://rest-symfony4.local'
        ]);
    }

    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->client = self::$staticClient;

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     * @param $username
     * @param string $plainPassword
     * @return User
     */
    protected function createUser($username, $plainPassword = 'VerySecurePassword')
    {
        $user = new User($username);
        $password = self::$kernel->getContainer()->get('security.password_encoder')
            ->encodePassword($user, $plainPassword);
        $user->setPassword($password);
        $em = $this->entityManager;
        $em->persist($user);
        $em->flush();
        return $user;
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null; // avoid memory leaks
    }
}
