<?php 

 // Diz que a requisição HTTP vai retornar um JSON em UTF8.
 header("Content-type: application/json; charset=utf-8");
 // Habilita o CORS para todos...
 header("Access-Control-Allow-Origin: *");
 error_reporting(0); 

// Inclui a classe Kernel.
require_once   __DIR__."/class/Kernel.class.php";
// Inclui as configurações..
require_once    __DIR__."/config.php";


// Inicia o coração da aplicação injetando as configurações.
$app = new Kernel($config);

// Chama o metodo que ficara ouvindo as requisições do usuario.
$app->Listen();
