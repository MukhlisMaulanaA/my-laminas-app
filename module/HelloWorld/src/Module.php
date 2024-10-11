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

  public function onBootstrap(MvcEvent $e)
  {
    $eventManager = $e->getApplication()->getEventManager();
    $eventManager->attach(MvcEvent::EVENT_DISPATCH, [$this, 'checkAuthorization'], 100);
  }

  public function checkAuthorization(MvcEvent $e)
  {
    $route = $e->getRouteMatch()->getMatchedRouteName();
    $authService = new AuthenticationService();
    $rbac = $this->getRbac();

    // Default role untuk pengguna yang belum login
    $role = 'guest';

    // Jika pengguna sudah login, gunakan role dari identitas yang tersimpan di session
    if ($authService->hasIdentity()) {
      $identity = $authService->getIdentity();
      $role = $identity->role;  // Ambil peran dari session atau database
    }

    // Batasi akses ke route /admin (hanya admin yang bisa mengakses)
    if ($route === 'admin') {
      if (!$rbac->isGranted($role, 'manage-users')) {
        var_dump("Access denied to admin page for role: $role");
        // Jika pengguna tidak memiliki izin, arahkan ke halaman login
        return $e->getTarget()->redirect()->toRoute('login');
      }
    }

    // Batasi akses untuk route lain, misalnya route untuk user atau guest
    if ($route === 'profile') {
      if (!$rbac->isGranted($role, 'view-profile')) {
        return $e->getTarget()->redirect()->toRoute('login');
      }
    }
  }

  public function getRbac()
  {
    $rbac = new Rbac();

    // Peran guest tanpa izin khusus
    $guest = new Role('guest');
    $rbac->addRole($guest);

    // Peran user dengan izin 'view-profile'
    $user = new Role('user');
    $user->addPermission('view-profile');
    $rbac->addRole($user, 'guest'); // User mewarisi izin dari guest

    // Peran admin dengan izin tambahan 'manage-users'
    $admin = new Role('admin');
    $admin->addPermission('view-profile');
    $admin->addPermission('manage-users'); // Hanya admin yang bisa mengelola user
    $rbac->addRole($admin, 'user'); // Admin mewarisi izin dari user

    return $rbac;
  }


}
