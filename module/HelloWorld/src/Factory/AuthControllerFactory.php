<?php

namespace HelloWorld\Factory;

use Psr\Container\ContainerInterface;
use HelloWorld\Controller\AuthController;
use HelloWorld\Model\UserTable;
use Laminas\Authentication\AuthenticationService;
use Laminas\ServiceManager\Factory\FactoryInterface;

class AuthControllerFactory implements FactoryInterface
{
  public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
  {
    // Ambil AuthenticationService dari service manager
    $authService = $container->get(AuthenticationService::class);

    $userTable = $container->get(UserTable::class);

    // Return instance AuthController dengan AuthenticationService
    return new AuthController($authService, $userTable);
  }
}