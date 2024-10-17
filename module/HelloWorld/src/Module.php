<?php

declare(strict_types=1);

namespace HelloWorld;

use Laminas\Permissions\Rbac\Rbac;
use Laminas\Mvc\MvcEvent;
use Laminas\Authentication\AuthenticationService;
use Laminas\Permissions\Rbac\Role;
use Laminas\Session\Container;

class Module
{
  public function getConfig(): array
  {
    /** @var array $config */
    $config = include __DIR__ . '/../config/module.config.php';
    return $config;
  }


}
