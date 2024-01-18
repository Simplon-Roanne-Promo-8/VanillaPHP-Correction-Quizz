<?php

    require_once './config/connexion.php';

    $preparedRequest = $connexion->prepare('SELECT * FROM question ORDER BY RAND() LIMIT 1');
    $preparedRequest->execute();
    $question = $preparedRequest->fetch(PDO::FETCH_ASSOC);
    // var_dump($question);


    $preparedRequest = $connexion->prepare('SELECT * FROM answer WHERE question_id = ? ORDER BY RAND()');
    $preparedRequest->execute([
        $question['id']
    ]);
    $answers = $preparedRequest->fetchAll(PDO::FETCH_ASSOC);
?>
<?php include './partials/header.php'; ?>


<section class="container">
    <h1 class="text-center">Quiz</h1>
</section>


<section class="container">
    <h2 class="text-center"> <?= $question['content'] ?></h2>
    <form action="./process/quizz/process_response_quizz.php" method="post">
        <div class="d-flex justify-content-center">
            <?php foreach ($answers as $answer) { ?>
                <button class="btn btn-warning m-2" type="submit" value="<?= $answer['id'] ?>" name='response'> <?= $answer['content']?></button>
            <?php } ?>
        </div>
    </form>
</section>

<?php include './partials/footer.php'; ?>
