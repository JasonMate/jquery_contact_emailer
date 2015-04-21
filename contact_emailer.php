<?php 
# ******************************************************************
# Title: jquery Contact Emailer
# Author: Jason Mate
# Contact: (jmate421@gmail.com)
# *******************************************************************

$errors = "";

// reciever's email address goes here in quotes
$email_reciever = "yourname@email.com";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
  // if botstomper (lname) is empty, check data
  if(empty($_POST['lname'])) {
    
    // if form fields are empty set errors
    if(empty($_POST['name'])  || 
       empty($_POST['email']) || 
       empty($_POST['message'])) {
       $errors = "<h4 class='error'>Error: all fields are required</h4>";
       echo $errors;
    }
    
    // clean data
    $name = htmlspecialchars(trim($_POST['name']));
    $name = str_replace(array("\r","\n"),array(" "," "),$name);
    $email_address = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL); 
    $email_message = htmlspecialchars(trim($_POST["message"])); 
    
    // validate email address
    if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i", $email_address)) {
      $errors = "<h4 class='error'>Error: invalid email address</h4>";
      echo $errors;
    }
               
  } else { die(); }
 
  // if no errors send email
  if(empty($errors)) {
      
    $to = $email_reciever;
    $email_subject = "Contact form submission from: $name";
    $email_body = "You have received a new message. \n"." Here are the details:\n Name: $name \n Email: $email_address \n Message: \n $email_message";    
    $headers = "From: $name\n"; 
    $headers .= "Reply-To: $email_address";
    
    mail($to,$email_subject,$email_body,$headers);
    echo "<h4 class='success'>Thank you for contacting me. I will be in touch soon.</h4>";
  }
  
}

else {
    // not a post request, set to a 403
    http_response_code(403);
    $errors = "<h4 class='error'>Error: There was a problem with your submission, please try again.</h4>";
    echo $errors;
}
?>