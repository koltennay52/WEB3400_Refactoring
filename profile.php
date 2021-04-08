<?php
require 'config.php';

password_protect();
?>

<?= template_header('Profile') ?>
<?= template_nav() ?>
<?= template_admin_nav() ?>

    <!-- START PAGE CONTENT -->
    <h1 class="title">Profile Page</h1>
    <p>Welcome!</p>
    <!-- END PAGE CONTENT -->
    <!-- closing divs for admin template -->
    </div>
</div>

<?= template_footer() ?>