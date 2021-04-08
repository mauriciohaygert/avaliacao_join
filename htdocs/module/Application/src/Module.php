<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Controller\CategoryController;
use Application\Controller\ProductController;
use Application\Model\Category;
use Application\Model\CategoryTable;
use Application\Model\Product;
use Application\Model\ProductHelper;
use Application\Model\ProductTable;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module
{
    const VERSION = '3.1.4dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                CategoryTable::class => function ($container) {
                    $tableGateway = $container->get(CategoryTableGateway::class);
                    return new CategoryTable($tableGateway);
                },
                CategoryTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Category());
                    return new TableGateway('tb_categoria_produto', $dbAdapter, null, $resultSetPrototype);
                },
                ProductTable::class => function ($container) {
                    $tableGateway = $container->get(ProductTableGateway::class);
                    return new ProductTable($tableGateway);
                },
                ProductTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Product());
                    return new TableGateway('tb_produto', $dbAdapter, null, $resultSetPrototype);
                },
            ]
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                CategoryController::class => function($container) {
                    $tableGateway = $container->get(CategoryTable::class);
                    return new CategoryController($tableGateway);
                },
                ProductController::class => function($container) {
                    $tableGatewayProduct = $container->get(ProductTable::class);
                    $tableGatewayCategory = $container->get(CategoryTable::class);
                    return new ProductController($tableGatewayProduct, $tableGatewayCategory);
                },
            ]
        ];
    }
}
