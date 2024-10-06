<?php

namespace HelloWorld\Form;

use Laminas\Form\Form;
use Laminas\Form\Element;

class ContactForm extends Form
{
  public function __construct($name = null)
  {
    parent::__construct('contact');

    $this->add([
      'name' => 'name',
      'type' => 'Text',
      'options' => [
        'label' => 'Your Name',
      ],
    ]);

    $this->add([
      'name' => 'email',
      'type' => 'Email',
      'options' => [
        'label' => 'Your Email',
      ],
    ]);

    $this->add([
      'name' => 'submit',
      'type' => 'Submit',
      'attributes' => [
        'value' => 'Submit',
        'id' => 'submitbutton',
      ],
    ]);
  }
}
