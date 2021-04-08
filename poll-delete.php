<?php
require 'config.php';

password_protect();
// Connect to MySQL 
$pdo = pdo_connect_mysql();

if (isset($_GET['id'])) {
    //select the record that is going to be deleted 
    $stmt = $pdo->prepare('SELECT * FROM polls WHERE id = ?'); 
    $stmt->execute([$_GET['id']]);
    $poll = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$poll) {
        $user_feedback->set_feedback('There are no polls with the ID specified.', 'polls', 'danger');
    }

    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            //User clicked the "yes" button, delete the record
            $stmt = $pdo->prepare('DELETE FROM polls WHERE id = ?');
            $stmt->execute([$_GET['id']]); 
            // We also need to delete the answers for that poll
            $stmt = $pdo->prepare('DELETE FROM poll_answers WHERE poll_id = ?'); 
            $stmt->execute([$_GET['id']]); 
            //output message
            $user_feedback->set_feedback('Poll was successfully deleted!', 'polls', 'success');
        } else {
            //user clicked the "no" button, redirect them back to the home/index page
            header('Location: polls.php'); 
            exit;
        } 
    }

} else {
    $user_feedback->set_feedback('There was no poll ID specificed.', 'polls', 'danger');
}
?>

<?= template_header('Delete Poll') ?>
<?= template_nav() ?>

<!-- message sent confirmation goes here -->
<?php if ($user_feedback->msg and $user_feedback->route) : ?>
    <?= $user_feedback->template_feedback() ?>
<?php endif; ?>

<!-- START PAGE CONTENT -->
<h1 class="title">Delete Poll</h1>
<?php if (!$user_feedback->msg and !$user_feedback->route) : ?>
    <h2 class="subtitle">Are you sure you want to delete poll number: <?= $poll['id'] ?>?</h2>
    <a class="button is-success" href="poll-delete.php?id=<?= $poll['id'] ?>&confirm=yes">Yes</a>
    <a class="button is-danger" href="poll-delete.php?id=<?= $poll['id'] ?>&confirm=no">No</a>
<?php endif; ?>   

<?= template_footer() ?>