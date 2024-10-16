<?php

declare(strict_types=1);

namespace HelloWorld;

use HelloWorld\Controller\AuthController;
use HelloWorld\Model\UserTable;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use HelloWorld\Factory\AuthControllerFactory;
use HelloWorld\Factory\UserControllerFactory;
use HelloWorld\Factory\AdminControllerFactory;
use Laminas\Authentication\AuthenticationService;
use HelloWorld\Factory\AuthenticationServiceFactory;
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
      // CRUD Route
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
      'user-add' => [
        'type' => Literal::class,
        'options' => [
          'route' => '/user/add',
          'defaults' => [
            'controller' => Controller\IndexController::class,
            'action' => 'add',
          ],
        ],
      ],
      'user-edit' => [
        'type' => 'Segment',
        'options' => [
          'route' => '/user/edit[/:id]',
          'defaults' => [
            'controller' => Controller\IndexController::class,
            'action' => 'edit',
          ],
          'constraints' => [
            'id' => '[0-9]+',
          ],
        ],
      ],
      'user-delete' => [
        'type' => 'Segment',
        'options' => [
          'route' => '/user/delete[/:id]',
          'defaults' => [
            'controller' => Controller\IndexController::class,
            'action' => 'delete',
          ],
          'constraints' => [
            'id' => '[0-9]+',
          ],
        ],
      ],
      // end route CRUD

      // register route
      'register' => [
        'type' => Literal::class,
        'options' => [
          'route' => '/register',
          'defaults' => [
            'controller' => AuthController::class,
            'action' => 'register',
          ],
        ],
      ],

      // login route
      'login' => [
        'type' => Literal::class,
        'options' => [
          'route' => '/login',
          'defaults' => [
            'controller' => Controller\AuthController::class,
            'action' => 'login',
          ],
        ],
      ],
      // logout route
      'logout' => [
        'type' => Literal::class,
        'options' => [
          'route' => '/logout',
          'defaults' => [
            'controller' => Controller\AuthController::class,
            'action' => 'logout',
          ],
        ],
      ],

      // route admin
      'admin' => [
        'type' => Literal::class,
        'options' => [
          'route' => '/admin',
          'defaults' => [
            'controller' => Controller\AdminController::class,
            'action' => 'admin',
          ],
        ],
      ],

      // route user
      'profile' => [
        'type' => Literal::class,
        'options' => [
          'route' => '/profile',
          'defaults' => [
            'controller' => Controller\UserController::class,
            'action' => 'profile',
          ],
        ],
      ],

    ],
  ],
  'service_manager' => [
    'factories' => [
      AuthenticationService::class => AuthenticationServiceFactory::class,
      Service\GreetingService::class => InvokableFactory::class,
      Model\UserTable::class => function ($container) {
        // Mengambil TableGateway yang kita definisikan
        $tableGateway = $container->get('UserTableGateway');
        return new Model\UserTable($tableGateway);
      },
      // Tambahkan konfigurasi untuk UserTable
      'UserTable' => function ($container) {
        $tableGateway = $container->get('UserTableGateway');
        return new UserTable($tableGateway);
      },

      // Tambahkan konfigurasi untuk UserTableGateway
      'UserTableGateway' => function ($container) {
        $dbAdapter = $container->get('Laminas\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Model\User());
        return new TableGateway('users', $dbAdapter, null, $resultSetPrototype);
      },
      // AuthenticationService::class => function ($container) {
      //   $authService = new AuthenticationService();
      //   return $authService;
      // },
    ],
  ],

  'controllers' => [
    'factories' => [
      Controller\AuthController::class => AuthControllerFactory::class,
      Controller\AdminController::class => AdminControllerFactory::class,
      Controller\UserController::class => UserControllerFactory::class,
      Controller\IndexController::class => function ($container) {
        return new Controller\IndexController(
          $container->get(Service\GreetingService::class),  // Argument 1: GreetingService
          $container->get(Model\UserTable::class),          // Argument 2: UserTable
          $container->get('Laminas\Db\Adapter\Adapter')     // Argument 3: DbAdapter
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
