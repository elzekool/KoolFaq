<?php
/**
 * Application Bootstrapper
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolDevelop
 * @subpackage BaseApplication
 **/

/**
 * Base Bootstrapper
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolDevelop
 * @subpackage BaseApplication
 **/
class Bootstrapper extends \KoolDevelop\Bootstrapper
{

    /**
     * Function called on application initialisation
     *
     * @return void
     */
    public function init() {

        $router = $this->Router;
        
        // Standaard frontend en backend pagina's
        $router->addRoute(new \KoolDevelop\Route\Literal('/', '/voorpagina/index', true));
        $router->addRoute(new \KoolDevelop\Route\Literal('/beheer', '/voorpagina/beheer_index/', true));
        
        // Beheer omgeving
        $router->addRoute(new \KoolDevelop\Route\Wildcard('/beheer/*/*', '/$1/beheer_$2'));

        // Load KoolMinify
        \KoolDevelop\Log\Logger::getInstance()->low('KoolMinify wordt geladen', 'KoolFAQ.Bootstrapper');
        require APP_PATH . DS . 'libs' . DS . 'KoolMinify' . DS . 'init.php';
                
        // Load Shortcut functions
        require APP_PATH . DS . 'Shortcodes.php';
        
        // Update Error handler
        $error_handler = \KoolDevelop\ErrorHandler::getInstance();
        $error_handler->addObserver('onError', function(\Exception $e) {
            $exception_controler = new \Controller\Exception();
            if ($e instanceof \KoolDevelop\Exception\NotFoundException) {
                $exception_controler->notfound($e);
            } else {
                $exception_controler->handle($e);
            }
        }, true);
        
        
    }

    /**
     * Function called on console launch
     *
     * @return void
     */
    public function console() {
        
        // Load Shortcut functions
        require APP_PATH . DS . 'Shortcodes.php';
        
        // Load KoolMinify
        require APP_PATH . DS . 'libs' . DS . 'KoolMinify' . DS . 'init.php';
                
    }

    /**
     * Function called on webservice request
     * 
     * @return void
     */
    public function webservice() {
        
    }

    /**
     * Determine current environment. This environment is used
     * to determine configuration files
     *
     * @return string
     */
    public function getEnvironment() {
        
        if (REQUEST_TYPE !== 'web') {
            return REQUEST_TYPE;
        }
        
        $hostname = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
        
        if (preg_match('/^localhost$/', $hostname) !== 0) {
            return 'development';            
        } else if (preg_match('/(.*)koolvps\.nl$/', $hostname) !== 0) {
            return 'staging';
        }  else {
            return 'production';
        }
        
       
        
    }

}
