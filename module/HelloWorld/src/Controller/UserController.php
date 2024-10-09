<?php

namespace HelloWorld\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class UserController extends AbstractActionController
{
  public function profileAction()
  {
    // Ini adalah halaman profil yang bisa diakses oleh user dan admin
    return new ViewModel([
      'message' => 'Welcome to your profile page!'
    ]);
  }
}
