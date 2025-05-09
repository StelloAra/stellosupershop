<?php


ob_start();
require_once('lib/PageTemplate.php');
require_once('vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable(".");
$dotenv->load();

require_once('classes/userdatabase.php');
require_once('classes/database.php');
require_once('classes/Validator.php');

$dbContext = new Database();
$auth = $dbContext->getUserDatabase()->getAuth();


if (!isset($TPL)) {
    $TPL = new PageTemplate();
    $TPL->PageTitle = "Login";
    $TPL->ContentBody = __FILE__;
    include "layout.php";
    exit;
}

$email = "";
$password = "";
$message = "";
$name = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($auth->login($email, $password)) {
        header("Location: index.php");
        exit;
    } else {
        $message = "Felaktig e-postadress eler lösenord.";
    }
}

?>
<div class="col-md-12">
    <span>Välkommen, <?php echo htmlspecialchars($name); ?>!</span>
    <p style="color: red;"><?php echo $message; ?></p>

    <div class="newsletter">
        <p>User<strong>&nbsp;LOGIN</strong></p>
        <form method="POST">
            <input class="input" name="email" type="email" placeholder="Enter Your Email">
            <br />
            <br />
            <input class="input" name="password" type="password" placeholder="Enter Your Password">
            <br />
            <br />
            <button class="newsletter-btn"><i class="fa fa-envelope"></i> Login</button>
        </form>
        <a href="">Lost password?</a>
    </div>
</div>
</div>


</div>


</p>