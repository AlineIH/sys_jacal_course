<?php

namespace Users;


use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Users\Model\UsersTable;
use Users\Model\Users;

class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                'UsersTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Users());
                    return new TableGateway('users',$dbAdapter, null, $resultSetPrototype);
                },
                'Users\Model\UsersTable' => function ($sm) {
                    $tableGateWay = $sm->get('UsersTableGateway');
                    return new UsersTable($tableGateWay);
                }
            ]
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\UsersController::class => function($container) {
                    return new Controller\UsersController(
                        $container->get(Model\UsersTable::class)
                    );
                },
            ],
        ];
    }
}