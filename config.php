<?php

//Change this to your connection info: 
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'W01260213';
$DATABASE_PASS = 'Koltencs!';
$DATABASE_NAME = 'W01260213';
//Try and connect using the info above: 
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
  //If there is an error with the connection, stop the script and display the error. 
  exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

function pdo_connect_mysql()
{
  //db connection constants
  $DATABASE_HOST = 'localhost';
  $DATABASE_USER = 'W01260213';
  $DATABASE_PASS = 'Koltencs!';
  $DATABASE_NAME = 'W01260213';

  //db connection
  try {
    return  new PDO(
      'mysql:host=' . $DATABASE_HOST . ';dbname=' .
        $DATABASE_NAME . ';charset=utf8',
      $DATABASE_USER,
      $DATABASE_PASS
    );
  } catch (PDOException $exception) {
    die('Failed to connect to the database.');
  }
}

//Feedback object
class UserFeedback {
  //Properties 
  public $msg; 
  public $route; 
  public $color; 

  //Setter
  public function set_feedback($msg, $route, $color) {
    $this->msg = $msg; 
    $this->route = $route;
    $this->color = $color;
  }

  //Template for displaying feedback message
  public function template_feedback()
  {
    echo <<<EOT
    <div class="notification is-$this->color">
      $this->msg Return to <a href="$this->route.php">$this->route</a> page, otherwise you will be redirected in 5 seconds.
    </div>
    EOT;
    header("Refresh:5; url=" . $this->route . ".php");
  }

}

//Instantiating global feedback object
$user_feedback = new UserFeedback(); 

function template_header($title = "Page title")
{
  echo <<<EOT
 <!DOCTYPE html>
  <html>

    <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>$title</title>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
     <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
     <script defer src="js/bulma.js"></script>
    </head>

  <body>
EOT;
}

function template_nav()
{
  echo <<<EOT
  <!-- START NAV -->
    <nav class="navbar is-light">
      <div class="container">
        <div class="navbar-brand">
          <a class="navbar-item" href="index.php">
            <span class="icon is-large">
              <i class="fas fa-home"></i>
            </span>
            <span>Site title</span>
          </a>
          <div class="navbar-burger burger" data-target="navMenu">
            <span></span>
            <span></span>
            <span></span>
          </div>
        </div>
        <div id="navMenu" class="navbar-menu">
          <div class="navbar-start">
            <!-- navbar link go here -->
          </div>
          <div class="navbar-end">
            <div class="navbar-item">
              <div class="buttons">
                <a href="login.php" class="button">
                  <span class="icon"><i class="fas fa-user"></i></span>
                  <span>Admin</span>
                </a>
                <a href="contact.php" class="button">
                  <span class="icon"><i class="fas fa-address-book"></i></span>
                  <span>Contact Us</span>
                </a>
EOT;
                if (!isset($_SESSION['loggedin'])) {
                  echo
                  '<a href="login.php" class="button">
                    <span class="icon"><i class="fas fa-sign-in-alt"></i></span>
                    <span>Login</span>
                  </a>';
                }
                if (isset($_SESSION['loggedin'])) {
                echo
                '<a href="logout.php" class="button">
                  <span class="icon"><i class="fas fa-sign-out-alt"></i></span>
                  <span>Logout</span>
                </a>';
                }  
                echo <<<EOT
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>
    <!-- END NAV -->

    <!-- START MAIN -->
    <section class="section">
        <div class="container">
EOT;
}

// Added new function for admin navigation
function template_admin_nav()
{

  echo <<<EOT
	<div class="columns">
	
		<!-- START LEFT NAV COLUMN -->	
		<div class="column is-one-quarter">
			<aside class="menu">
				<p class="menu-label"> Admin menu </p>
				<ul class="menu-list">
					<li><a href="admin.php" class="is-active"> Admin </a></li>
					<li><a href="profile.php"> Profile </a></li>
					<li><a href="polls.php"> Polls </a></li>
					<li><a href="contacts.php"> Contacts </a></li>
				</ul>
			</aside>
		</div>
		<!-- END LEFT NAV COLUMN-->
		
		<!-- START RIGHT CONTENT COLUMN -->
		<div class="column">
			
		
		<!-- END RIGHT CONTENT COLUMN-->
		

EOT;
}

function password_protect() {
  session_start(); 

  //if not logged in, redirect to login page 
  if (!isset($_SESSION['loggedin'])) {
      header('Location: login.php');
      exit;
  }

}

function template_footer()
{
  echo <<<EOT
        </div>
    </section>
    <!-- END MAIN-->

    <!-- START FOOTER -->
    <footer class="footer">
        <div class="container">
            <p>Footer content goes here</p>
        </div>
    </footer>
    <!-- END FOOTER -->
    </body>
  </html>
EOT;
}
