<?php

namespace App\Controllers;

use App\Models\DominiosModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $router = service('router');
        $controller = $router->controllerName();
        $method = $router->methodName();
        define("CORE_CONTROLLER", substr($controller, 17, 100));
        define("CORE_METHOD", $method);
        $dominiosModel = new DominiosModel();
        $CORE_NAME = $dominiosModel->where("dominio", "CORE_NAME")->findAll(1);
        if (empty($CORE_NAME))
            die("<p><b>¡ERROR! No se han configurado los parámetros de la app. Comuníquese con el administrador</b></p>");
        define("CORE_NAME", $CORE_NAME[0]["nombre"]);
        $exceptions = ["loginindex", "loginstart", "loginlogout", "constanciasconsultar", "constanciasvalidar", "constanciaspdf"]; //Excepciones para evaluar de permisos
        if (array_search(strtolower(CORE_CONTROLLER . CORE_METHOD), $exceptions) === false) { //Si el controlador con el método no son una excepcion
            if (strtolower(substr(CORE_METHOD, -6, 6)) != "action") { //Si no es una action (AJAX)
                \App\Libraries\UserControl::page_permission(strtolower(CORE_CONTROLLER), strtolower(CORE_METHOD));
            } else { //Si es una Action (AJAX)
                \App\Libraries\UserControl::action_permission(strtolower(CORE_METHOD));
            }
        }
    }
}
