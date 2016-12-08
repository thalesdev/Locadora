<?php 

/**
*  Classe responsavel pela conexão com o banco de dados... 
*/
class Database 
{
	
	// Variaveis da classe privadas.
	private  $host, $port, $username,$password, $dbname;
	private $connection;
	// metodo construtor, executado quando a classe e criada..
	function __construct($host, $port, $dbname, $username,$password )
	{
		$this->host = $host;
		$this->port = $port;
		$this->username = $username;
		$this->dbname = $dbname;
	}


   // Metodo que cria uma nova conexão com os dados informados pelo o usuario no construtor...
	public function Connect()
	{
		 try{
             $connection = new PDO("mysql:host=". $this->host .";port=". $this->port . ";dbname=". $this->dbname, $this->username, $this->password);
             return $connection;
		 }
		 catch(Exception $e){
		  return false;
		}
	}
}