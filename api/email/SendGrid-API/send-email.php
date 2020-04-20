<?php
/*SendGrid Library*/
require_once ('vendor/autoload.php');

/*Post Data*/
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];
$page = $_POST['page'];

/*Content*/
$from = new SendGrid\Email("Edulounge", "eduloungec@gmail.com
");
$subject = "Test";
$to = new SendGrid\Email("Gulzar", $email);
$content = new SendGrid\Content("text/html", $message);

/*Send the mail*/
$mail = new SendGrid\Mail($from, $subject, $to, $content);
$apiKey = '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';
$sg = new \SendGrid($apiKey);

/*Response*/
$response = $sg->client->mail()->send()->post($mail);
if ($page == 1) {
	header("location:")
}
?>

<!--Print the response-->
<pre>
    <?php
    // var_dump($response);
    ?>
</pre>
