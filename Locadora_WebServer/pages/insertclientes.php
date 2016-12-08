<?php 

  


  // Valida os campos e passa eles escapados...
  echo $this->validateFields([
      "nome",
      "cpf"
  	])->then(
    // Se a validação estiver tudo ok!
  	function($input){
  		 // Insere o cliente
  		 $statement = $this->db->prepare("INSERT INTO clientes(nome,cpf) VALUES(?,?)");
  		 $statement->bindParam(1,$input["nome"]);
  		 $statement->bindParam(2,$input["cpf"]);
       // Se for inserido com sucesso ele retorna o propio.
       if($statement->execute()){
       	 $stmt = $this->db->query("SELECT * FROM clientes where id like LAST_INSERT_ID()");
       	 $temp = $stmt->fetch(PDO::FETCH_OBJ);
       	 return $this->fetchToJson($temp);
       }else{
       	return json_encode(["error" => $statement->errorCode()]);
       }
  	}, 
    // Se tiver a validação falhar.. 
  	function($error){
      return json_encode([ "error" =>  "Houve um erro : ". $error]);
});