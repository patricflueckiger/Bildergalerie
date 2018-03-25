<?php
require_once '../repository/LoginRepository.php';
/**
 * Controller für das Login und die Registration, siehe Dokumentation im DefaultController.
 */
  class LoginController
  {
    /**
     * Default-Seite für das Login: Zeigt das Login-Formular an
	 * Dispatcher: /login
     */
    public function index()
    {
      $loginRepository = new LoginRepository();
      $view = new View('login_index');
      $view->title = 'Bilder-DB';
      $view->heading = 'Login';
      $view->display();
    }
    /**
     * Zeigt das Registrations-Formular an
	 * Dispatcher: /login/registration
     */
    public function registration()
    {
      $view = new View('login_registration');
      $view->title = 'Bilder-DB';
      $view->heading = 'Registration';
      $view->display();
    }

    public function benutzer_erstellen(){
      $nickname;
      $email;
      $password;
      IF($_POST['send']){
        $email = $_POST['email'];
        $nickname = $_POST['nickname'];
        $password = md5($_POST['password']. 'Hier beliebiger Salt einfügen');
      }

      $loginRepository = new LoginRepository();
      $loginRepository->create($nickname,$email,$password);
      header('Location: /Bildergalerie/');
    }

    public function einloggen(){
      $email;
      $password;
      $loginRepository = new LoginRepository();


      if($_POST['send']){
        $email = $_POST['email'];
        $password = md5($_POST['password']. 'Hier beliebiger Salt einfügen');
        $id = $loginRepository->get_id_by_login($email, $password);

        if(isset($id)){
          $_SESSION["NICKNAME"] = $loginRepository->get_nickname_by_id($id);
          $_SESSION["UID"] = $id;
          header('Location: /Bildergalerie/');
        }
        else{

        }
      }
    }

    public function logout(){
      session_unset();
      header('Location: /Bildergalerie/');
    }
  }



?>
