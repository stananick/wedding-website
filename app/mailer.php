<?php

    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $name = strip_tags(trim($_POST["name"]));
				$name = str_replace(array("\r","\n"),array(" "," "),$name);

        $additionalname = strip_tags(trim($_POST["additionalname"]));
        $additionalname = str_replace(array("\r","\n"),array(" "," "),$additionalname);

        $phone = strip_tags(trim($_POST["phone"]));
				$phone = str_replace(array("\r","\n"),array(" "," "),$phone);

        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);

        $needshotel = $_POST["needshotel"];
        $attending = $_POST["attending"];
        $message = trim($_POST["message"]);

        // Check that data was sent to the mailer.
        if ( empty($name) OR !filter_var($email, FILTER_VALIDATE_EMAIL) OR empty($phone) ) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Oops! There was a problem with your submission. Please make sure all fields are filled out correctly.";
            exit;
        }

        // Set the recipient email address.
        $recipient = "lstanek4@gmail.com";

        // Set the email subject.
        $subject = "New RSVP from $name";

        // Build the email content.
        $email_content = "Guest: $name\n";
        $email_content .= "Additional Guest(s): $additionalname\n";
        $email_content .= "Attending: $attending\n";
        $email_content .= "Needs Hotel: $needshotel\n";
        $email_content .= "Email: $email\n\n";
        $email_content .= "Phone: $phone\n\n";
        $email_content .= "Message:\n$message\n";

        // Build the email headers.
        $email_headers = "From: $name <$email>";

        // Send the email.
        if (mail($recipient, $subject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "Thank You! Your RSVP has been sent.";
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Oops! Something went wrong and we couldn't send your message.";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "There was a problem with your submission, please try again.";
    }

?>
