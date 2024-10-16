<?php

declare(strict_types=1);

namespace HelloWorld\Controller;

use Exception;
use HelloWorld\Model\User;
use HelloWorld\Form\UserForm;
use HelloWorld\Form\LoginForm;

use HelloWorld\Model\UserTable;
use Laminas\Db\Adapter\Adapter;
use HelloWorld\Form\ContactForm;
use Laminas\View\Model\ViewModel;

use HelloWorld\Service\GreetingService;
use Laminas\Authentication\AuthenticationService;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Authentication\Adapter\DbTable\CredentialTreatmentAdapter;


class IndexController extends AbstractActionController
{
  private $greetingService;

  private $userTable;

  private $dbAdapter;

  public function __construct(GreetingService $greetingService, UserTable $userTable, Adapter $dbAdapter)
  {
    $this->greetingService = $greetingService;
    $this->userTable = $userTable;
    $this->dbAdapter = $dbAdapter;
  }
  public function indexAction()
  {
    return new ViewModel();
  }

  public function greetAction()
  {
    // Step 1 : Understand routing concept deeper
    // $name = $this->params()->fromRoute('name', 'Guest');
    // return new ViewModel(['name' => $name]);

    // Step 2 : Dependency Injection dan Service Manager
    $name = $this->params()->fromRoute('name', 'Guest');
    $greeting = $this->greetingService->getGreeting($name);
    return new ViewModel(['greeting' => $greeting]);
  }

  // Step 3 : Form Handling
  public function contactAction()
  {
    $form = new ContactForm();
    $request = $this->getRequest();

    if ($request->isPost()) {
      $form->setData($request->getPost());

      if ($form->isValid()) {
        $data = $form->getData();
        return new ViewModel([
          'form' => $form,
          'message' => 'Form berhasil dikirim!',
        ]);
      }
    }

    return new ViewModel(['form' => $form]);
  }

  public function listAction()
  {
    return new ViewModel([
      'users' => $this->userTable->fetchAll(),
    ]);
  }

  public function addAction()
  {
    $form = new UserForm();
    $form->get('submit')->setValue('Add');

    $request = $this->getRequest();

    if ($request->isPost()) {
      $user = new User();
      $form->setData($request->getPost());

      if ($form->isValid()) {
        $user->exchangeArray($form->getData());
        $this->userTable->createUser($user);
        return $this->redirect()->toRoute('user-list');
      }
    }

    return ['form' => $form];
  }

  public function editAction()
  {
    $id = (int) $this->params()->fromRoute('id', 0);

    if (0 === $id) {
      return $this->redirect()->toRoute('user-add');
    }

    try {
      $user = $this->userTable->getUser($id);
    } catch (Exception $e) {
      return $this->redirect()->toRoute('user-list');
    }

    $form = new UserForm();
    $form->bind($user);
    $form->get('submit')->setAttribute('value', 'Update');

    $request = $this->getRequest();
    if ($request->isPost()) {
      $form->setData($request->getPost());

      if ($form->isValid()) {
        $this->userTable->createUser($user);
        return $this->redirect()->toRoute('user-list');
      }
    }

    return [
      'id' => $id,
      'form' => $form,
    ];
  }

  public function deleteAction()
  {
    $id = (int) $this->params()->fromRoute('id', 0);

    if (!$id) {
      return $this->redirect()->toRoute('user-list');
    }

    $this->userTable->deleteUser($id);
    return $this->redirect()->toRoute('user-list');
  }

  public function loginAction()
  {
    // Inisialisasi form login
    $form = new LoginForm();
    $request = $this->getRequest();

    // Proses form ketika ada request POST (ketika user meng-submit form login)
    if ($request->isPost()) {
      $form->setData($request->getPost());

      // Validasi form (cek apakah input pengguna valid)
      if ($form->isValid()) {
        $data = $form->getData(); // Ambil data dari form

        // Setup adapter autentikasi
        $authAdapter = new CredentialTreatmentAdapter(
          $this->dbAdapter,      // Database adapter
          'users',               // Nama tabel
          'username',            // Kolom untuk username
          'password',            // Kolom untuk password
          'SHA1(?)'              // Hashing password (sesuaikan dengan metode hash Anda)
        );

        // Set username dan password yang diinput oleh user
        $authAdapter->setIdentity($data['username']);
        $authAdapter->setCredential($data['password']);

        // Inisialisasi AuthenticationService
        $authService = new AuthenticationService();

        // Coba autentikasi
        $result = $authService->authenticate($authAdapter);

        // Cek apakah autentikasi berhasil
        if ($result->isValid()) {
          // Jika autentikasi berhasil, ambil data user dari database
          $identity = $authAdapter->getResultRowObject(null, 'password'); // Ambil semua kolom kecuali password

          // Simpan identitas user di session
          $authService->getStorage()->write($identity);

          // Debugging: Lihat role yang disimpan
          var_dump($identity->role);
          var_dump("Logged in with role: " . $identity->role);

          // Redirect pengguna berdasarkan peran/role
          if ($identity->role === 'admin') {
            // Jika user adalah admin, redirect ke halaman admin
            return $this->redirect()->toRoute('admin');
          } elseif ($identity->role === 'user') {
            // Jika user adalah user biasa, redirect ke halaman profil
            return $this->redirect()->toRoute('profile');
          } else {
            // Jika role tidak dikenali, redirect kembali ke halaman login
            return $this->redirect()->toRoute('login');
          }
        } else {
          // Jika autentikasi gagal, tampilkan pesan error
          return new ViewModel([
            'form' => $form,
            'error' => 'Invalid credentials provided'
          ]);
        }
      }
    }

    // Render form login
    return new ViewModel([
      'form' => $form
    ]);
  }


  public function logoutAction()
  {
    // logout pengguna
    $authService = new AuthenticationService();
    $authService->clearIdentity();
    return $this->redirect()->toRoute('login');
  }

}
