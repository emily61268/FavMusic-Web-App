<?php 

	class Constants{

		public static $loginFailed = "Your username or password was incorrect.";

		public static $usernameInvalid = "Your username must be between 5 and 25 characters.";
		public static $usernameUsed = "This username already exists.";

		public static $firstNameInvalid = "Your first name must be between 2 and 25 characters.";
		public static $lastNameInvalid = "Your last name must be between 2 and 25 characters.";

		public static $emailsNotMatch = "Your emails don't match.";
		public static $emailInvalid = "Email is invalid. Please follow the format: username@email.com";
		public static $emailUsed = "This email address is already in use.";


		public static $pwsNotMatch = "Your passwords don't match.";
		public static $pwInvalid = "Your password must contain at least ONE uppercase, ONE lowercase, ONE number, and ONE of the special characters (!@#$%^&+=?><~).";
		public static $pwTooShort = "Your password must be at least 8 characters.";

	}
 ?>