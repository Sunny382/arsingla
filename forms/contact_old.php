<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
  // Replace contact@example.com with your real receiving email address
  $receiving_email_address = 'computerprogrammer@iift.ac.in';

  if( file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php' )) {
    include( $php_email_form );
  } else {
    die( 'Unable to load the "PHP Email Form" Library!');
  }

  $contact = new PHP_Email_Form;
  $contact->ajax = true;
  
  $contact->to = $receiving_email_address;
  // $contact->from_name = $_POST['name'];
  // $contact->from_email = $_POST['email'];
  // $contact->subject = $_POST['subject'];
  $contact->from_name = $_POST['name'] ?? 'Unknown';
  $contact->from_email = $_POST['email'] ?? 'no-reply@example.com';
  $contact->subject = $_POST['subject'] ?? 'Contact Form Message';

  // Uncomment below code if you want to use SMTP to send emails. You need to enter your correct SMTP credentials
  
  $contact->smtp = array(
    'host' => 'smtp.example.com',  // Replace with your SMTP server
    'username' => 'your-smtp-username',
    'password' => 'your-smtp-password',
    'port' => 587
  );
  

  $contact->add_message( $_POST['name'], 'From');
  $contact->add_message( $_POST['email'], 'Email');
  $contact->add_message( $_POST['message'], 'Message', 10);

  // Send email
  echo $contact->send();
?>