<?php
$errors = '';
$myemail = 'support@nikkem.com';

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$company = $_POST['company'];
$email_address = $_POST['email'];
$message = $_POST['message'];
$name = $fname . $lname;

// Nimitarkistus
if (empty($fname && $lname))
{
	$errors .= "<br /> Virheellinen nimi | Incorrect name";
}

// Sähköpostin oikein muotoilu tarkistus
if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i", $email_address))
{
    $errors .= "<br /> Virheellinen sähköpostiosoite | Incorrect email";
}

// Viestitarkistus
if (empty($message))
{
	$errors .= "<br /> Tyhjä viesti | Empty message";
}

if( empty($errors))
{
	$to = $myemail;
	$email_subject = "Yhteydenottopyyntö henkilöltä: $name";
	$email_body =
	" Henkilötiedot\n Nimi: $name \n ".
	"Sähköpostiosoite: $email_address\n Viesti: \n $message";
	$headers = "From: $myemail\n";
	$headers .= "Reply-To: $email_address";
	mail($to,$email_subject,$email_body,$headers);

	$msgstatus = "onnistui!<br/>";

	//redirect to the 'thank you' page
	$thxtext = "Kiitos viestistä! <br/> Vastaan syöttämääsi sähköpostiin niin pian kuin mahdollista.";
	$yhteenveto = "<br/><br/><b>Yhteenveto viestistä:</b> <br/> Nimi: " . $fname . " " . $lname . "<br/> Sähköpostiosoite: " . $email_address . "<br/> Yritys: " . $company . " <br/> Viesti: " . $message;

} else {
	$msgstatus = "epäonnistui<br/>";
}
?>

<!DOCTYPE html>
<html>
<head>

	<title>Nikke Marttila - Yhteydenotto</title>

	<!-- Custom CSS -->
	<link rel="stylesheet" type="text/css" href="src/styles.css">
	<!-- MaterializeCSS -->
	<link type="text/css" rel="stylesheet" href="src/materialize.min.css"  media="screen,projection"/>
	<!-- Optimized for mobile -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Anton|Montserrat" rel="stylesheet">
	<!-- UTF-8 METATAG -->
	<meta charset="utf-8">

</head>
<body style="background-color: #202020; color: white;">

<div class="container">
	<div class="row center-align">
		<div class="col s12 m12 l12">
			<h1 style="font-size: 32px">Viestin lähetys <?php echo $msgstatus; ?></h1>
		</div>

		<div class="col s12 m12 l12">
			<p>

			<?php if (empty($errors)) {
				echo $thxtext;
				echo $yhteenveto;
			} else {
				echo $errors;
			} ?>

			<br /> <br /> <a href="javascript:history.back()">Palaa etusivulle</a>

			</p>
		</div>
	</div>
</div>

</body>
</html>
