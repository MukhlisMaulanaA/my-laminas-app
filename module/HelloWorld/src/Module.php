<?php

declare(strict_types=1);

namespace HelloWorld;

use Laminas\Mvc\MvcEvent;
use HelloWorld\Middleware\AuthMiddleware;

class Module
{
  public function getConfig(): array
  {
    /** @var array $config */
    $config = include __DIR__ . '/../config/module.config.php';
    return $config;
  }

  // public function onBootstrap(MvcEvent $e)
  // {
  //   $eventManager = $e->getApplication()->getEventManager();
  //   $eventManager->attach(MvcEvent::EVENT_ROUTE, [new AuthMiddleware(), 'handle']);
  // }

}
