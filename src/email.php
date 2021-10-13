<?php
//Checking For reCAPTCHA
$captcha;
if (isset($_POST['g-recaptcha-response'])) {
    $captcha = $_POST['g-recaptcha-response'];
}
// Checking For correct reCAPTCHA
$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6Lf_msccAAAAALMUVXCbMeWAn_caH0qOV2K30Ibc&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
if (!$captcha || $response.success == false) {
    echo "Your CAPTCHA response was wrong.";
    exit ;
} else {
    // Checking For Blank Fields..
    if ($_POST["first_name"] == "" || $_POST["last_name"] == "" || $_POST["email"] == "" || $_POST["message"] == "" || $_POST["phone"] == "" || $_POST["service"] == "" || $_POST["zip-code"] == "") {
        echo "Fill All Fields..";
    } else {
        // Check if the "Sender's Email" input field is filled out
        $email = $_POST['email'];
        // Sanitize E-mail Address
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        // Validate E-mail Address
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        if (!$email) {
            echo "Invalid Sender's Email";
        } else {
            $to = 'eyc.landscaping.contact@gmail.com';
            $subject = 'Contact Form Test';
            $message = $_POST['message'];
            $headers = 'From:' . $email . "\r\n";
            // Sender's Email
            // Message lines should not exceed 70 characters (PHP rule), so wrap it
            $message = wordwrap($message, 70, "\r\n");
            // Send Mail By PHP Mail Function
            if (mail($to, $subject, $message, $headers)) {
                echo "Your mail has been sent successfully!";
            } else {
                echo "Failed to send email, try again.";
                exit ;
            }
        }
    }
}
?>
