<?php 
	include("includes/config.php");
	include("includes/classes/Account.php");
	include("includes/classes/Constants.php");

	$account = new Account($con);

	include("includes/handlers/register-handler.php");
	include("includes/handlers/login-handler.php");

	function getInputValue($name){
		if(isset($_POST[$name])){
			echo $_POST[$name];
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Welcome to FavMusic!</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="assets/js/register.js"></script>
	<link rel="stylesheet" href="assets/css/register.css">
	<link href="https://fonts.googleapis.com/css2?family=Merienda+One&family=Montserrat:wght@300&display=swap" rel="stylesheet">
 	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
  	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&display=swap" rel="stylesheet">
</head>
<body>

	<?php 

		if(isset($_POST['registerButton'])){
			echo '<script>
					$(document).ready(function(){
						$("#loginForm").hide();
						$("#registerForm").show();
					});
				 </script>';
		}
		else {
			echo '<script>
					$(document).ready(function(){
						$("#loginForm").show();
						$("#registerForm").hide();
					});
				 </script>';
		}

	 ?>



	<div id="background">

		<div id="loginContainer">

			<div id="inputContainer">
				<form id="loginForm" action="register.php" method="POST">
					<h2>Login to Your Account</h2>
					<p>
						
						<label for="loginUsername">Username: </label>
						<input id="loginUsername" type="text" name="loginUsername" placeholder="Your Username" value="<?php getInputValue('loginUsername') ?>" required autofocus="on">
					</p>
					<p>
						<label for="loginPwd">Password: </label>
						<input id="loginPwd" type="password" name="loginPwd" placeholder="Your Password" required>
					</p>
					<?php echo $account -> getError(Constants::$loginFailed); ?>
					<button type="submit" name="loginButton">LOG IN</button>

					<div class="hasAccountText">
						<span>Don't have an account yet? <a id="hideLogin" href="#">Signup here!</a></span>
					</div>
					
				</form>


				<form id="registerForm" action="register.php" method="POST">
					<h2>Create Your Free Account</h2>
					<p>
						<label for="username">Username: </label>
						<input id="username" type="text" name="username" placeholder="Your Username" value="<?php getInputValue('username') ?>" required>
						<?php echo $account -> getError(Constants::$usernameInvalid); ?>
						<?php echo $account -> getError(Constants::$usernameUsed); ?>

					</p>

					<p>
						<label for="firstName">First Name: </label>
						<input id="firstName" type="text" name="firstName" placeholder="First Name" value="<?php getInputValue('firstName') ?>" required>
						<?php echo $account -> getError(Constants::$firstNameInvalid); ?>
					</p>

					<p>
						<label for="lastName">Last Name: </label>
						<input id="lastName" type="text" name="lastName" placeholder="Last Name" value="<?php getInputValue('lastName') ?>" required>
						<?php echo $account -> getError(Constants::$lastNameInvalid); ?>
					</p>

					<p>
						<label for="email">Email: </label>
						<input id="email" type="email" name="email" placeholder="e.g. username@email.com" value="<?php getInputValue('email') ?>" required>
						<?php echo $account -> getError(Constants::$emailInvalid); ?>
						<?php echo $account -> getError(Constants::$emailUsed); ?>
					</p>

					<p>
						<label for="emailConfirm">Confirm Email: </label>
						<input id="emailConfirm" type="email" name="emailConfirm" placeholder="e.g. username@email.com" required>
						<?php echo $account -> getError(Constants::$emailsNotMatch); ?>
					</p>

					<p>
						<label for="pwd">Password: </label>
						<input id="pwd" type="password" name="pwd" placeholder="Your Password" required>
						<?php echo $account -> getError(Constants::$pwInvalid); ?>
						<?php echo $account -> getError(Constants::$pwTooShort); ?>
					</p>


					<p>
						<label for="confirmPwd">Confirm Password: </label>
						<input id="confirmPwd" type="password" name="confirmPwd" placeholder="Confirm Your Password" required>
						<?php echo $account -> getError(Constants::$pwsNotMatch); ?>
					</p>
					
					<button type="submit" name="registerButton">SIGN UP</button>

					<div class="hasAccountText">
						<span>Already have an account? <a id="hideRegister" href="#">Login here!</a></span>
					</div>
					
				</form>
			</div>

			<div id="loginText">
				<h1>Get Great Music, Right Now</h1>
				<h2>Listen to loads of songs for free.</h2>
				<ul>
					<li>Discover music you'll fall in love with</li>
					<li>Create your own playlists</li>
					<li>Follow artists to keep up to date</li>
				</ul>
			</div>
		</div>
	</div>
</body>
<footer>
	<p id="creators">Peng-Yuan "Emily" Huang & Li-Kai "Ander" Lin ⓒ 2020</p>
	<p id="rights">All rights reserved.</p>
	<p class="credit">Credit:</p>
	<p class="credit">All icons used in this website were downloaded from <a href="https://icons8.com/">Icons8</a>.</p>
	<p class="credit">All demo music used in this website was downloaded from <a href="https://www.bensound.com/">Bensound</a>.</p>
</footer>
</html>