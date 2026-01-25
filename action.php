<?php

if (isset($_POST['email'], $_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * clien where email = `$email` AND password  = `$password`";
    mysqli_query($sql,$conn);


} else {
    echo "Email or password not received";
}

?>