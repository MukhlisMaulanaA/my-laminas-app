<?php

namespace HelloWorld\Form;

use Laminas\Form\Form;

class LoginForm extends Form
{
  public function __construct($name = null)
  {
    parent::__construct('login');

    $this->add([
      'name' => 'username',
      'type' => 'Text',
      'options' => [
        'label' => 'Username',
      ],
    ]);

    $this->add([
      'name' => 'password',
      'type' => 'Password',
      'options' => [
        'label' => 'Password',
      ],
    ]);

    $this->add([
      'name' => 'submit',
      'type' => 'Submit',
      'attributes' => [
        'value' => 'Login',
        'id' => 'submitbutton',
      ],
    ]);
  }
}
