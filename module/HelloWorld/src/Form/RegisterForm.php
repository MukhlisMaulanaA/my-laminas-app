<?php
// module/HelloWorld/src/Form/RegisterForm.php
namespace HelloWorld\Form;

use Laminas\Form\Form;
use Laminas\InputFilter\InputFilterProviderInterface;

class RegisterForm extends Form implements InputFilterProviderInterface
{
  public function __construct($name = null)
  {
    parent::__construct('register');

    // Name field
    $this->add([
      'name' => 'name',
      'type' => 'Text',
      'options' => [
        'label' => 'Name',
      ],
    ]);

    // Email field
    $this->add([
      'name' => 'email',
      'type' => 'Email',
      'options' => [
        'label' => 'Email',
      ],
    ]);

    // Username field
    $this->add([
      'name' => 'username',
      'type' => 'Text',
      'options' => [
        'label' => 'Username',
      ],
    ]);

    // Password field
    $this->add([
      'name' => 'password',
      'type' => 'Password',
      'options' => [
        'label' => 'Password',
      ],
    ]);

    // Confirm Password field
    $this->add([
      'name' => 'confirm_password',
      'type' => 'Password',
      'options' => [
        'label' => 'Confirm Password',
      ],
    ]);

    // Submit button
    $this->add([
      'name' => 'submit',
      'type' => 'Submit',
      'attributes' => [
        'value' => 'Register',
        'id' => 'submitbutton',
      ],
    ]);
  }

  // Filter dan validasi input
  public function getInputFilterSpecification()
  {
    return [
      'name' => [
        'required' => true,
        'filters' => [
          ['name' => 'StringTrim'],
          ['name' => 'StripTags'],
        ],
        'validators' => [
          [
            'name' => 'StringLength',
            'options' => [
              'min' => 2,
              'max' => 255,
            ],
          ],
        ],
      ],

      'email' => [
        'required' => true,
        'validators' => [
          [
            'name' => 'EmailAddress',
          ],
        ],
      ],

      'username' => [
        'required' => true,
        'filters' => [
          ['name' => 'StringTrim'],
        ],
        'validators' => [
          [
            'name' => 'StringLength',
            'options' => [
              'min' => 3,
              'max' => 50,
            ],
          ],
        ],
      ],

      'password' => [
        'required' => true,
        'validators' => [
          [
            'name' => 'StringLength',
            'options' => [
              'min' => 6,
            ],
          ],
        ],
      ],

      'confirm_password' => [
        'required' => true,
        'validators' => [
          [
            'name' => 'Identical',
            'options' => [
              'token' => 'password', // Pastikan confirm password sama dengan password
            ],
          ],
        ],
      ],
    ];
  }
}