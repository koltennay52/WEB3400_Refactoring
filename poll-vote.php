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
        $stmt = $pdo->prepare('SELECT * FROM poll_answers WHERE poll_id = ?');
        $stmt->execute([$_GET['id']]);
        //fetch the records 
        $poll_answers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // if the user clicked the "vote" button 
        if (isset($_POST['poll_answer'])) {
            //update the vote answer by 1
            $stmt = $pdo->prepare('UPDATE poll_answers SET votes = votes + 1 WHERE id = ?'); 
            $stmt->execute([$_POST['poll_answer']]); 
            header('Location: poll-result.php?id=' . $_GET['id']); 
            exit;
        }
        } else {
            $user_feedback->set_feedback('No poll exists with that id.', 'polls', 'danger');  
        }

} else {
    $user_feedback->set_feedback('No poll ID was set.', 'polls', 'danger'); 
}
?>

<?= template_header('Poll Vote') ?>
<?= template_nav() ?>

<?php if ($user_feedback->msg and $user_feedback->route) : ?>
    <?= $user_feedback->template_feedback() ?>
<?php endif; ?>

<!-- START PAGE CONTENT -->
<?php if (!$user_feedback->msg and !$user_feedback->route) : ?>
    <h1 class="title">Poll Vote - <?= $poll['title'] ?></h1>
    <h2 class="subtitle"><?= $poll['desc'] ?></h2>
    <form action="poll-vote.php?id=<?= $_GET['id']?>" method="post">
        <?php for ($i = 0; $i < count($poll_answers); $i++): ?>
        <div class="control">
            <label class="radio">
                <input type="radio" name="poll_answer" value="<?= $poll_answers[$i]['id'] ?>"
                    <?= $i ==0 ? ' checked' : '' ?>>
                <?=$poll_answers[$i]['title']?>
            </label>
        </div>
        <?php endfor; ?>
        <div class="field">
            <div class="control">
                <button class="button" value="Vote" type="submit">Vote</button>
            </div>
        </div>
    </form>
<?php endif; ?> 
<!-- END PAGE CONTENT -->

<?= template_footer() ?>