<?php 
 // Deleta um filme por id, passando $args["id"] como parametro
 $stmt = $db->prepare("DELETE FROM filmes where id like ?");
 $stmt->bindParam(1, $args["id"]);
 if($stmt->execute()){
   echo json_encode(["status" => "sucess"]);
}else{
	echo json_encode(["status" => "error"]);
 }
 