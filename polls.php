<?php
require 'config.php';

password_protect();
//Connect to MySQL
$pdo = pdo_connect_mysql();

//Query that selects all the polls from our database 
$stmt = $pdo->query('SELECT p.*, GROUP_CONCAT(pa.title ORDER BY pa.id) AS answers
                    FROM polls p LEFT JOIN poll_answers pa ON pa.poll_id = p.id
                    GROUP BY p.id');

$polls = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<?= template_header('Polls') ?>
<?= template_nav() ?>
<?= template_admin_nav() ?>

    <!-- START PAGE CONTENT -->
    <h1 class="title">Polls</h1>
    <p>Welcome, view our list of polls below: </p>
    <a href="poll-create.php" class="button is-primary is-small">
        <span class="icon"><i class="fas fa-plus-square"></i></span>
        <span>Create Poll</span>
    </a>
    <p>&nbsp;</p>
    <div class="container">
        <table class="table is-bordered is-hoverable">
            <thead>
                <tr>
                    <td>#</td>
                    <td>Title</td>
                    <td>Answers</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($polls as $poll): ?>
                    <tr>
                        <td>
                            <?= $poll['id'] ?>
                        </td>
                        <td>
                            <?= $poll['title'] ?>
                        </td>
                        <td>
                            <?= $poll['answers'] ?>
                        </td>
                        <td>
                            <a href="poll-vote.php?id=<?=$poll['id']?>" class="button is-link is-small" title="View Poll">
                                <span class="icon"><i class="fas fa-eye"></i></span>
                            </a>
                            <a href="poll-delete.php?id=<?=$poll['id']?>" class="button is-link is-small">
                                <span class="icon"><i class="fas fa-trash-alt"></i></span>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- closing divs for admin template -->
    </div>
</div>
    <!-- END PAGE CONTENT -->

<?= template_footer() ?>