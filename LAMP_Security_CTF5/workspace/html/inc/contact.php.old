<?php 

if (isset($name)) {
	$headers = "From: $email";
	mail("andy@localhost", "Contact Form Submission", $comments, $headers);
	echo "<h2>Thank you</h2>";
	echo "<p>Your comments have been sent to our staff.";
}
else {
?>

<p>Please use the form below to contact our staff:</p>
<form method="post" action="?page=contact">
Your name:  <input type="text" name="name"/><br/>
Your email: <input type="text" name="email"/><br/>
Comments:<br/>
<textarea name="comments"></textarea><br/>
<input type="submit" value="Send comments."/>
</form>
<?php 
}
?>