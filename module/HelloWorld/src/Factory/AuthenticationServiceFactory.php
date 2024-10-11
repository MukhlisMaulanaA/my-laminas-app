<?php

namespace HelloWorld\Factory;

use Psr\Container\ContainerInterface;
use HelloWorld\Authentication\AuthAdapter;
use Laminas\Authentication\Storage\Session;
use Laminas\Authentication\AuthenticationService;

class AuthenticationServiceFactory
{
  public function __invoke(ContainerInterface $container)
  {
    // Ambil UserTable dari service manager
    $userTable = $container->get('UserTable');

    // Buat AuthAdapter menggunakan UserTable
    $authAdapter = new AuthAdapter($userTable);

    // Gunakan storage berbasis session
    $authStorage = new Session('Auth');

    // Buat dan return AuthenticationService
    return new AuthenticationService($authStorage, $authAdapter);
  }
}