<?php 
 

return $config = [
   // Configurações do banco de dados MySql
   "database" => [
     "host" => "localhost",
     "port" => "3306",
     "username" => "root",
     "password" => "",
     "dbname"  => "locadora"
    ],
   // Token de autenticação
   "token" => "123456789",
    /*
     * Rotas da aplicação
     *
     */
   "routes" =>[
      "GET:\/clientes" => "pages/showclientes.php",
      "POST:\/clientes" => "pages/insertclientes.php",
      "GET:\/filmes" => "pages/showfilmes.php",
      "POST:\/filmes" => "pages/insertfilmes.php",
      "GET:\/locacoes" => "pages/showlocacoes.php",
      "POST:\/locacoes" => "pages/insertlocacoes.php",


      /*
       * PHP 5 Da suporte a parametros variaveis utilizando a sintaxe
       * (?P<NOME DO PARAMETRO>  TIPO )
       * d+ = Digitos, w+ = Palavras, .* = tudo
       */

      "GET:\/cliente\/(?P<id>\d+)" => "pages/showclienteporid.php",
      "GET:\/filme\/(?P<id>\d+)" => "pages/showfilmeporid.php",
      "GET:\/locacao\/(?P<id>\d+)" => "pages/showlocacaoid.php",

       

   ]

 ];
