<?php

declare(strict_types=1);

namespace HelloWorld\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
  public function indexAction()
  {
    return new ViewModel();
  }

  public function greetAction()
  {
    $name = $this->params()->fromRoute('name', 'Guest');
    return new ViewModel(['name' => $name]);
  }
}
