<?php
require_once("db_utils.php");

$d = new Database();
$errors = [];
$messages = [];

session_start();

if (isset($_GET["logout"])) {
    session_destroy();
} elseif (isset($_SESSION["user"])) {
    header("Location: imager.php");
}

if (isset($_GET["login-fail"])) {
    $messages[] = "Pogrešan username ili šifra";
}

if (isset($_GET["forget-me"])) {
    setcookie("username", "", time() - 1000);
    header("Location: index.php");
}

function outputError($errorCode)
{
    global $errors;
    if (isset($errors[$errorCode])) {
        echo '<div class="error">' . $errors[$errorCode] . '</div>';
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
    <?php
    if (!empty($messages)) {
        echo "<div class=\"messages\" style=\"position:absolute; top: 0; left: 0; width: 100%; text-align: center;\">";
        foreach ($messages as $message) {

            echo "<h4 style=\"color:#ea0069; text-align: center; position:relative; background-color: 00005050;\">$message</h4>";
        }
        echo "</div>";
    }
    ?>
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-5">
                    <h1 class="heading-section" style="font-size: 70px; transform:translateY(-25%)">IMAGER</h1>
                    <!-- 
                        <p style="color: #ffffff; border-radius:50px;">A new revolutionary way to upload your images and share them with the world</p>
                    -->
                </div>
            </div>
            <div class="row justify-content-center" style="transform:translateY(40%)">
                <div class="col-md-6 col-lg-4">
                    <div class="login-wrap p-0">
                        <!-- 
                            <h3 class="mb-4 text-center">Login and start sharing images!</h3>
                        -->
                        <form action="imager.php" method="post" class="signin-form">
                            <div class="form-group">
                                <input type="text" name="username" value="<?php echo isset($_COOKIE["username"]) ? $_COOKIE["username"] : ""; ?>" class="form-control" placeholder="Username" required>
                                <!--<label style="color:white; position:absolute; top:3px; left: 20px; padding: 10px 0; ">
                                    Username
                                </label>-->
                            </div>
                            <div class="form-group">
                                <input id="password-field" type="password" name="password" class="form-control" placeholder="Password" required>
                                <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>
                            <div class="form-group">
                                <button type="submit" style="color: white !important;" name="loginButton" class="form-control btn btn-primary submit px-3">Log In</button>
                            </div>
                            <div class="form-group d-md-flex">
                                <div class="w-50">
                                    <label class="checkbox-wrap checkbox-primary">Remember Me
                                        <input type="checkbox" name="remember-me" checked>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="w-50 text-md-right">
                                    <a href="?forget-me" style="color: #0000ff; padding:5px">Forget me</a>
                                </div>
                            </div>
                        </form>
                        <div class="social d-flex text-center">
                            <a href="signup.php" class="px-2 py-2 mr-md-1 rounded">Sign up</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <br>
    <div class=" text-center" style="color: #ffffff; font-size: 20px; position: relative; padding-top:5%; transform:translateY(15px); margin-bottom:0; bottom: 0; width: 100%;">
        <p>
            Made with <i class="fa fa-heart" style="color: #ea0069; margin-bottom:0;"></i> by <a href="https://github.com/momcilovicluka" target="_blank">Luka</a>
        </p>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>

</body>

</html>