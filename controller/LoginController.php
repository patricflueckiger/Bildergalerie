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
    protected $loginRepository;
    public function __construct(){
      $this->loginRepository = new LoginRepository();

    }

    public function index()
    {

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
      $message;

      //Überprüfen ob alle Felder ausgefüllt wurden.
      if($_POST['password1']!=null&$_POST['password2']!=null&$_POST['nickname']!=null&$_POST['email']!=null){
        $email = $_POST['email'];
        $nickname = $_POST['nickname'];
        $password = md5($_POST['password']. 'Hier beliebiger Salt einfügen');

        //Email validieren
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $_SESSION['message'] = "Die Email ist nicht valid!";
          header('Location: /Bildergalerie/public/login/registration');
        }

        //Passwörter Validieren

        if($this->validate_passwort($_POST['password1']== false)){
          $_SESSION['message'] = "Das Passwort muss Mind. 1 Gross- Kleinbuchstabe, 1 Ziffer, 1 Sonderzeichen und MIN 8 Zeichen lang sein";
          header('Location: /Bildergalerie/public/login/registration');
        }
        else{
          //Passwörter überprüfen
          if($_POST['password1']!=$_POST['password2']){
            $_SESSION['message'] = "Die Passwörter stimmen nicht überein!";
            header('Location: /Bildergalerie/public/login/registration');

          }
          else{
            //Überprüfen ob die email schon in der Datenbank vorhanden ist.
            //Wenn diese Email noch nicht besteht, dann den User anlegen.
            if($this->validate_einmalig($email)){
              $this->loginRepository->create($nickname,$email,$password);
              header('Location: /Bildergalerie/');
            }
            else {
              $_SESSION['message'] = "Die Email wird bereits verwendet!";
              header('Location: /Bildergalerie/public/login/registration');
            }
          }
        }
      }
      else {

        $_SESSION['message'] = "Füllen sie alle Eingabefelder aus!";
        header('Location: /Bildergalerie/public/login/registration');
      }

    }

    public function einloggen(){
      $email;
      $password;

      if($_POST['send']){
        $email = $_POST['email'];
        $password = md5($_POST['password']. 'Hier beliebiger Salt einfügen');
          $id = $this->loginRepository->get_id_by_login($email, $password);

        if(isset($id)){
          $_SESSION["NICKNAME"] = $this->loginRepository->get_nickname_by_id($id);
          $_SESSION["UID"] = $id;

        }
        else{
          $_SESSION['message'] = "Die Login eingaben sind falsch";
        }
      }
      header('Location:/Bildergalerie/public/login');
    }

    public function logout(){
      session_unset();
      header('Location: /Bildergalerie/');
    }

    function validate_einmalig($email){
       if($this->loginRepository->get_id_by_email($email) != null){
         return false;
       }
       else{
         return true;
       }

    }

    function validate_passwort($password){
      $upper = preg_match("/[A-Z]{1,}/",$password);
      $lower = preg_match("/[a-z]{1,}/",$password);
      $number = preg_match("/[0-9]/",$password);
      $special = preg_match("/[\W_]{1,}/",$password);
      if(!$upper || !$lower || !$number || !$special || strlen($password) < 8)
      return false;
      else return true;

    }



  }



?>
