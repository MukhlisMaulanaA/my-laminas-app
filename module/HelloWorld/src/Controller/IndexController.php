<?php

declare(strict_types=1);

namespace HelloWorld\Controller;

use HelloWorld\Service\GreetingService;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
  private $greetingService;

  public function __construct(GreetingService $greetingService)
  {
    $this->greetingService = $greetingService;
  }

  public function indexAction()
  {
    return new ViewModel();
  }

  public function greetAction()
  {
    // Step 1 : Understand routing concept deeper
    // $name = $this->params()->fromRoute('name', 'Guest');
    // return new ViewModel(['name' => $name]);

    // Step 2 : Dependency Injection dan Service Manager
    $name = $this->params()->fromRoute('name', 'Guest');
    $greeting = $this->greetingService->getGreeting($name);
    return new ViewModel(['greeting' => $greeting]);
  }
}
