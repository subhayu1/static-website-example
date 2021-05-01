<?php
// Uncomment next line if you're not using a dependency loader (such as Composer)
 require_once '<PATH TO>/sendgrid-php.php';

use SendGrid\Mail\Mail;

$email = new Mail();
$email->setFrom("subhayu.rimal@gmail.com", "support user");
$email->setSubject("I'm replacing the subject tag");
$email->addTo(
    $email_1,
    "Example" $User1,
    [
        "subject" => "Subject 1",
        "name" => $user1",
        "city" => "$city1"
    ],
    0
);
$email->addTo(
    "subhayu.rimal+test2@gmail,.com",
    "Example User2",
    [
        "subject" => "Subject 2",
        "name" => "Example User 2",
        "city" => "Denver"
    ],
    1
);
$email->addTo(
    "test+test3@example.com",
    "Example User3",
    [
        "subject" => "Subject 3",
        "name" => "Example User 3",
        "city" => "Redwood City"
    ],
    2
);
$email->setTemplateId("d-2321a42211464abcb2cca7481f44ab2a");
$sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
try {
    $response = $sendgrid->send($email);
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: '.  $e->getMessage(). "\n";
}