<?php  
 // Busca todos clientes.
 $stmt = $db->prepare("SELECT * FROM clientes");
 $stmt->execute();
 // Monta o resultado.
 $results = $stmt->fetchAll(PDO::FETCH_OBJ);

// Exibe o resultado em json.
 echo $this->fetchToJson($results);
 