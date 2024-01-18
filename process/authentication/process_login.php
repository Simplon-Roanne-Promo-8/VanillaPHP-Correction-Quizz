<?php
session_start();


if (!empty($_POST['pseudo']) && !empty($_POST['password'])) {

    require_once '../../config/connexion.php';

    $preparedRequest = $connexion->prepare("SELECT * FROM user WHERE pseudo = ?");
    $preparedRequest->execute([
        $_POST['pseudo']
    ]);

    $user = $preparedRequest->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['id'] = $user['id'];
        $_SESSION['pseudo'] = $user['pseudo'];
        $_SESSION['score'] = 0;
    }else{
        header('Location: ../../login.php?error=Pseudo ou Mot de passe incorrect');
        die;
    }
    header('Location: ../../index.php?success=Vous êtes bien connecté');
    die;
}else{
    header('Location: ../../login.php?error=Remplis le formulaire');
    die;
}