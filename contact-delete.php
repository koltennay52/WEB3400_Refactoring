<?php
require 'config.php';

password_protect();
// Connect to MySQL 
$pdo = pdo_connect_mysql();

if (isset($_GET['id'])) {
    //select the record that is going to be deleted 
    $stmt = $pdo->prepare('SELECT * FROM contacts WHERE id = ?'); 
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$contact) {
        $user_feedback->set_feedback('Contact does not exist with that ID.', 'contacts', 'danger'); 
    }

    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            //User clicked the "yes" button, delete the record
            $stmt = $pdo->prepare('DELETE FROM contacts WHERE id = ?');
            $stmt->execute([$_GET['id']]);  
            //output message
            $user_feedback->set_feedback('Successfully deleted contact!', 'contacts', 'success'); 
        } else {
            //user clicked the "no" button, redirect them back to the home/index page
            header('Location: contacts.php'); 
            exit;
        } 
    }

} else {
    $user_feedback->set_feedback('No contact ID was specified.', 'contacts', 'danger'); 
}
?>

<?= template_header('Delete Contact') ?>
<?= template_nav() ?>

<!-- START PAGE CONTENT -->
<h1 class="title">Delete Contact</h1>

<!-- message sent confirmation goes here -->
<?php if ($user_feedback->msg and $user_feedback->route) : ?>
    <?= $user_feedback->template_feedback() ?>
<?php endif; ?>

<?php if (!$user_feedback->msg and !$user_feedback->route) : ?>    
    <h2 class="subtitle">Are you sure you want to delete contact number: <?= $contact['id'] ?>?</h2>
    <a class="button is-success" href="contact-delete.php?id=<?= $contact['id'] ?>&confirm=yes">Yes</a>
    <a class="button is-danger" href="contact-delete.php?id=<?= $contact['id'] ?>&confirm=no">No</a>
    <!-- END PAGE CONTENT -->
<?php endif; ?>   

<?= template_footer() ?>