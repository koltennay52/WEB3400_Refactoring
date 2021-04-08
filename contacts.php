<?php
require 'config.php';

password_protect();
//Connect to MySQL
$pdo = pdo_connect_mysql();

//Query that selects all the contacts from our database 
$stmt = $pdo->query('SELECT * FROM contacts');

$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC)

?>

<?= template_header('Contacts') ?>
<?= template_nav() ?>
<?= template_admin_nav() ?>

    <!-- START PAGE CONTENT -->
    <h1 class="title">Contacts</h1>
    <p>Welcome, view our list of contacts below: </p>
    <a href="contact-create.php" class="button is-primary is-small">
        <span class="icon"><i class="fas fa-plus-square"></i></span>
        <span>Create Contact</span>
    </a>
    <p>&nbsp;</p>
    <div class="container">
        <table class="table is-bordered is-hoverable">
            <thead>
                <tr>
                    <td>#</td>
                    <td>Name</td>
                    <td>Email</td>
                    <td>Phone</td>
                    <td>Title</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contacts as $contact): ?>
                    <tr>
                        <td>
                            <?= $contact['id'] ?>
                        </td>
                        <td>
                            <?= $contact['name'] ?>
                        </td>
                        <td>
                            <?= $contact['email'] ?>
                        </td>
                        <td>
                            <?= $contact['phone'] ?>
                        </td>
                        <td>
                            <?= $contact['title'] ?>
                        </td>
                        <td>
                            <a href="contact-update.php?id=<?=$contact['id']?>" class="button is-link is-small" title="Update Contact">
                                <span class="icon"><i class="fas fa-pen-alt"></i></span>
                            </a>
                            <a href="contact-delete.php?id=<?=$contact['id']?>" class="button is-link is-small">
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