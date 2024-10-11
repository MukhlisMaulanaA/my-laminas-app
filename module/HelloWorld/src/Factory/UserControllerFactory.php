<?php

namespace HelloWorld\Factory;

use Psr\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use HelloWorld\Controller\UserController;
use Laminas\Authentication\AuthenticationService;

class UserControllerFactory implements FactoryInterface
{
  public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
  {
    $authService = $container->get(AuthenticationService::class);
    return new UserController($authService);
  }
}
