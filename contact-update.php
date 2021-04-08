<?php
require 'config.php';

password_protect();
//Connect to MySQL
$pdo = pdo_connect_mysql();

if (isset($_GET['id'])) {
    //get the contact from the database
    $stmt = $pdo->prepare('SELECT * FROM contacts where id = ?');
    $stmt->execute([$_GET['id']]);

    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        $user_feedback->set_feedback('Contact does not exist with that ID.', 'contacts', 'danger'); 
    }

    //Checking if the POST data is empty; ie. if the form has been submitted
    if (!empty($_POST)) {
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');

        $stmt = $pdo->prepare('UPDATE contacts SET id = ?, name = ?, email = ?, phone = ?, title = ?, created= ? WHERE id = ?');
        $stmt->execute([$_GET['id'], $name, $email, $phone, $title, $created, $_GET['id']]);
        $user_feedback->set_feedback('Successfully updated contact!', 'contacts', 'success'); 
    }
} else {
    $user_feedback->set_feedback('No contact ID specified.', 'contacts', 'danger'); 
}

?>

<?= template_header('Contact Update') ?>
<?= template_nav() ?>

<!-- START PAGE CONTENT -->
<h1 class="title">Contact Update</h1>

<!-- confirmation message -->
<?php if ($user_feedback->msg and $user_feedback->route) : ?>
    <?= $user_feedback->template_feedback() ?>
<?php endif; ?>

<form action="contact-update.php?id=<?= $contact['id'] ?>" method="post">
    <div class="field">
        <label class="label">Name</label>
        <div class="control">
            <input type="text" name="name" class="input" value="<?= $contact['name'] ?>" required />
        </div>
    </div>

    <div class="field">
        <label class="label">Email</label>
        <div class="control">
            <input type="text" name="email" class="input" value="<?= $contact['email'] ?>" required />
        </div>
    </div>

    <div class="field">
        <label class="label">Phone</label>
        <div class="control">
            <input type="text" name="phone" class="input" value="<?= $contact['phone'] ?>" required />
        </div>
    </div>

    <div class="field">
        <label class="label">Title</label>
        <div class="control">
            <input type="text" name="title" class="input" value="<?= $contact['title'] ?>" required />
        </div>
    </div>

    <div class="field">
        <div class="control">
            <input type="submit" class="button" value="Update">
        </div>
    </div>
</form>
<!-- END PAGE CONTENT -->

<?= template_footer() ?>