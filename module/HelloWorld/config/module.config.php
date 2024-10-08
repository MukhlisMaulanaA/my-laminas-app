<?php

declare(strict_types=1);

namespace HelloWorld;


use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
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
      'user-list' => [
        'type' => Literal::class,
        'options' => [
          'route' => '/user/list',
          'defaults' => [
            'controller' => Controller\IndexController::class,
            'action' => 'list',
          ],
        ],
      ],
    ],
  ],
  'service_manager' => [
    'factories' => [
      Service\GreetingService::class => InvokableFactory::class,
      Model\UserTable::class => function ($container) {
        $tableGateway = $container->get(Model\UserTableGateway::class);
        return new Model\UserTable($tableGateway);
      },
      Model\UserTableGateway::class => function ($container) {
        $dbAdapter = $container->get('Laminas\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Model\User());
        return new TableGateway('users', $dbAdapter, null, $resultSetPrototype);
      },
    ],
  ],
  'controllers' => [
    'factories' => [
      Controller\IndexController::class => InvokableFactory::class,
      Controller\IndexController::class => function ($container) {
        return new Controller\IndexController($container->get(Service\GreetingService::class));
      },
      Controller\IndexController::class => function ($container) {
        return new Controller\IndexController($container->get(Model\UserTable::class));
      },
    ],
  ],
  'view_manager' => [
    'template_path_stack' => [
      __DIR__ . '/../view',
    ],
  ],
];
