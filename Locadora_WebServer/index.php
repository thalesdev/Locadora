<?php 

 // Diz que a requisição HTTP vai retornar um JSON em UTF8.
 header("Content-type: application/json; charset=utf-8");
 error_reporting(0); 

// Inclui a casse Kernel.
require_once   "/class/Kernel.class.php";
// Inclui as configurações..
require_once   "config.php";

// Inicia o coração da aplicação injetando as configurações.
$app = new Kernel($config);

// Chama o metodo que ficara ouvindo as requisições do usuario.
$app->Listen();