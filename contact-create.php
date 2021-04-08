<?php
require 'config.php';

password_protect();
// Connect to MySQL 
$pdo = pdo_connect_mysql();

//check if POST Data is not empty 
if (!empty($_POST)) {
    //check to see if the data from the form is set 
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');

    //insert the new contact record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO contacts VALUES (NULL, ?, ?, ?, ?, ?)');
    $stmt->execute([$name, $email, $phone, $title, $created]); 

       
    $user_feedback->set_feedback('Successfully added contact!', 'contacts', 'success'); 
}

?>

<?= template_header('Create Contact') ?>
<?= template_nav() ?>
<?= template_admin_nav() ?>


<!-- START PAGE CONTENT -->
<h1 class="title">Create Contact</h1>

<!-- message sent confirmation goes here -->
<?php if ($user_feedback->msg and $user_feedback->route) : ?>
    <?= $user_feedback->template_feedback(); ?>
<?php endif; ?>

<form action="" method="post">
    <div class="field">
        <label class="label">Name</label>
        <div class="control">
            <input type="text" name="name" class="input" required />
        </div>
    </div>

    <div class="field">
        <label class="label">Email</label>
        <div class="control">
            <input type="text" name="email" class="input" required />
        </div>
    </div>

    <div class="field">
        <label class="label">Phone</label>
        <div class="control">
            <input type="text" name="phone" class="input" required />
        </div>
    </div>

    <div class="field">
        <label class="label">Title</label>
        <div class="control">
            <input type="text" name="title" class="input" required />
        </div>
    </div>

    <div class="field">
        <div class="control">
            <input type="submit" class="button" value="Create Contact">
        </div>
    </div>
</form>
<!-- END PAGE CONTENT -->

<?= template_footer() ?>