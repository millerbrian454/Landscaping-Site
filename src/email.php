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
            $email_from = 'eyc@eyc-landscaping.com';//<== update the email address
            $to = "brian.miller676@yahoo.com";//<== update the email address
            $email_subject = "New Form submission";
            // Message lines should not exceed 70 characters (PHP rule), so wrap it
            $message = wordwrap($message, 70, "\r\n");
            $email_body = "You have received a new message from the user $name.\n".
                "Here is the message:\n $message \n".

            $headers = "From: $email_from \r\n";
            $headers .= "Reply-To: $visitor_email \r\n";



            // Sender's Email

            // Send Mail By PHP Mail Function
            if (mail($to,$email_subject,$email_body,$headers)) {
              //done. redirect to thank-you page.
              header("https://eyc-landscaping.com/index.html");
            } else {
                echo "Failed to send email, try again.";
                exit ;
            }
        }
    }
}
?>
