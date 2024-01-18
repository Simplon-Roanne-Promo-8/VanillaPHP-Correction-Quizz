<?php
session_start();
date_default_timezone_set('Europe/Paris');


if (!empty($_POST['pseudo']) && !empty($_POST['password'])) {

    require_once '../../config/connexion.php';


    $preparedRequest = $connexion->prepare("SELECT * FROM user WHERE pseudo = ?");
    $preparedRequest->execute([
        $_POST['pseudo']
    ]);
    $user = $preparedRequest->fetch(PDO::FETCH_ASSOC);
    if($user){
        header('Location: ../../register.php?error=Pseudo déja choisi');
        die;
    }

    $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $preparedRequest = $connexion->prepare("INSERT INTO user (pseudo, password, created_at) VALUES (?,?,?)");
    $preparedRequest->execute([
        $_POST['pseudo'],
        $hashedPassword,
        date("Y-m-d H:i:s")
    ]);


    $_SESSION['id'] = $connexion->lastInsertId();
    $_SESSION['pseudo'] = $_POST['pseudo'];
    $_SESSION['score'] = 0;

    header('Location: ../../index.php?success=Votre compte a bien été créé !');

}else{
    header('Location: ../../register.php?error=Remplis le formulaire&id=toto');
}