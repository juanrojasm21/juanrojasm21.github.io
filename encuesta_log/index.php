<?php

include_once 'includes/user.php';
include_once 'includes/user_session.php';
date_default_timezone_set('America/Lima');
$userSession = new UserSession();
$user = new User();

if(isset($_SESSION['user'])){
    //echo "Hay sesión";
    $user->setUser($userSession->getCurrentUser());
    include_once 'vistas/home.php';
}else if(isset($_POST['username']) && isset($_POST['password'])){
    //echo "Validación de login";
    $userForm = $_POST['username'];
    $passForm = $_POST['password'];
    
    if($user->userExists($userForm, $passForm)){
        //echo "usuario validado";
        $userSession->setCurrentUser($userForm);
        $user->setUser($userForm);
        $dateAcceso=strval($user->getFecha());
        $date1 = new DateTime($dateAcceso."+1 days");
        $date2 = new DateTime("now");
        //echo $date2->format('Y-m-d');
        $diff = $date1->diff($date2);                        
        $valdiff=$diff->days;
        if($valdiff!=0){
            include_once 'vistas/home.php';
        }
        else{
            include_once 'vistas/block.php';
        }       
    }else{
        //echo "nombre de usuario y/o password incorrecto";
        $errorLogin = "Nombre de usuario y/o password es incorrecto";
        include_once 'vistas/login.php';
    }

}else{
    //echo "Login";
    include_once 'vistas/login.php';
}


?>