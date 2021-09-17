<?php

namespace Campaign;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Dotenv\Dotenv;
use Purl\Url;
use Michelf\Markdown;


class Campaign {

    public function __construct(){  

        if(file_exists('../.env')){
            $dotenv = new Dotenv();
            $dotenv->load('../.env');    
        }

        $this->view('index.twig', []);

    }

    private function view($template, $model){
        $twig = $this->twig();
        echo $twig->render($template, $model);
    }

    private function twig(){

        $twig = new \Twig\Environment(new \Twig\Loader\FilesystemLoader('../templates'), [
            'cache' => (getenv('ENV') == 'local' ? false : '../templates_cache'),
            'debug' => true ]);
   
        // filters
   
        $twig->addFilter(new \Twig\TwigFilter('markdown', function ($string) {
            return Markdown::defaultTransform($string);
        }));     
        
        $twig->addExtension(new \Twig\Extension\DebugExtension());

        return $twig;

    }
    
    private function redirect($to){
        header("Location: $to");
        die();
    }

}