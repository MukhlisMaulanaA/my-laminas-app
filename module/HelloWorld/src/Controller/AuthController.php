<?php

namespace HelloWorld\Controller;

use HelloWorld\Form\LoginForm;
use HelloWorld\Form\RegisterForm;
use HelloWorld\Model\User;
use HelloWorld\Model\UserTable;
use Laminas\View\Model\ViewModel;
use Laminas\Authentication\AuthenticationService;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Crypt\Password\Bcrypt;


class AuthController extends AbstractActionController
{
  private $authService;

  private $userTable;

  // Inject AuthenticationService via constructor
  public function __construct(AuthenticationService $authService, UserTable $userTable)
  {
    $this->authService = $authService;
    $this->userTable = $userTable;
  }

  public function registerAction()
  {
    // Cek apakah pengguna sudah login
    if ($this->authService->hasIdentity()) {
      // Jika sudah login, redirect ke halaman profil atau dashboard
      return $this->redirect()->toRoute('profile');
    }

    $form = new RegisterForm();
    $request = $this->getRequest();

    if ($request->isPost()) {
      $form->setData($request->getPost());

      if ($form->isValid()) {
        $data = $form->getData();

        if ($this->userTable->fetchByUsername($data['username'])) {
          return new ViewModel([
            'form' => $form,
            'error' => 'Username already exists.',
          ]);
        }
        
        $bcrypt = new Bcrypt(); // inisiasi package Bcrypt
        $hashedPassword = $bcrypt->create($data['password']); // encryption password using bcrypt algorithm

        $user = new User();
        $user->exchangeArray([
          'name' => $data['name'],
          'email' => $data['email'],
          'username' => $data['username'],
          'password' => $hashedPassword,
          'role' => 'user',
        ]);

        $this->userTable->saveUser($user);

        return $this->redirect()->toRoute('login');
      }
    }

    return new ViewModel([
      'form' => $form,
    ]);
  }

  public function loginAction()
  {
    // Cek apakah pengguna sudah login
    if ($this->authService->hasIdentity()) {
      // Jika sudah login, redirect ke halaman profil atau dashboard
      return $this->redirect()->toRoute('profile');
    }

    $form = new LoginForm();
    $request = $this->getRequest();

    if ($request->isPost()) {
      $form->setData($request->getPost());

      // Validasi form login
      if ($form->isValid()) {
        $data = $form->getData();

        // Set kredensial di AuthAdapter
        $this->authService->getAdapter()->setCredentials($data['username'], $data['password']);

        // Coba autentikasi
        $result = $this->authService->authenticate();

        // Jika autentikasi sukses
        if ($result->isValid()) {
          // Redirect berdasarkan role
          $identity = $result->getIdentity(); // Dapatkan user dari hasil autentikasi
          if ($identity->getRole() === 'admin') {
            return $this->redirect()->toRoute('admin');
          } else {
            return $this->redirect()->toRoute('profile');
          }
        } else {
          // Jika autentikasi gagal, tampilkan pesan error
          return new ViewModel([
            'form' => $form,
            'error' => 'Invalid username or password'
          ]);
        }
      }
    }

    // Render form login
    return new ViewModel(['form' => $form]);
  }

  public function logoutAction()
  {
    // Hapus session user saat logout
    $this->authService->clearIdentity();

    // Redirect ke halaman login
    return $this->redirect()->toRoute('login');
  }
}
