<?php
// Required Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if($_POST) {
    $receipient = "contact@yeomhyeon.com";
    $subject = "Email from my portfolio website!";
    $visitor_name = "";
    $visitor_email = "";
    $message = "";
    $fail = array();

    // Cleans and stores first name in the #$visitor_name variable.
    if(isset($_POST['firstname']) && !empty($_POST['firstname'])) {
        $visitor_name .= filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
    }else{
        array_push($fail, "firstname");
    }

    // Cleans and appends last name in the #$visitor_name variable.
    if(isset($_POST['lastname']) && !empty($_POST['lastname'])) {
        $visitor_name .= " ".filter_var($_POST['lastname'], FILTER_SANITIZE_STRING);
    }else{
        array_push($fail, "lastname");
    }

    // Cleans and stores email in the #$visitor_name variable.
    if(isset($_POST['email']) && !empty($_POST['email'])) {
        $visitor_email = str_replace(array("\r", "\n", "%0p", "%0a", "%0d"), "", $_POST['email']);
        $visitor_email = filter_var($visitor_email, FILTER_VALIDATE_EMAIL);
        //  \r = return
        //  \n = end
        //  "\r\n" = line break
    }else {
        array_push($fail, "email");
    }

    // Cleans messages and stores email in $message variable.
    if(isset($_POST['message']) && !empty($_POST['message'])) {
        $clean = filter_var($_POST['message'], FILTER_SANITIZE_STRING);
        $message = htmlspecialchars($clean);
    }else {
        array_push($fail, "message");
    }

    // $headers = "From: contact@yeomhyeon.com"."\r\n"."Reply-to: ".$visitor_email."\r\n"."X-MAIL: PHP/".phpversion();
    $headers = "FROM: ".$visitor_name."\r\n"."Reply-to: ".$visitor_email."\r\n"."X-mailer: PHP/".phpversion();
    // $headers = "FROM: "."\r\n"."Reply-to: ".$visitor_email."\r\n"."X-mailer: PHP/".phpversion();

    // "X-mailer: PHP/".phpversion();

    if(count($fail) == 0) {
        $subject = $subject." From ".$visitor_name;

        mail($visitor_email, $subject, $message);
        // $headers - debugger
        $results['message'] = sprintf("Thank you for contacting us, ".$visitor_name.". We will respond you within 24hours.");
    }else {
        header("HTTP/1.1 488 YOU DID NOT fill out the form correctly.");
        // 488 - random number, indicates it's an error
        die(json_encode(["message" => "Please make sure to fill up all the blanks!"]));
        // After die(), nothing is going to be shown.
    }

}else {
    $results['message'] = "Please make sure to fill up all the blanks!";
}

echo json_encode($results);

?>