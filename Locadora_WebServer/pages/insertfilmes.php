<?php 

  // Valida os campos e passa eles escapados...
  echo $this->validateFields([
      "titulo",
      "ano",
      "duracao",
      "preco_locacao"
  	])->then(
    // Se a validação estiver tudo ok!
  	function($input){
  		 // Insere o cliente
  		 $statement = $this->db->prepare("INSERT INTO filmes(titulo,ano,duracao,preco_locacao) VALUES(?,?,?,?)");    
  		 $statement->bindParam(1,$input["titulo"]);
  		 $statement->bindParam(2,$input["ano"]);
       $statement->bindParam(3,$input["duracao"]);
       $statement->bindParam(4,$input["preco_locacao"]);
       // Se for inserido com sucesso ele retorna o propio.
       if($statement->execute()){
       	 $stmt = $this->db->query("SELECT * FROM filmes where id like LAST_INSERT_ID()");
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