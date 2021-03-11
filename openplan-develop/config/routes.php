<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 * Cache: Routes are cached to improve performance, check the RoutingMiddleware
 * constructor in your `src/Application.php` file to change this behavior.
 *
 */
Router::defaultRouteClass(DashedRoute::class);

Router::scope('/', function (RouteBuilder $routes) {
    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */
    //$routes->connect('/', ['plugin' => 'Usermgmt','controller' => 'Users', 'action' => 'login']);
    $routes->connect('/', ['controller' => 'Items', 'action' => 'allItems']);

    $routes->connect(
        '/company/:id',
        ['controller' => 'Items', 'action' => 'allItemsCompany']
    )
    ->setPatterns(['id' => '\d+'])
    ->setPass(['id']);

    $routes->connect(
        '/item/:id',
        ['controller' => 'Items', 'action' => 'item']
    )
    ->setPatterns(['id' => '\d+'])
    ->setPass(['id']);

    $routes->connect(
        '/addComment/',
        ['controller' => 'Comments', 'action' => 'addFront']
    );

    $routes->connect(
        '/addFiles/',
        ['controller' => 'Files', 'action' => 'addFiles']
    );

    $routes->connect(
        '/editFront/:id',
        ['controller' => 'items', 'action' => 'editFront']
    )
    ->setPatterns(['id' => '\d+'])
    ->setPass(['id']);

    $routes->connect(
        '/editComment/:id',
        ['controller' => 'comments', 'action' => 'editFront']
    )
    ->setPatterns(['id' => '\d+'])
    ->setPass(['id']);

    $routes->connect(
        '/deleteFile/:id',
        ['controller' => 'files', 'action' => 'deleteFront']
    )
    ->setPatterns(['id' => '\d+'])
    ->setPass(['id']);

    $routes->connect(
        '/deleteComment/:id',
        ['controller' => 'comments', 'action' => 'deleteFront']
    )
    ->setPatterns(['id' => '\d+'])
    ->setPass(['id']);


    $routes->connect(
        '/deleteItem/:id',
        ['controller' => 'items', 'action' => 'deleteFront']
    )
    ->setPatterns(['id' => '\d+'])
    ->setPass(['id']);

    $routes->connect(
        '/company/:id/room/:id2',
        ['controller' => 'Items', 'action' => 'allItemsRoom']
    )
    ->setPatterns(['id' => '\d+', 'id2' => '\d+'])
    ->setPass(['id', 'id2']);

    $routes->connect(
        '/cllbrts/:id',
        ['controller' => 'Collaborators', 'action' => 'getCollaboration']
    )
    ->setPatterns(['id' => '[a-z0-9-_]+'])
    ->setPass(['id']);

    /**
     * ...and connect the rest of 'Pages' controller's URLs.
     */
    $routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);`
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $routes->fallbacks(DashedRoute::class);
});
