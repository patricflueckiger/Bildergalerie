
<?php
/**
   * Login-Formular
   * Das Formular wird mithilfe des Formulargenerators erstellt.
   */

   $lblClass = "col-md-2";
   $eltClass = "col-md-4";
   $btnClass = "btn btn-success";

   $form = new Form("benutzer_erstellen","post");
   $button = new ButtonBuilder();
   if(isset($_SESSION["message"])){
     echo "<h2>".$_SESSION["message"]."</h2>";
     session_unset($_SESSION['message']);
   }

   echo $form->input()->label('Nickname')->name('nickname')->type('text')->lblClass($lblClass)->eltClass($eltClass);
   echo $form->input()->label('E-Mail')->name('email')->type('email')->lblClass($lblClass)->eltClass($eltClass);
   echo $form->input()->label('Passwort')->name('password1')->type('password')->lblClass($lblClass)->eltClass($eltClass);
   echo $form->input()->label('Passwort (bestätigen)')->name('password2')->type('password')->lblClass($lblClass)->eltClass($eltClass);
   echo $button->start($lblClass, $eltClass);
   echo $button->label('Login')->name('send')->type('submit')->class('btn-success');
   echo $button->end();
 echo $form->end();
?>
