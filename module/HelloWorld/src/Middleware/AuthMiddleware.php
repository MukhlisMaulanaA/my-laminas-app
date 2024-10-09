<?php

namespace HelloWorld\Middleware;

use Laminas\Authentication\AuthenticationService;
use Laminas\Mvc\MvcEvent;
use Laminas\Router\RouteMatch;

class AuthMiddleware
{
  public function __invoke(MvcEvent $event)
  {
    $authService = new AuthenticationService();
    $identity = $authService->getIdentity();

    $routeMatch = $event->getRouteMatch();
    $controller = $routeMatch->getParam('controller');
    $action = $routeMatch->getParam('action');

    // Contoh: Membatasi akses ke halaman admin
    if ($controller === 'AdminController' && !$identity->role === 'admin') {
      return $event->getTarget()->redirect()->toRoute('login');
    }
  }
}
