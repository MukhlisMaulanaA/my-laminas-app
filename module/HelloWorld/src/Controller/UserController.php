<?php

namespace HelloWorld\Controller;

use Laminas\View\Model\ViewModel;
use Laminas\Authentication\AuthenticationService;
use Laminas\Mvc\Controller\AbstractActionController;

class UserController extends AbstractActionController
{
  private $authService;

  public function __construct(AuthenticationService $authService)
  {
    $this->authService = $authService;
  }

  public function profileAction()
  {
    // Cek apakah pengguna sudah login
    if (!$this->authService->hasIdentity()) {
      // Jika belum login, redirect ke halaman login
      return $this->redirect()->toRoute('login');
    }

    // Ambil identitas pengguna dari session
    $identity = $this->authService->getIdentity();

    // Render halaman profil jika pengguna sudah login
    return new ViewModel([
      'username' => $identity->getUsername(),
      'role' => $identity->getRole(),
    ]);
  }
}
