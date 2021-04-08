<?php
require 'config.php';

$register_msg = '';

// Now we we check if the data was submitted, isset() function will check if the data exists
if (isset($_POST['username'], $_POST['password'], $_POST['email'])) {
// We need to check if the account with that username exists
    if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
        // Bind parameters (s=string, i = int, etc) has the password using the PHP password_hash function
        $stmt->bind_param('s', $_POST['username']);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            //Username already exists
            $register_msg = 'Username already exists. Please choose another.'; 
        } else {
            //username doesn't exist, insert new account
            if ($stmt = $con->prepare('INSERT INTO accounts (username, password, email, activation_code) VALUES (?,?,?,?)')) {
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $uniqid = uniqid();
                $stmt->bind_param('ssss', $_POST['username'], $password, $_POST['email'], $uniqid);
                $stmt->execute();
                //send confirmation email
                $from = 'knay@weber.edu';
                $subject = 'Account Activation Required';
                $headers = 'From: ' . $from . "\r\n" . 'Reply-To: ' . $from . "\r\n"
                            . 'X-Mailer: PHP/' . phpversion() . "\r\n"
                            . 'MIME-Version: 1.0' . "\r\n"
                            . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
                $activaton_link = 'https://icarus.cs.weber.edu/~kn60213/web3400/project3/activate.php?email='. $_POST['email'] . '&code=' . $uniqid;
                $message = '<p>Please click the following link to activate your account: <a href="' . $activaton_link . '">' . $activaton_link . '</a></p>';
                echo "<a href='$activaton_link'>$activaton_link</a>";
            } else {
                //something is wrong with the sql statement, check to make sure the accounts table exists with all 3 fields
                $register_msg ='Account registration failed. Please try again.';
            }
        }
        $stmt->close();
    } else {
        $register_msg = 'Account registration failed. Please try again.'; 
    }

    $con->close();

}

?>

<?= template_header('Register') ?>
<?= template_nav() ?>



<!-- START PAGE CONTENT -->
<h1 class="title">Register</h1>
<?php if ($register_msg) : ?>
    <div class="notification is-primary">
      <?= $register_msg ?>
    </div>
<?php endif; ?>
<form action="register.php" method="post">
    <div class="field">
        <p class="control has-icons-left">
            <input name="email" class="input" type="email" placeholder="email" required>
            <span class="icon is-small is-left">
                <i class="fas fa-envelope-open-text"></i>
            </span>
        </p>
    </div>
    <div class="field">
        <p class="control has-icons-left">
            <input name="username" class="input" type="text" placeholder="Username" required>
            <span class="icon is-small is-left">
                <i class="fas fa-user"></i>
            </span>
        </p>
    </div>
    <div class="field">
        <p class="control has-icons-left">
            <input name="password" class="input" type="password" placeholder="Password" required>
            <span class="icon is-small is-left">
                <i class="fas fa-lock"></i>
            </span>
        </p>
    </div>
    <div class="field">
        <p class="control">
            <button class="button is-success">
                Register
            </button>
        </p>
    </div>
</form>
<!-- END PAGE CONTENT -->

<?= template_footer() ?>