<?php
/**
 * App core class
 *
 */
class Core {
    /**
     * default controller is pages controller 
     * currentController
     * currentMethod
     * params
     */
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];

    const CONTROLLER_DIR = '../app/controllers/';
    const PHP_FILE_EXTENSION = '.php';

    public function __construct() {
        $url = $this->getUrl();

        if(file_exists(self::CONTROLLER_DIR . ucwords($url[0]) . self::PHP_FILE_EXTENSION)){
            $this->currentController = ucwords($url[0]);
            unset($url[0]); // Clean up
        } elseif(isset($url[0])) {
            unset($url[0]); // Need to clean up even if class does not exist, to return out default
        }

        require_once self::CONTROLLER_DIR . $this->currentController . self::PHP_FILE_EXTENSION;
        // Instantiation
        $this->currentController = new $this->currentController;
        // Check for method, second part of url
        if(isset($url[1])){
            if(method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                unset($url[1]);
            }
        } elseif(isset($url[1])) {
            unset($url[1]); // Need to clean up even if class does not exist, to return out default
        }

        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
        // echo $this->currentMethod;
    }

    public function getUrl() {
        $url = $_GET;
        // Godcheck
        if(!isset($url['url'])) {
            return false;
        }
        
        $url = rtrim($url['url'], '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/', $url);
        var_dump($url);
        return $url;
    }
}