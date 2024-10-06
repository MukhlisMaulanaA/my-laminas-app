<?php

namespace HelloWorld\Form;

use Laminas\Form\Form;
use Laminas\Form\Element;
use Laminas\InputFilter\InputFilter;


class ContactForm extends Form
{
  public function __construct($name = null)
  {
    // Panggil constructor parent
    parent::__construct('contact');

    // Tambah elemen Name
    $this->add([
      'name' => 'name',
      'type' => Element\Text::class,
      'options' => [
        'label' => 'Your Name',
      ],
      'attributes' => [
        'required' => true,
      ],
    ]);

    // Tambah elemen Email
    $this->add([
      'name' => 'email',
      'type' => Element\Email::class,
      'options' => [
        'label' => 'Your Email',
      ],
      'attributes' => [
        'required' => true,
      ],
    ]);

    // Tambah elemen Pesan (Textarea)
    $this->add([
      'name' => 'message',
      'type' => Element\Textarea::class,
      'options' => [
        'label' => 'Your Message',
      ],
      'attributes' => [
        'required' => true,
      ],
    ]);

    // Tambah tombol Submit
    $this->add([
      'name' => 'submit',
      'type' => Element\Submit::class,
      'attributes' => [
        'value' => 'Send Message',
        'id' => 'submitbutton',
      ],
    ]);

    $this->addInputFilter();
  }

  protected function addInputFilter()
  {
    $inputFilter = new InputFilter();

    // Validasi untuk Name (required, minimal 3 karakter)
    $inputFilter->add([
      'name' => 'name',
      'required' => true,
      'filters' => [
        ['name' => 'StringTrim'],
        ['name' => 'StripTags'],
      ],
      'validators' => [
        [
          'name' => 'StringLength',
          'options' => [
            'min' => 3,
            'max' => 100,
          ],
        ],
      ],
    ]);

    // Validasi untuk Email (required, valid email format)
    $inputFilter->add([
      'name' => 'email',
      'required' => true,
      'validators' => [
        [
          'name' => 'EmailAddress',
        ],
      ],
    ]);

    // Validasi untuk Message (required, minimal 10 karakter)
    $inputFilter->add([
      'name' => 'message',
      'required' => true,
      'filters' => [
        ['name' => 'StringTrim'],
        ['name' => 'StripTags'],
      ],
      'validators' => [
        [
          'name' => 'StringLength',
          'options' => [
            'min' => 10,
          ],
        ],
      ],
    ]);

    $this->setInputFilter($inputFilter);
  }
}
