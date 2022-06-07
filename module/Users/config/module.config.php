<?php
namespace Users;


use Core\Controller\UserController;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;


return [
    'router' => [
        'routes' => [
            'album' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/users[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\UsersController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            UserController::class => InvokableFactory::class
        ]
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml'
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
]; 
