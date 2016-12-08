<?php 

/**
* Classe responsavel por validar campos.
*/
class Validator
{
	
	private $fields;
	private $is_val = true;
	// $payload e a carga util fornecida pelo usuario como os campos que ele deseja verificar..
	function __construct($payload)
	{
	   $args = $payload;
	   // percorre a carga util.
	   foreach ($args as $key) {
	   	// Se ela não existir no $_POST
	   	 if(!isset($_POST[$key])){
	   	 	// a validação falhou
	   	 	$this->is_val = false;
	   	 }else{
	   	 	// se existir ele adiciona no $fields da classe Validator..
	   	 	$this->fields[$key] = utf8_encode(trim(filter_input(INPUT_POST, $key))); 
	   	 }
	   }
	}
	// Função que chaveia a validação e recebe duas funções anonimas, $callback quando for validado com sucesso e $callbackError quando houver erro na validação.
	function then($callback,$callbackError){
       if($this->is_val){
       	// Retorna a função de sucesso e passa os campos validados.
        return $callback($this->fields);
       }
       else{
       	// Retorna a função de erro passando o erro como paramentro.
       	 return $callbackError("Campos Invalidos!");
       }
	}
}