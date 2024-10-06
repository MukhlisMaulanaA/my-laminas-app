<?php

namespace HelloWorld\Service;

class GreetingService
{
  public function getGreeting($name)
  {
    return "Hello, $name!";
  }
}
