<?php 
//var_dump($_GET);
require 'config.php';

// First we check if the email and code exist
if (isset($_GET['email'], $_GET['code'])) {
    if ($stmt = $con->prepare('SELECT * FROM accounts WHERE email = ? AND activation_code = ?')) {
        $stmt->bind_param('ss', $_GET['email'], $_GET['code']);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            //Account exists with the requested email and code
            if ($stmt = $con->prepare('UPDATE accounts SET activation_code = ? WHERE email = ? AND activation_code = ?')) {
                $newcode = 'activated';
                $stmt->bind_param('sss', $newcode, $_GET['email'], $_GET['code']);
                $stmt->execute();
                $user_feedback->set_feedback('Your account has been activated!', 'login', 'success'); 
            } else {
                $user_feedback->set_feedback('The account is already activated or does not exist.', 'login', 'danger'); 
            }
        }
        
    } else {
        $user_feedback->set_feedback('Could not prepare statement!', 'login', 'danger'); 
    }
 
}

?>

<?= template_header('Activate') ?>
<?= template_nav() ?>

<!-- message sent confirmation goes here -->
<?php if ($user_feedback->msg and $user_feedback->route) : ?>
    <?= $user_feedback->template_feedback() ?>
<?php endif; ?>

<?= template_footer() ?>