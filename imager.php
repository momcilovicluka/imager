<?php
require_once("db_utils.php");
require_once("classes/Image.php");
session_start();
$d = new Database();
$main_user = false;
$filename = "";

if (isset($_POST["loginButton"])) {
    $main_user = $d->checkLogin($_POST["username"], $_POST["password"]);
    if (!$main_user) {
        header("Location: index.php?login-fail");
        exit();
    } else {
        $_SESSION["user"] = $main_user;
        if ($_POST["remember-me"]) {
            setcookie("username", $main_user["username"], time() + 60 * 60 * 24 * 365);
        }
        header("Location: imager.php");
    }
}

if (!isset($_SESSION["user"])) {
    header("Location: index.php");
}

if (!$main_user) {
    $main_user = $_SESSION["user"];
}

if (isset($_POST["uploadButton"])) {
    if (isset($_FILES["image"])) {
        processForm();
        $filename = "files/" . basename($_FILES["image"]["name"]);
        setcookie($main_user["username"], $_POST["title"], time() + 60 * 60 * 24 * 365);
        $success = $d->insertImage($_POST["title"], $main_user["username"], $filename);
        if (!$success) {
            errorMessage("You already uploaded an image with that title.");
        }
    } else {
        redirect();
    }
}

function redirect()
{
    echo ("<script>
            alert(\"Please upload or select a file...\");
            window.location.replace(\"./\");
        </script>");
}

function processForm()
{
    if ($_FILES["image"]["error"] == UPLOAD_ERR_OK) {
        if (!move_uploaded_file($_FILES["image"]["tmp_name"], "files/" . basename($_FILES["image"]["name"]))) {
            $message = "Sorry, there was a problem uploading that file.";
        }
    } else {
        switch ($_FILES["image"]["error"]) {
            case UPLOAD_ERR_INI_SIZE:
                $m = "The file is larger than the server allows.";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $m = "The file is larger than the script allows.";
                break;
            default:
                $m = "Please contact your server administrator for help.";
        }
        $message = "Sorry, there was a problem uploading that file. $m";
        errorMessage($message);
    }
}

$images = array();
$imagesBase = $d->getImages();

foreach ($imagesBase as $image) {
    $images[] = new Image($image["title"], $image["username"], $image["image"]);
}

function errorMessage($message)
{
    global $messages;
    $messages[] = $message;
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

<body class="" style="background-image: url(images/bg.jpg);">
    <?php
    if (!empty($messages)) {
        echo "<div class=\"mb-4 text-center\">";
        foreach ($messages as $message) {
            echo ("<script>
            alert(\"{$message}\");
        </script>");
        }
        echo "</div>";
    }
    ?>
    <div>
        <h3 class="mb-4" style="font-size:20px;color:white; font-weight:100; padding-left:5px"><?= $main_user["username"]; ?></h3>
        <div style="position: absolute; top: 0; left: 0; right: 0; margin-left: auto; margin-right:auto;" class="login-wrap p-0">
            <div class="heading-section" style="position: relative; top: 0; left: 0; right: 0; margin-left: 47%; margin-right:auto;">
                <p style="font-size:35px;">IMAGER</p>
            </div>
        </div>
        <div style="position: absolute; top: 0; right: 0; padding: 10px;" class="login-wrap p-0">
            <div style="position: relative; top: 0; right: 0; padding: 12px;" class="social d-flex text-center">
                <a href="index.php?logout" class="px-2 py-2 mr-md-1 rounded">Logout</a>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="login-wrap p-0">
                <h3 style="font-size:20;" class="mb-4 text-center">Uploan an image yourself:</h3>
                <form action="" enctype="multipart/form-data" method="post" class="signin-form">
                    <div class="form-group">
                        <input type="text" name="title" value="<?php if (isset($_COOKIE[$main_user["username"]])) echo $_COOKIE[$main_user["username"]];
                                                                else echo "Image title" ?>" class="form-control" placeholder="Title" required>
                    </div>
                    <div class="form-group">
                        <input type="file" name="image" class="form-control" placeholder="Image" accept="image/png, image/gif, image/jpeg" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="uploadButton" class="form-control btn btn-primary submit px-3">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div>

    </div>
    <?php
    $count = 0;
    foreach ($images as $image) {
        if ($count == 0)
            echo "<div class=\"containerImage\">";
        echo $image->getHtml();
        $count++;
        if ($count == 4) {
            echo "</div>";
            $count = 0;
        }
    }
    ?>
    </div>
    <div style="text-align: center; padding:3%">
        <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>

</body>

</html>