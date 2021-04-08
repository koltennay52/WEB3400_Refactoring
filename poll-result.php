<?php
require 'config.php';

password_protect();
// Connect to MySQL 
$pdo = pdo_connect_mysql();

if (isset($_GET['id'])) {
    // mySQL query that selects the poll records by GET request "id"
    $stmt = $pdo->prepare('SELECT * FROM polls WHERE id = ?'); 
    $stmt->execute([$_GET['id']]);
    
    //fetch the record 
    $poll = $stmt->fetch(PDO::FETCH_ASSOC);

    //Check if the poll record exists with the id specified
    if ($poll) {
        //MySQL query that selects all the poll answers 
        $stmt = $pdo->prepare('SELECT * FROM poll_answers WHERE poll_id = ? ORDER BY votes DESC');
        $stmt->execute([$_GET['id']]);
        //fetch the records 
        $poll_answers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        //total number of votes, will be used to calculate the percentage
        $total_votes = 0; 

        foreach ($poll_answers as $poll_answer) {
            // every poll answers' votes will be added to the total 
            $total_votes += $poll_answer['votes']; 
        }

    } else {
        $user_feedback->set_feedback('No poll exists with that id.', 'polls', 'danger');
    }
} else {
    $user_feedback->set_feedback('No poll ID was set.', 'polls', 'danger');
}
?>

<?= template_header('Poll Results') ?>
<?= template_nav() ?>

<!-- message sent confirmation goes here -->
<?php if ($user_feedback->msg and $user_feedback->route) : ?>
    <?= $user_feedback->template_feedback() ?>
<?php endif; ?> 


<!-- START PAGE CONTENT -->
<?php if (!$user_feedback->msg and !$user_feedback->route) : ?>
    <h1 class="title">Poll Results</h1>
    <h2 class="subtitle"><?= $poll['title'] ?> (Total Votes: <?= $total_votes ?>)</h2>
    <div class="container">
    <?php foreach ($poll_answers as $poll_answer) : ?>
            <p>
                <?= $poll_answer['title'] ?> (<?= $poll_answer['votes'] ?> votes)
            </p>
            <progress class="progress is-primary is-large" value="<?= @round(($poll_answer['votes'] / $total_votes) * 100) ?>"
                        max="<?= $total_votes * 2 ?>"
            >
            </progress>
            <?php endforeach ?>
    </div>
<?php endif; ?>   
<!-- END PAGE CONTENT -->

<?= template_footer() ?>