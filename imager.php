<!DOCTYPE html>
<?php
require_once("db_utils.php");
session_start();
$d = new Database();

$main_user = false;
if (isset($_POST["loginButton"])) {
    $main_user = $d->checkLogin($_POST["username"], $_POST["password"]);
    if (!$main_user) {
        header("Location: index.php?login-fail" . $main_user["name"]);
    } else {
        $_SESSION["user"] = $main_user;
        if ($_POST["remember-me"]) {
            setcookie("username", $main_user["username"], time() + 60 * 60 * 24 * 365);
        }
        header("Location: imager.php");
    }
}

$errorMessage = "";

if (!isset($_SESSION["user"])) {
    header("Location: index.php");
}

if (!$main_user) {
    $main_user = $_SESSION["user"];
}

if (isset($_POST["postaviStatus"])) {
    $success = $d->insertPost(htmlspecialchars($_POST["status"]), $main_user[COL_USER_ID]);
    if (!$success) {
        errorMessage("Status nije uspešno sačuvan.");
    } else {
        if (!isset($_SESSION["statusi"])) {
            $_SESSION["statusi"] = array();
        }
        $_SESSION["statusi"][] = htmlspecialchars($_POST["status"]);
    }
}

function errorMessage($message)
{
    global $errorMessage;
    $errorMessage = "<div class='error-msg kontejner svetlo'>$message</div>";
}
?>
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
        echo "<div>";
        foreach ($messages as $message) {
            echo "<div>$message</div>";
        }
        echo "</div><br>";
    }
    ?>
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-5">
                    <h1 class="heading-section" style="font-size: 70px;">IMAGER</h1>
                    <p style="color:#a400ea; background-color: 00005050;">A new revolutionary way to upload your images and share them with the world</p>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="login-wrap p-0">
                        <h3 class="mb-4 text-center">Uspesno ulogovan <?php echo $_SESSION["user"] ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>

</body>

</html>