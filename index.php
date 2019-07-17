<?php
if (isset($_POST['submit'])) {
	$word = stripslashes($_POST["word"]);
	$response = $_POST["g-recaptcha-response"];
	$url = 'https://www.google.com/recaptcha/api/siteverify';
	$data = array(
		'secret' => 'YOUR_SECRET_KEY',
		'response' => $_POST["g-recaptcha-response"]
	);
	$options = array(
		'http' => array (
			'method' => 'POST',
			'content' => http_build_query($data),
			'header' => 'Content-Type: application/x-www-form-urlencoded'
		)
	);
	$context  = stream_context_create($options);
	$verify = file_get_contents($url, false, $context);
	$captcha_success=json_decode($verify);
	if ($captcha_success->success==false) {
		echo "<p>False</p>";
	} else if ($captcha_success->success==true) {
		echo "<p>True</p>";
	}
}
?>
<HTML>
<head>
	<title>recaptcha</title>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<!--
		if you want to use validateRecaptcha:
	-->
	<!--script>
	function validateRecaptcha() {
		var response = grecaptcha.getResponse();
		if (response.length === 0) {
			echo("Captcha belum diisi!");
			return false;
		} else {
			alert("validated");
			return true;
		}
	}
	</script-->
	<script>
    function enableBtn(){
        document.getElementById("btn_confirmation").disabled = false;
    }
	</script>
</head>
<body>
	<!--
		if you want to use validateRecaptcha, add this in form tag:
		onsubmit="return validateRecaptcha();"
	-->
	<form action="" method="post" enctype="multipart/form-data">
		<input name="word" placeholder="Add some word..." autocomplete="off" required>
			<div class="captcha_wrapper">
			<div class="g-recaptcha" data-sitekey="YOUR_SITE_KEY" data-callback="enableBtn"></div>
		</div>
		<button type="submit" name="submit" id="btn_confirmation" disabled>Submit</button>
	</form>
</body>
</HTML>