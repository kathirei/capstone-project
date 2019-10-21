<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Katharina Reiter"> 
    <meta name="Description" content="Hier finden Sie unsere secPatt-Patterns." /> 
    <link href="stylesheets/screen.css" rel="stylesheet" media="screen, projection">
  
    <title>Messaging System</title>
  </head>
  <body>
  
  <header>
     <a id="logo" tabindex="-1" href="./">Messages<span>Coursera</span></a>
  </header>

  <nav>
  	<ul>
		<li><a href="login.html">Log out</a></li>
  	</ul>
  </nav>

 <main id="main"><!-- Hier beginnt der Inhaltsbereich -->

<?php
$username = $_POST['uname'];
$password = $_POST['psw'];
if (!empty($username) && !empty($password)) {
    //create connection
   $conn = pg_connect("user=lmsqkmundzqifb password=cc2fd9660da945c0f209f73ed904ee8489bb40a3c4263fe208150a5503e1c06e host=ec2-54-83-55-125.compute-1.amazonaws.com port=5432 dbname=dcvde64g04sofe");
   if(!$conn) {
      echo "Not connected.";
   } else {

	$sql = "SELECT user_name, pwd FROM authentification WHERE user_name = '$username' "; 
	$res = pg_query($conn, $sql) or die ("Fehler beim Ausführen der Abfrage");
	$user = pg_fetch_row($res); 
	if ($user[0] !== false && password_verify($password, $user[1])) {
		$login = "erfolgreich";
	} else {
		$errorMessage = "Username or Password false";
		header('location: login.html');
		exit(1);
        }
   }
} else {
 echo "All field are required";
  header('location: login.html');
  exit(1);
}
?>

<h1> Messages: </h1>

<?php
if ($login == "erfolgreich") {
	$sql2 = "SELECT message, sender FROM messages WHERE receiver = '$username' ";
	$res2 = pg_query($conn, $sql2) or die ("Fehler beim Ausführen der Abfrage");
	$cols = pg_num_fields($res2);
        $rows = pg_num_rows($res2);
	for ($i=0; $i<$rows; $i++) {
		$zeile  = pg_fetch_row($res2, $i);
		echo 'Message from '.$zeile[1].' : ';
		echo $zeile[0].'<hr>';
	}
}
?>

<?php
if(isset($_POST['send_message'])) {
	$receiver = $_POST['receiver'];
	$message = $_POST['message'];
	$sql3 = "INSERT INTO messages VALUES ('$username', '$receiver', '$message' ) "; 
	$res3 = pg_query($conn, $sql3) or die ("Fehler beim Ausführen der Abfrage");
	echo 'Message sent.';
}
?>

<!-- Send new message -->
<button onclick="document.getElementById('id03').style.display='block'" style="width:auto;">Send new message.</button>

<div id="id03" class="modal">
 <form class="modal-content animate" action="" method="post">
    <div class="container">
      <label for="receiver"><b>Receiver</b></label>
      <input type="text" placeholder="Enter Receiver of the message" name="receiver" required>
      
      <label for="message"><b>Message</b></label>
      <input type="text" placeholder="Enter Message" name="message" required>

      <button type="submit" name="send_message">Send message</button>
    </div>

    <div class="container" >
      <button type="button" onclick="document.getElementById('id03').style.display='none'" class="cancelbtn">Cancel</button>
    </div>
  </form>
</div>

 </main>

 </body>
</html>


