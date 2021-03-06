

<?php 

    session_start();
    if(!isset($_SESSION["id"])){
        header("Location: login.php");
        exit();
    }

    require "pdo/crud.php";

    // Open the file
    $filename = 'user.txt';
    $file = fopen($filename, 'r'); 

    // Add each line to an array
    if ($file) 
        $array = explode("\n", fread($file, filesize($filename)));
        
?>

<!DOCTYPE html>
<html>
	<head>
		<title> Web Form </title>
		<style>
			.right
			{
				text-align: right;
				font-weight: 700;
			}
			.bottom
			{
				text-align: center;
				background-color: #ADD8E6;
			}
			table
			{
				border-collapse: collapse;
				margin: 20px auto;
			}
			td
			{
				border: 1px solid black;
				padding: 5px;
			}
			.error
			{
				color: red;
			}
		</style>
	</head>
	<body>
<button onclick="window.location.href='logout.php'">Logout</button>
    <table>
        <colgroup>
            <col style="width: 150px" />
        </colgroup>
        <thead>
            <tr>
                <th>Name</th>
                <th>UserName</th>
                <th>Address</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $users = get_all_users();
                if($users){
                    foreach ($users as $user) {
                        if(isset($_SESSION["id"]) && $_SESSION["id"] !== $user->id){
                        
                            echo "<tr>";
                            echo "<td>".$user->fname." ".$user->lname."</td>";
                            echo "<td>".$user->username."</td>";
                            echo "<td>".$user->address."</td>";
                            echo "<td> <a href='./viewuser.php?key=".$user->id."'>View</a> </td>";
                            echo "<td> <a href='./index.php?key=".$user->id."'>Edit</a> </td>";
                            echo "<td> <a href='./deleteuser.php?key=".$user->id."'>Delete</a> </td>";
                            echo "</tr>";
                        }
                    }
                }
            ?>
        </tbody>
    </table>
</body>
</html>