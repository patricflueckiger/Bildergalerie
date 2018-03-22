<?php
require_once '../lib/Repository.php';

/**
 * Datenbankschnittstelle für die Benutzer
 */
  class LoginRepository extends Repository
  {

    protected $tableName = 'benutzer';

    public function create($nickname, $email, $password){

      $query = "INSERT INTO $this->tableName (nickname, email, password) VALUES ('$nickname', '$email','$password')";

      $statement = ConnectionHandler::getConnection()->prepare($query);
      if($statement === false)
        die(ConnectionHandler::getConnection()->error);
        $statement->bind_param('ssi', $nickname, $email, $password);

      if (!$statement->execute()) {
        throw new Exception($statement->error);
      }

      return $statement->insert_id;
    }
  }
?>
