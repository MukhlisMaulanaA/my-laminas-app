<?php

namespace HelloWorld\Controller;

use Laminas\View\Model\ViewModel;
use Laminas\Authentication\AuthenticationService;
use Laminas\Mvc\Controller\AbstractActionController;

class AdminController extends AbstractActionController
{
  private $authService;

  public function __construct(AuthenticationService $authService)
  {
    $this->authService = $authService;
  }

  public function adminAction()
  {
    // Cek apakah pengguna sudah login
    if (!$this->authService->hasIdentity()) {
      // Jika belum login, redirect ke halaman login
      return $this->redirect()->toRoute('login');
    }

    // Ambil identitas pengguna dari session
    $identity = $this->authService->getIdentity();

    // Cek apakah role pengguna adalah 'admin'
    if ($identity->getRole() !== 'admin') {
      // Jika role bukan admin, redirect atau tampilkan pesan akses ditolak
      return $this->redirect()->toRoute('hello');
    }

    // Render halaman admin jika role adalah admin
    return new ViewModel([
      'message' => 'Welcome to the Admin Dashboard',
    ]);
  }
}
