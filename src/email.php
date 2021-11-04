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
    if ($_POST["fullName"] == "" || $_POST["email"] == "" || $_POST["message"] == "" || $_POST["phone"] == "" || $_POST["service"] == "" || $_POST["zip-code"] == "") {
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
            $name = $_POST["fullName"];
            $message = $_POST['message'];
            $services = $_POST["service"];
            //$email = $_POST['email'];
            $zip = $_POST["zip-code"];
            $phoneNum = $_POST["phone"];
            $email_from = 'eyc@eyc-landscaping.com';//<== update the email address
            $to = "eyc.landscaping.contact@gmail.com";//<== update the email address
            $email_subject = "New Form submission";
            // Message lines should not exceed 70 characters (PHP rule), so wrap it
            $message = wordwrap($message, 70, "\r\n");
            $email_body = "You have received a new message from the customer $name. \n Their Email address is: $email \n Their phone number is : $phoneNum \n Their Zip code is: $zip \n The service they selected is : \n $services \n".
                "Here is the message:\n $message \n ".

            $headers = "From: $email_from \r\n";
            $headers .= "Reply-To: $email \r\n";

            // Send Mail By PHP Mail Function
            if (mail($to,$email_subject,$email_body,$headers)) {
              //done. redirect to thank-you page.
              header("Location: thankyou.html");
              die();
            } else {
              header("Location: tryAgain.html");
              die();
            }
        }
    }
}
?>
