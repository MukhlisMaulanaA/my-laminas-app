<?php

declare(strict_types=1);

namespace HelloWorld;


use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
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
      'hello-user' => [
        'type' => Segment::class,
        'options' => [
          'route' => '/hello/:name',
          'constraints' => [
            'name' => '[a-zA-Z][a-zA-Z0-9_-]*',
          ],
          'defaults' => [
            'controller' => Controller\IndexController::class,
            'action' => 'greet',
          ],
        ],
      ],
      'contact' => [
        'type' => Literal::class,
        'options' => [
          'route' => '/contact',
          'defaults' => [
            'controller' => Controller\IndexController::class,
            'action' => 'contact',
          ],
        ],
      ],
    ],
  ],
  'service_manager' => [
    'factories' => [
      Service\GreetingService::class => InvokableFactory::class,
    ],
  ],
  'controllers' => [
    'factories' => [
      Controller\IndexController::class => InvokableFactory::class,
      Controller\IndexController::class => function($container) {
        return new Controller\IndexController(
          $container->get(Service\GreetingService::class)
        );
      },
    ],
  ],
  'view_manager' => [
    'template_path_stack' => [
      __DIR__ . '/../view',
    ],
  ],
];
