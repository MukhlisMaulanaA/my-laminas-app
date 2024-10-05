<?php

declare(strict_types=1);

namespace HelloWorld;


use Laminas\Router\Http\Literal;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
  'router' => [
    'routes' => [
      'hello' => [
        'type' => Literal::class,
        'options' => [
          'route' => '/hello',
          'defaults' => [
            'controller' => Controller\IndexController::class,
            'action' => 'index',
          ],
        ],
      ],
    ],
  ],
  'controllers' => [
    'factories' => [
      Controller\IndexController::class => InvokableFactory::class,
    ],
  ],
  'view_manager' => [
    'template_path_stack' => [
      __DIR__ . '/../view',
    ],
  ],
];
