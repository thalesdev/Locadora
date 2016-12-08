<?php 

 // Busca um cliente por id, passando $args["id"] como parametro
 $stmt = $db->prepare("SELECT * FROM clientes where id like ?");
 $stmt->bindParam(1, $args["id"]);
 $stmt->execute();
 // faz o fetch do resultado transformando em Objetos padrões do php.
 $results = $stmt->fetchAll(PDO::FETCH_OBJ);

// Mostra o resultado da busca em json.
 echo $this->fetchToJson($results);
 