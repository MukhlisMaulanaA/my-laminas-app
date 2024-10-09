<?php

namespace HelloWorld\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class AdminController extends AbstractActionController
{
  public function adminAction()
  {
    // Ini adalah halaman admin yang hanya bisa diakses oleh admin
    return new ViewModel([
      'message' => 'Welcome, Admin! You have full access to manage the system.'
    ]);
  }
}
