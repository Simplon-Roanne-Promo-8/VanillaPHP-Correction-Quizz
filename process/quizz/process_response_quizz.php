<?php 
var_dump('ppm');
session_start();
if (!empty($_POST['response'])) {
  
    require_once '../../config/connexion.php';

    $preparedRequest = $connexion->prepare(
        "SELECT * FROM answer 
        WHERE answer.id = ? 
        ");
    $preparedRequest->execute([
        $_POST['response']
    ]);

    $answer = $preparedRequest->fetch(PDO::FETCH_ASSOC);

    if ($answer['is_good_answer']) {
        // J'ajoute les points
        $_SESSION['score'] = $_SESSION['score'] + 1;

        header('Location: ../../quizz.php');
        die;
    }else{
        // J'ajoute pas de point

        header('Location: ../../quizz.php');
        die;
    }
}
