<?php

namespace HelloWorld\Model;

class User
{
  public $id;
  public $name;
  public $email;

  public function exchangeArray(array $data)
  {
    $this->id = !empty($data['id']) ? $data['id'] : null;
    $this->name = !empty($data['name']) ? $data['name'] : null;
    $this->email = !empty($data['email']) ? $data['email'] : null;
  }

  public function getArrayCopy()
  {
    return [
      'id' => $this->id,
      'name' => $this->name,
      'email' => $this->email,
    ];
  }
}
