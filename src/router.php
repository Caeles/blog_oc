<?php
namespace App;
use App\Security\ForbiddenException;

class   Router {
    /**
     * @var string
     */
    private $viewPath;

    /**
     * @var \ALtoRouter
     */
    private $router;

    /**
     * @var string
     */
    public $layout;
    public function __construct(string $viewPath){
        $this->viewPath = $viewPath;
        $this->router = new \AltoRouter();
    }
    
    public function get(string $url, string $view, ?string $name = null){
        $this->router->map('GET', $url, $view, $name);
        return $this;
    }

    public function post(string $url, string $view, ?string $name = null){
        $this->router->map('POST', $url, $view, $name);
        return $this;
    }

    public function match(string $url, string $view, ?string $name = null){
        $this->router->map('POST|GET', $url, $view, $name);
        return $this;
    }


    public function run(){
        $match = $this->router->match();
        if(isset($match['target'])){
            $view = $match['target'] ;
            $params = $match['params'];
        }else{
            $view = 'e404' ;
        }
        $router  = $this;
        $isAdmin = strpos($view, 'admin/') !== false;
        $layout = $isAdmin ? 'admin/layouts/default' :  'layouts/default';

        try{
            ob_start();
            $view = $this->viewPath . DIRECTORY_SEPARATOR .  $view . '.php';
            require $view;
            $content = ob_get_clean();
            require $this->viewPath . DIRECTORY_SEPARATOR .  $layout . '.php';
        }catch(ForbiddenException $e){
            header('Location: ' . $this->url('login'). '?forbidden=1');
            exit();
        }
        
        return $this;
    }

    public function url(string $name, array $params = []){
        return $this->router->generate($name, $params);
    }
}