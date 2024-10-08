<?php

namespace HelloWorld\Form;

use Laminas\Form\Form;

class UserForm extends Form
{
  public function __construct($name = null)
  {
    parent::__construct('user');

    $this->add([
      'name' => 'id',
      'type' => 'Hidden',
    ]);

    $this->add([
      'name' => 'name',
      'type' => 'Text',
      'options' => [
        'label' => 'Name',
      ],
    ]);

    $this->add([
      'name' => 'email',
      'type' => 'Email',
      'options' => [
        'label' => 'Email',
      ],
    ]);

    $this->add([
      'name' => 'submit',
      'type' => 'Submit',
      'attributes' => [
        'value' => 'Save',
        'id' => 'submitbutton',
      ],
    ]);
  }
}
