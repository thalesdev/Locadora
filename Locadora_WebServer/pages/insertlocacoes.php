<?php 

  // Valida os campos e passa eles escapados...
  echo $this->validateFields([
      "id_cliente",
      "id_filme",
      "data_locacao",
      "data_devolucao"
  	])->then(
    // Se a validação estiver tudo ok!
  	function($input){
  		 // Insere o cliente
  		 $statement = $this->db->prepare("INSERT INTO locacoes(id_cliente,id_filme,data_locacao,data_devolucao) VALUES(?,?,?,?)");
  		 $statement->bindParam(1,$input["id_cliente"]);
  		 $statement->bindParam(2,$input["id_filme"]);
       $statement->bindParam(3,$input["data_locacao"]);
       $statement->bindParam(4,$input["data_devolucao"]);
       // Se for inserido com sucesso ele retorna o propio.
       if($statement->execute()){
       	 $stmt = $this->db->query("SELECT * FROM locacoes where id like LAST_INSERT_ID()");
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