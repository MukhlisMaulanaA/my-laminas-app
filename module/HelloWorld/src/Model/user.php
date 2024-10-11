<?php

namespace HelloWorld\Model;

class User
{
  public $id;
  public $name;
  public $email;
  public $username;
  public $password;
  public $role;

  public function exchangeArray(array $data)
  {
    $this->id = !empty($data['id']) ? $data['id'] : null;
    $this->name = !empty($data['name']) ? $data['name'] : null;
    $this->email = !empty($data['email']) ? $data['email'] : null;
    $this->username = !empty($data['username']) ? $data['username'] : null;
    $this->password = !empty($data['password']) ? $data['password'] : null;
    $this->role = !empty($data['role']) ? $data['role'] : null;
  }

  public function getArrayCopy()
  {
    return [
      'id' => $this->id,
      'name' => $this->name,
      'email' => $this->email,
      'username' => $this->username,
      'password' => $this->password,
      'role' => $this->role,
    ];
  }
}
