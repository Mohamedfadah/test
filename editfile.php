<?php

session_start();
    if(!isset($_SESSION["id"])){
        header("Location: login.php");
        exit();
    }

$error = array();
$keys = array("fname","lname","address","country","gender","username","password","confirm","verify","department");
$data = array();

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST")
{

    foreach($keys as $key)
    {
        if(isset($_POST[$key]))
        { 
            $data[$key] = test_input($_POST[$key]);
            if(empty($data[$key]))
            {
                $error[$key] = "This field is required";
            }
        }
    }

    if($data['verify'] != $data['confirm'])
        $error['verify'] = "Caption does not match";

    unset($data['verify']);
    unset($data['confirm']);
    if(isset($_POST['skills']))
        $data["skills"] = $_POST['skills'];


    if(isset($_POST['key']))
        $key1 = $_POST['key'];

    if(count($error)>0){
        $err = json_encode($error);
        $data = json_encode($data);
        header("Location:index.php?error={$err}&data={$data}&key=$key1");
        exit();
    }
    
    if(count($data["skills"]) > 0)
        $data["skills"] = implode(',', $data["skills"]);

    if($_FILES['f1']['name']){
        move_uploaded_file($_FILES['f1']['tmp_name'], "image/".$_FILES['f1']['name']);
        $img = "image/".$_FILES['f1']['name'];
    }
    
    // Create User
    try {
         // get data
        if(isset($_POST['key']))
            $key1 = $_POST['key'];

        if($key1 !== -1){
            require "pdo/crud.php";


            $res = isset($img)? update_user($key1, $data, $img): update_user($key1, $data);
            if(!$res){
                echo "Error";
                exit();
            }
        }

        header("Location:showusers.php");
        exit();
    } catch (Exception $ex) {
        var_dump($ex);
    }
}
?>
