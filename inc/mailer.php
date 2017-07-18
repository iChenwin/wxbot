<?php
/**
 * Mailer Script
 *
 * @package TA Magazine
 */

define( 'WP_USE_THEMES', false );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php' );

// Only process POST reqeusts.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Get the form fields and remove whitespace.
	$name = strip_tags(trim($_POST["contactName"]));
			$name = str_replace(array("\r","\n"),array(" "," "),$name);
	$email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
	$message = trim($_POST["message"]);
	$topic = trim($_POST["whats-upRadios"]);

	// Check that data was sent to the mailer.
	if ( empty($name) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
		// Set a 400 (bad request) response code and exit.
		http_response_code(400);
		echo __('Oops! There was a problem with your submission. Please complete the form and try again.', 'ta-magazine');
		exit;
	}

	// Set the recipient email address.
	// FIXME: Update this to your desired email address.
	$recipient = ta_option('contact_email');

	// Set the email subject.
	$subject = "New [$topic] Message from $name";

	// Build the email content.
	$email_content = "Name: $name\n";
	$email_content .= "Email: $email\n\n";
	$email_content .= "Message:\n$message\n";

	// Build the email headers.
	$email_headers = "From: $name <$email>";

	// Send the email.
	if ( wp_mail($recipient, $subject, $email_content, $email_headers) ) {
		// Set a 200 (okay) response code.
		http_response_code(200);
		echo __('Thank You! Your message has been sent.', 'ta-magazine');
	} else {
		// Set a 500 (internal server error) response code.
		http_response_code(500);
		echo __("Oops! Something went wrong and we couldn't send your message.", 'ta-magazine');
	}

} else {
	// Not a POST request, set a 403 (forbidden) response code.
	http_response_code(403);
	echo __('There was a problem with your submission, please try again.', 'ta-magazine');
}

?>