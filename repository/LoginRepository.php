<?php
require_once '../lib/Repository.php';

/**
 * Datenbankschnittstelle für die Benutzer
 */
  class LoginRepository extends Repository
  {


    public function create($nickname, $email, $password){
      $tableName = 'benutzer';

      $query = "INSERT INTO $tableName (nickname, email, password) VALUES (?,?,?)";

      $statement = ConnectionHandler::getConnection()->prepare($query);
      if($statement === false){
        die(ConnectionHandler::getConnection()->error);
      }
      else{
        $statement->bind_param('sss', $nickname, $email, $password);
      }

      if (!$statement->execute()) {
        throw new Exception($statement->error);
      }

      return $statement->insert_id;
      $statement->close();
    }

    public function get_id_by_email($email){
      $tableName = 'benutzer';
      //Query vorbereiten. Das Fragezeichen sind Platzhalter, welche später durch die Parameter ersetzt werden.
      $query = "SELECT ID FROM $tableName WHERE EMAIL = ?";
      //Das Query preparen und gleich die Connection initialisieren.
      $statement = ConnectionHandler::getConnection()->prepare($query);
      if($statement === false){
        die(ConnectionHandler::getConnection()->error);
      }
      else{
        //Die beiden Parameter email in das prepared Statement einfügen.
        //Tipp: s steht für ein string parameter.
        $statement->bind_param("s", $email);
      }
      //Überprüfen ob das Statement ausführbar ist.
      if (!$statement->execute()) {
        throw new Exception($statement->error);
      }
      else {
        //ID als ausgabewert definieren.
        $statement->bind_result($id);
        //Resultate laden
        $statement->fetch();
        //$id zurückgeben.
        return $id;
      }
      //Verbindung schliessen.
      $statement->close();
    }

    public function get_id_by_login($email, $password){
      $tableName = 'benutzer';
      //Query vorbereiten. Die Fragezeichen sind Platzhalter, welche später durch die Parameter ersetzt werden.
      $query = "SELECT ID FROM $tableName WHERE EMAIL = ? AND PASSWORD = ? limit 1";
      //Das Query preparen und gleich die Connection initialisieren.
      $statement = ConnectionHandler::getConnection()->prepare($query);
      if($statement === false){
        die(ConnectionHandler::getConnection()->error);
      }
      else{
        //Die beiden Parameter email und password in das prepared Statement einfügen.
        //Tipp: ss steht für zwei string parameter.
        $statement->bind_param("ss", $email, $password );
      }
      //Überprüfen ob das Statement ausführbar ist.
      if (!$statement->execute()) {
        throw new Exception($statement->error);
      }
      else {
        //ID als ausgabewert definieren.
        $statement->bind_result($id);
        $statement->fetch();
        //$id zurückgeben.
        return $id;
      }
      //Verbindung schliessen.
      $statement->close();
    }

    public function get_nickname_by_id($id){
      $tableName = 'benutzer';
      //Query vorbereiten. Die Fragezeichen sind Platzhalter, welche später durch die Parameter ersetzt werden.
      $query = "SELECT NICKNAME FROM $tableName WHERE ID = ? limit 1";
      //Das Query preparen und gleich die Connection initialisieren.
      $statement = ConnectionHandler::getConnection()->prepare($query);
      if($statement === false){
        die(ConnectionHandler::getConnection()->error);
      }
      else{
        //Der Parameter id in das prepared Statement einfügen.
        //Tipp: i steht für ein int parameter.
        $statement->bind_param("i", $id);
      }
      //Überprüfen ob das Statement ausführbar ist.
      if (!$statement->execute()) {
        throw new Exception($statement->error);
      }
      else {
        //ID als ausgabewert definieren.
        $statement->bind_result($nickname);
        $statement->fetch();
        //$id zurückgeben.
        return $nickname;
      }
      //Verbindung schliessen.
      $statement->close();
    }


  }
?>
