<?php
require 'config.php';

session_start(); 

//if not logged in, redirect to login page 
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

?>

<?= template_header('Admin') ?>
<?= template_nav() ?>
<?= template_admin_nav() ?>

    <!-- START PAGE CONTENT -->
    <h1 class="title">Admin Dashboard</h1>
    <p>This is where page content goes.</p>
    <!-- END PAGE CONTENT -->
</div>
</div>
<?= template_footer() ?>