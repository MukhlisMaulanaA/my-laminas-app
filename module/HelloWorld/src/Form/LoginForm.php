<?php

namespace HelloWorld\Form;

use Laminas\Form\Element\Csrf;
use Laminas\Form\Form;

class LoginForm extends Form
{
  public function __construct($name = null)
  {
    parent::__construct('login');

    // CSRF Token
    $this->add([
      'type' => Csrf::class,
      'name' => 'csrf',
      'options' => [
        'csrf_options' => [
          'timeout' => 600,
        ],
      ],
    ]);

    $this->add([
      'name' => 'username',
      'type' => 'Text',
      'options' => [
        'label' => 'Username',
      ],
      'attributes' => [
        'class' => 'form-control', // Tambahkan class Bootstrap
        'placeholder' => 'Enter your username', // Tambahkan placeholder
      ],
    ]);

    $this->add([
      'name' => 'password',
      'type' => 'Password',
      'options' => [
        'label' => 'Password',
      ],
      'attributes' => [
        'class' => 'form-control',
        'placeholder' => 'Enter your password',
      ],
    ]);

    $this->add([
      'name' => 'submit',
      'type' => 'Submit',
      'attributes' => [
        'value' => 'Login',
        'id' => 'submitbutton',
        'class' => 'btn btn-primary'
      ],
    ]);
  }
}
