<?php	
	require_once("db_utils.php");
	session_start();
	$d = new Database();
	
	$main_user = false;
	if (isset($_POST["loginButton"])) {
		$main_user = $d->checkLogin($_POST["username"], $_POST["password"]);
		if (!$main_user) {
			header( "Location: login.php?login-fail" );
		} else {
			$_SESSION["user"] = $main_user;
			if ($_POST["remember-me"]) {
				setcookie("username", $main_user[COL_USER_USERNAME], time()+60*60*24*365);
			}
			header( "Location: profile.php" );
		}
	}

	$errorMessage = "";
	
	if (!isset($_SESSION["user"])) {
		header( "Location: login.php" );
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

	function getPostHTML($post, $user) {
		return 
			"<div class=\"kontejner\">
				<div class=\"post-zaglavlje\">
					<img src=\"{$user[COL_USER_AVATAR]}\" alt=\"Avatar\" class=\"profilna-slika-zid\">
					<h4>{$user[COL_USER_NAME]}</h4>
					<p>{$post[COL_POST_TIME]}</p>
				</div>
				<div class=\"post-sadrzaj\">
					<p>{$post[COL_POST_CONTENT]}</p>
				</div>
			</div>";
	}
	
	function errorMessage($message) {
		global $errorMessage;
		$errorMessage = "<div class='error-msg kontejner svetlo'>$message</div>";
	}
?>

<html>
<head>
	<title><?php echo $main_user[COL_USER_NAME]; ?></title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/profile.css">
</head>
<body>
	<!-- Navigacija -->
	<div class="navigacija tamno">
		<a href="#" class="tamnije"><img src="images/home.png"> <span style="margin: 0px 20px;">Logo</span></a>
		<a href="#"><img src="images/globe.png"></a>
		<a href="#"><img src="images/pawn.png"></a>
		<a href="#"><img src="images/envelope.png"></a>
		<a href="#"><img src="images/bell.png"> 3</a> 
		<a href="login.php?logout" id="logout-button"><img src="<?php echo $main_user[COL_USER_AVATAR];?>"></a>
	</div>

	<!-- Glavni sadržaj -->
	<div id="sadrzaj">
		<div id="leva-kolona">
			<div class="kontejner svetlo">
				<div class="centrirano">
					<h3><?php echo $main_user[COL_USER_NAME];?></h3>
					<img src="<?php echo $main_user[COL_USER_AVATAR];?>" alt="Profilna slika" class="profilna-slika">
				</div>
				<hr>
				<p><img src="images/pencil_gray.png" class="ikonica"> <?php echo $main_user[COL_USER_PROFESSION];?></p>
				<p><img src="images/home_gray.png" class="ikonica"> <?php echo $main_user[COL_USER_ADDRESS];?></p>
				<p><img src="images/cake_gray.png" class="ikonica"> <?php echo $main_user[COL_USER_BIRTHDAY];?></p>
			</div>
		</div>
			
		<div id="srednja-kolona">
			<?php echo $errorMessage; ?>
			<div class="kontejner svetlo">
				<form action="" method="post" enctype="multipart/form-data">
					Novi status: <input type="text" name="status"><br>
					<input type="submit" value="Postavi" name="postaviStatus">
				</form>
			</div>
			<?php
				$posts = $d->getPosts($main_user[COL_USER_ID]);
				if (count($posts)>0){
                    foreach($posts as $post){
                        echo getPostHTML($post, $main_user);
                    }
                }

			?>	    		
		</div>
		<div id="desna-kolona">
			<div class="kontejner svetlo">
				<h4>Događaji</h4>
				<img src="images/image3.jpg" width="200">
				<h5>Godišnji odmor</h5>
				<p>Petak u 15 h</p>
			</div>
			<div class="kontejner svetlo">
				<h4>Statusi</h4>
				<p>
					Broj statusa od poslednjeg logina:
					<?php
						$statusi = isset($_SESSION["statusi"]) ? $_SESSION["statusi"] : array();
						echo count($statusi);
						echo "<ul>";
						foreach ($statusi as $status) {
							echo "<li>$status</li>";
						}
						echo "</ul>";
					?>		
				</p>
			</div>
		</div>
	</div>
</body>
</html> 
