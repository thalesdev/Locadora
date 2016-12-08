<?php 

   // Inclui as principais depdencias e as configurações da aplicação..
 	 require_once "/../config.php";
 	 require_once "/../autoload.php";


 /**
 * Coração da aplicação. 
 */
 class Kernel
 {

 	private $config;
 	private $db;
  // Metodo construtor onde são injetado as configurações na index.php, e é instanciado uma nova conexão com o banco de dados.
 	function __construct($config)
 	{
 		$this->config = $config;
 		$this->db = new Database($this->config["database"]["host"],$this->config["database"]["port"],$this->config["database"]["dbname"], $this->config["database"]["username"],$this->config["database"]["password"]);
 		   $this->db = $this->db->Connect();       
  }


   // retorna o banco de dados..
    public function Con(){
    	return $this->db;
    } 

   // metodo que escuta as requisições feita pelo usuario e incaminha as paginas desejadas..
    public function Listen(){
      // Pega a requisição
    	$request_uri = trim($_SERVER["REQUEST_URI"]);	
      // Pega o metodo da requisição 
    	$request_method = trim($_SERVER["REQUEST_METHOD"]);

      // Se existir o token ele ira tratar a URL.
       if(isset($_GET["token"]) || isset($_POST["token"])){
        // Verifica se o token esta em GET.
       	if(isset($_GET["token"])){
          // Verifica se o token é diferente do da config.php
       		if($_GET["token"] != $this->config["token"]){
            // retorna para o response que a requisição é invalida, pois o token é invalido.
            http_response_code(401);
       			die;
       		}
       	}
        // Verifica se o token esta em POST.
       	if(isset($_POST["token"])){
          // Verifica se o token é diferente do da config.php
       		if($_POST["token"] != $this->config["token"]){    
            // retorna para o response que a requisição é invalida, pois o token é invalido.
             http_response_code(401);        
       			die;
       		}
       	}

        // Percore as rotas do config onde $key é a regra do mapeamento e $value é a pagina a ser incluida.
        foreach ($this->config["routes"] as $key => $value) {
          // Separa a string em uma array pelo limitador ":", para separar o metodo de requisição e a regra, $new_key[0] estará  GET ou POST dependendo do seu mapeamento, $new_key[1]  é o mapeamento por exemplo "api/users".
      	  $new_key = split(":", $key);
          // Invoca o metodo preg_match e valida se a requisição que o usuario fez é a mesma do mapeamento.
      	  if(preg_match("/".$new_key[0]."/i",$request_method)){
              // Verifica se o mapeamento é o mesmo que o requisitado pelo o usuario
              // Split("\?", $request_uri)[0] divide a url requisitada pelo caractere ? que indica o conteudo de uma requisição get que nao e importante para a validação.
              if(preg_match("/^".$new_key[1]."$/i", split("\?",$request_uri)[0], $args)){
                 // define o banco de dados com a variavel local $db
                 $db = $this->con();
                 // inclui a pagina mapeada nas config.
                 include "/../". $value;
                 // não deixa o codigo continuar.
                 return;
              }
      	  }
         }
     }



    }


   // Metodo recursivo, que converte os caracteres de uma array caso eles forem utf8.
 public function utf8_converter($array)
  {
    array_walk_recursive($array, function(&$item, $key){
        if(!mb_detect_encoding($item, 'UTF-8', true)){
                $item = utf8_encode($item);
        }
    });
 
    return $array;
   }

   // Metodo recurivo que converte um objeto(Classe) em array(Vetor/Matriz).
  public  function  objectToArray($d) {
        if (is_object($d)) {
            $d = get_object_vars($d);
        }    
        if (is_array($d)) {
            return array_map(array($this,__FUNCTION__), $d);
        }
        else {
            return $d;
        }
    }

   // Metodo recursivo que faz o inverso do de cima.
   public function arrayToObject($d) {
        if (is_array($d)) {
            return (object) array_map(__FUNCTION__, $d);
        }
        else {
            return $d;
        }
    }


   // Transforma um statement do PDO ou seja resultados em uma lista json, escapando os caracteres unicode.
   public function fetchToJson($resultFetch){
       return json_encode($this->toUTF8($resultFetch),JSON_UNESCAPED_UNICODE);
   }

   //  Converte um Array ou Objeto pra utf8 usando os metodos da classe.
   public function toUTF8($arrayOrObject){
      if(is_object($arrayOrObject)){
        return $this->utf8_converter($this->objectToArray($arrayOrObject));
      }else if(is_array($arrayOrObject)){        
        return $this->utf8_converter($this->objectToArray($arrayOrObject));
      }
   }


  // Retorna uma validador de campos
  // $fields é uma array com os campos fornecidos pelo usuario.
   public function validateFields($fields){
        return new Validator($fields);
   }


 }
