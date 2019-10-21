<?php
$username = $_POST['uname'];
$email = $_POST['email'];
$password = $_POST['psw'];
if (!empty($username) && !empty($password) && !empty($email)) {
    //create connection
   $conn = pg_connect("user=lmsqkmundzqifb password=cc2fd9660da945c0f209f73ed904ee8489bb40a3c4263fe208150a5503e1c06e host=ec2-54-83-55-125.compute-1.amazonaws.com port=5432 dbname=dcvde64g04sofe");
   if(!$conn) {
      echo "Not connected.";
   } else {
   
	/*$sql1 = "SELECT user_name, email FROM authentification WHERE user_name = '$username' OR email = '$email' ";
	$res1 = pg_query($conn, $sql1) or die ("Fehler beim Ausführen der Abfrage");
	$unique = pg_fetch_row($res1);
   
	if ($unique[0] !== false || $unique[1] !== false) {
		header('location: register.html');
		echo 'E-Mail or Username existing!';
	} else { */
		// Username oder E-Mail noch nicht vorhanden
		$hashed = password_hash($password, PASSWORD_DEFAULT);
		$sql = "INSERT INTO authentification (user_name, pwd, email) VALUES ( '$username' , '$hashed' , '$email ' )";
		$res = pg_query($conn, $sql) or die ("Fehler beim Ausführen der Abfrage");
		header('location: login.html');
		exit(1);
	//}
   }
   
} else {
   header('location: register.html');
   echo "All fields are required.";
}
?>

