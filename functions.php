<?php
require "config.php";

function connect_db() {
    global $host, $username, $password, $dbname;

    $conn = mysqli_connect($host, $username, $password, $dbname);

    if (!$conn) {
        return false;
    }

    return $conn;
}

function attempt_login($email, $password) {

    $conn = connect_db();

    if(!$conn) {
        return false;
    }

    $sql = "SELECT id, name, email FROM users WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) == 1) {
        while ($row = mysqli_fetch_assoc($result)) {
            $_SESSION['user']['id'] = $row['id'];
            $_SESSION['user']['name'] = $row['name'];
            $_SESSION['user']['email'] = $row['email'];

            header('location: jokes.php');
        }
        return true;
    }
    return false;
}

function get_joke() {
    // create curl resource 
    $ch = curl_init(); 

    // set url 
    curl_setopt($ch, CURLOPT_URL, "https://08ad1pao69.execute-api.us-east-1.amazonaws.com/dev/random_joke"); 

    //return the transfer as a string 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

    // $output contains the output string 
    $output = curl_exec($ch);

    $joke = json_decode($output, true);

    $_SESSION['current_joke'] = $joke;

    joke_exists($joke);
    
    // close curl resource to free up system resources 
    curl_close($ch); 

    return $joke;
}

function joke_exists($joke) { 
    $conn = connect_db();

    if(!$conn) {
        return false;
    }

    $joke_id = $joke['id'];

    $sql = "SELECT id FROM jokes WHERE id = '$joke_id'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) < 1) {
        add_joke($joke);
    }
    
    return true;
}

function add_joke($joke) {
    $conn = connect_db();

    if(!$conn) {
        return false;
    }

    $id = $joke['id'];
    $setup = $joke['setup'];
    $punchline = $joke['punchline'];

    $sql = "INSERT INTO jokes(id, setup, punchline) VALUES (\"$id\", \"$setup\", \"$punchline\")";

    return mysqli_query($conn, $sql);
}

function add_rating($rating) {

    $conn = connect_db();

    if(!$conn) {
        return false;
    }

    $current_joke_id = $_SESSION['current_joke']['id'];
    $current_user_id = $_SESSION['user']['id'];

    $sql = "INSERT INTO reviews(user_id, joke_id, rating) VALUES (\"$current_user_id\", \"$current_joke_id\", \"$rating\")";

    if(mysqli_query($conn, $sql)) {
        return true;
    } 

    // var_dump(mysqli_error($conn));

}