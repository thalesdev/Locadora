<?php  
 // Busca todos filmes.
 $stmt = $db->prepare("SELECT * FROM filmes");
 $stmt->execute();
 // Monta o resultado.
 $results = $stmt->fetchAll(PDO::FETCH_OBJ);

// Exibe o resultado em json.
 echo $this->fetchToJson($results);
 