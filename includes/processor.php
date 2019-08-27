<?php
session_start();
require_once 'config.php';

if($_POST['function'] == "register"){
	
	//grabbing post values from the registration page
	$password = $_POST['password'];
	$email = $_POST['email'];
	
	//checking email is valid
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		header('Location: ../register.html?result=invalid');
	}
	
	//hashing the password with bcrypt
	$encrypted_password = password_hash($password, PASSWORD_BCRYPT);
	
	//checking to see if the account already exists
	$emailquery = mysqli_query($db, "SELECT * FROM accounts WHERE email='$email';");
	$num=mysqli_num_rows($emailquery);
	if($num == 0){
		
		//if no existing account is found then create it and rediect to login page
		mysqli_query($db, "INSERT INTO accounts (email, password) VALUES ('$email', '$encrypted_password')");
		header('Location: ../login.html?result=success');
	} else {
		
		//if existing account is found then redirect to registration page with duplicate error
		header('Location: ../register.html?result=duplicate');
	}
}

if($_POST['function'] == "login"){
	
	//grabbing post values from the login page
	$password = $_POST['password'];
	$email = $_POST['email'];
	
	//querying database for a matching account
	$accountquery = mysqli_query($db, "SELECT * FROM accounts WHERE email='$email';");
	$row=mysqli_fetch_array($accountquery);
	
	//if account is found then move to password check
	if(mysqli_num_rows($accountquery)>0){
		
		//check the entered password against the stored hashed password
		if(password_verify($password, $row['password'])){
			
			//set session vars and redirect to homepage
			$_SESSION['userid'] = $row['id'];
			$_SESSION['email'] = $row['email'];
			header('Location: ../index.html');
		} else {
			
			//return the user to the login page with a password error
			header('Location: ../login.html?result=password');
		}
		
	} else {
		
		//return the user to the login page with an email error
		header('Location: ../login.html?result=email');
	}
}

if($_POST['function'] == "logout"){
	
	//unset all session vars, destroy session & redirect to homepage
	unset($_SESSION['userid']);
	unset($_SESSION['email']);
	session_destroy();
	header('Location: ../index.html'); 

}

function generateid(){
	$chars = array(0,1,2,3,4,5,6,7,8,9,'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
	$max = count($chars)-1;
	$serial = '';
	for($i=0;$i<8;$i++){ $serial .= $chars[rand(0, $max)]; }
	return $serial;
}

?>