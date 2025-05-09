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

if (!isset($TPL)) {
    $TPL = new PageTemplate();
    $TPL->PageTitle = "Register";
    $TPL->ContentBody = __FILE__;
    include "layout.php";
    exit;
}

$dbContext = new Database();
$valid = new Validator($_POST);

$email = "";
$password = "";
$passwordRepeat = "";
$name = "";
$street = "";
$postalCode = "";
$city = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordRepeat = $_POST['passwordRepeat'];
    $name = $_POST['name'];
    $street = $_POST['street'];
    $postalCode = $_POST['postalCode'];
    $city = $_POST['city'];

    $valid->field('email')->required()->email();
    $valid->field('password')->required()->min_len(1)->max_len(20);
    $valid->field('passwordRepeat')->equals($password);
    $valid->field('name')->required()->min_len(1)->max_len(50);
    $valid->field('street')->required()->min_len(1)->max_len(50);
    $valid->field('postalCode')->required()->max_len(10);
    $valid->field('city')->required()->max_len(50);


    // try {
    //     $userId = $dbContext->getUserDatabase()->getAuth()->register($email, $password, $email);
    //     header('Location: /');
    //     exit;
    // } catch (Exception $e) {
    //     $errorMessage = "Ngt gick fel";
    // }
    try {
        $userId = $dbContext->getUserDatabase()->getAuth()->register($_POST['email'], $_POST['password'], $_POST['email']);
        $dbContext->addUserDetails($userId, $name, $street, $postalCode, $city);
        header("Location: /");
        exit;
    } catch (\Delight\Auth\InvalidEmailException $e) {
        die('Invalid email address');
    } catch (\Delight\Auth\InvalidPasswordException $e) {
        die('Invalid password');
    } catch (\Delight\Auth\UserAlreadyExistsException $e) {
        die('User already exists');
    } catch (\Delight\Auth\TooManyRequestsException $e) {
        die('Too many requests');
    }
}

?>
<p>
<div class="row">

    <div class="row">
        <div class="col-md-12">
            <div class="newsletter">
                <p>User<strong>&nbsp;REGISTER</strong></p>
                <form method="POST">
                    <input class="input" name="email" value="<?php echo $email ?>" type="email" placeholder="Enter Your Email">
                    <br />
                    <?php echo $valid->get_error_message('email') ?>
                    <br />
                    <input class="input" name="password" type="password" placeholder="Enter Your Password">
                    <br />
                    <?php echo $valid->get_error_message('password') ?>

                    <br />
                    <input class="input" name="passwordRepeat" type="password" placeholder="passwordRepeat">
                    <br />
                    <?php echo $valid->get_error_message('passwordRepeat') ?>

                    <br />
                    <input class="input" name="name" type="name" placeholder="Name">
                    <br />
                    <?php echo $valid->get_error_message('name') ?>

                    <br />
                    <input class="input" name="street" type="street" placeholder="Street address">
                    <br />
                    <?php echo $valid->get_error_message('street') ?>

                    <br />
                    <input class="input" name="postalCode" type="postal" placeholder="Postal code">
                    <br />
                    <?php echo $valid->get_error_message('postalCode') ?>

                    <br />
                    <input class="input" name="city" type="city" placeholder="City">
                    <br />
                    <?php echo $valid->get_error_message('city') ?>

                    <br />
                    <button class="newsletter-btn"><i class="fa fa-envelope"></i> Register</button>
                </form>
            </div>
        </div>
    </div>


</div>


</p>