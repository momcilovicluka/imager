<?php
require_once("db_utils.php");

$d = new Database();
$errors = [];
$messages = [];

$name = $username = $password1 = $password2 =  "";

if (isset($_POST["signup"])) {
    // Setovanje promenljivih iz registracione forme
    if ($_POST["name"]) {
        $name = htmlspecialchars($_POST["name"]);
    }
    if ($_POST["username"]) {
        $username = htmlspecialchars($_POST["username"]);
    }
    if ($_POST["password1"]) {
        $password1 = htmlspecialchars($_POST["password1"]);
    }
    if ($_POST["password2"]) {
        $password2 = htmlspecialchars($_POST["password2"]);
    }
    // Validacija podataka iz registracione forme
    if (!$name) {
        $errors["name"] = "Unesite ime i prezime";
    }
    if (!$username) {
        $errors["username"] = "Unesite korisničko ime";
    }
    if (!$password1) {
        $errors["password1"] = "Unesite lozinku";
    }
    if ($password1 != $password2) {
        $errors["poklapanjeLozinki"] = "Lozinke su različite";
    }

    if (empty($errors)) {
        $success = $d->insertUser($username, $password1, $name);
        $messages[] = $success ? "Uspešno ste se registrovali" : "Registracija nije uspela";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Imager</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</head>

<body class="img js-fullheight" style="background-image: url(images/bg.jpg);">
    <section class="ftco-section">
        <?php
        if (!empty($messages)) {
            echo "<div class=\"messages\" style=\"position:absolute; top: 0; left: 0; width: 100%; text-align: center;\">";
            foreach ($messages as $message) {
                echo "<h4 style=\"color:#ea0069; text-align: center; position:relative; background-color: 00005050;\">$message</h4>";
            }
            echo "</div>";
        }
        if (!empty($errors)) {
            echo "<div class=\"messages\" style=\"position:absolute; top: 0; left: 0; width: 100%; text-align: center;\">";
            foreach ($errors as $message) {
                echo "<h4 style=\"color:#ea0069; text-align: center; position:relative; background-color: 00005050;\">$message</h4>";
            }
            echo "</div><br>";
        }
        ?>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-5">

                    <h1 class="heading-section" style="font-size: 70px; transform:translateY(-25%)">IMAGER</h1>
                    <!--
                    <p style="color:#fff; background-color: 00005050;">Join people who are already using imager</p>
                -->
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="login-wrap p-0">
                        <h3 class="mb-4 text-center">You can sign up now! </h3>
                        <form action="" method="post" class="signin-form">
                            <div class="form-group">
                                <input type="text" name="name" value="<?= $name ?>" class="form-control" placeholder="Full Name" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="username" value="<?= $username ?>" class="form-control" placeholder="Username" required>
                            </div>
                            <div class="form-group">
                                <input id="password-field1" type="password" name="password1" class="form-control" placeholder="Password" required>
                                <span toggle="#password-field1" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>
                            <div class="form-group">
                                <input id="password-field2" type="password" name="password2" class="form-control" placeholder="Repeat Password" required>
                                <span toggle="#password-field2" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>
                            <div class="form-group">
                                <button type="submit" style="color: white !important;" name="signup" class="form-control btn btn-primary submit px-3">Sign Up</button>
                            </div>
                        </form>
                        <div class="social d-flex text-center">
                            <a href="index.php" class="px-2 py-2 mr-md-1 rounded">Log In</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class=" text-center" style="color: #ffffff; font-size: 20px; position: relative; padding-top:5%; transform:translateY(-103px); width: 100%;">
        <p>
            Made with <i class="fa fa-heart" style="color: #ea0069;"></i> by <a href="https://github.com/momcilovicluka" target="_blank">Luka</a>
        </p>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>

</body>

</html>