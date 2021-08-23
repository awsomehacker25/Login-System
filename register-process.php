<?php

require ('helper.php');
$error = array();

$firstName = validate_input_text($_POST['firstName']);
if (empty($firstName)){
    $error[] = "You forgot to enter your first name";
}

$lastName = validate_input_text($_POST['LastName']);
if (empty($lastName)){
    $error[] = "You forgot to enter your last name";
}

$email = validate_input_email($_POST['email']);
if (empty($email)){
    $error[] = "You forgot to enter your email";
}

$password = validate_input_text($_POST['password']);
if (empty($password)){
    $error[] = "You forgot to enter your password";
}

$confirm_pwd = validate_input_text($_POST['confirm_pwd']);
if (empty($confirm_pwd)){
    $error[] = "You forgot to confirm your password";
}

$files = $_FILES['profileUpload'];
$profileImage = upload_profile('./assets/profile/', $files);

if(empty($error)){
    $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
    require('mysqli_connect.php');

    $query = "INSERT INTO user(userID, firstName, lastName, email, password, profileImage, registerDate )";
    $query .= "VALUES(' ', ?, ?, ?, ?, ?, NOW())";

    $q = mysqli_stmt_init($con);

    mysqli_stmt_prepare($q, $query);

    mysqli_stmt_bind_param($q, 'sssss', $firstName, $lastName, $email, $hashed_pass, $profileImage);

    mysqli_stmt_execute($q);

    if(mysqli_stmt_affected_rows($q) == 1){

        session_start();

        $_SESSION['userID'] = mysqli_insert_id($con);

        header('location: login.php');
        exit();
    }else{
        print "Error while registration...!";
    }

}else{
    echo 'not validate';
}


















