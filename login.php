<?php
require 'config.php';

//additional php code for this page goes here

?>

<?= template_header('Home') ?>
<?= template_nav() ?>


<!-- START PAGE CONTENT -->
<h1 class="title">Login</h1>
<div class="columns">
    <div class="column is-half">
        <div class="card">
            <div class="card-content">
                <form action="authenticate.php" method="post">
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
                            <button class="button is-info is-fullwidth is-outlined">
                                <span class="icon">
                                    <i class="fas fa-sign-in-alt"></i>
                                </span>
                                <span>Login</span>
                            </button>

                        </p>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<br>
<div class="buttons">
    <a href="register.php" class="button">Sign Up</a>
    <a href="" class="button">Forgot Password</a>
    <a href="contact.php" class="button">Need Help</a>
</div>

<!-- END PAGE CONTENT -->

<?= template_footer() ?>