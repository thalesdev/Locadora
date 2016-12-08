<?php 


   // Metodo magico que e chamado toda vez que uma classe for instanciada "new Class()".
   // Onde $class e o nome da classe instanciada.
   function __autoload($class)
  	{
        // metodo que inclui apenas uma vez e se ja existir ignora uma classe.
  	    require_once "class/".$class.".class.php"; 
  	}			