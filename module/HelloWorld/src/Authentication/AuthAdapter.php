<?php

namespace HelloWorld\Authentication;

use Laminas\Authentication\Adapter\AdapterInterface;
use Laminas\Authentication\Result;
use HelloWorld\Model\UserTable;

class AuthAdapter implements AdapterInterface
{
  private $username;
  private $password;
  private $userTable;

  // Inject UserTable ke dalam AuthAdapter
  public function __construct(UserTable $userTable)
  {
    $this->userTable = $userTable;
  }

  // Set kredensial yang akan digunakan dalam autentikasi
  public function setCredentials($username, $password)
  {
    $this->username = $username;
    $this->password = $password;
  }

  // Implementasi metode authenticate()
  public function authenticate()
  {
    try {
      // Ambil user dari database berdasarkan username
      $user = $this->userTable->fetchByUsername($this->username);

      // Verifikasi password dengan password_hash yang disimpan
      if (password_verify($this->password, $user->getPassword())) {
        return new Result(
          Result::SUCCESS,
          $user,
          ['Authenticated successfully.']
        );
      }

      // Jika password tidak valid, return Result::FAILURE_CREDENTIAL_INVALID
      return new Result(
        Result::FAILURE_CREDENTIAL_INVALID,
        null,
        ['Invalid credentials.']
      );
    } catch (\RuntimeException $e) {
      // Jika user tidak ditemukan, return Result::FAILURE_IDENTITY_NOT_FOUND
      return new Result(
        Result::FAILURE_IDENTITY_NOT_FOUND,
        null,
        ['User not found.']
      );
    }
  }
}
