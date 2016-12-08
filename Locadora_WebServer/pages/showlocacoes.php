<?php  
 // Busca todas locacoes.
 $stmt = $db->prepare("SELECT * FROM locacoes");
 $stmt->execute();
 // Monta o resultado.
 $results = $stmt->fetchAll(PDO::FETCH_OBJ);

// Exibe o resultado em json.
 echo $this->fetchToJson($results);
 