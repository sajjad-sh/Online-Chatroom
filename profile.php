<?php
    require_once "libs/functions.php";

    $username = '';
    $name = '';
    $password = '';

    if(isset($_SESSION['username']))
        $username = $_SESSION['username'];

    if(isset($_POST['delete'])) {
        $users = readFromFile("files/users.txt");
        if ($username && !empty($users)) {
            for ($i = 0; $i < count($users); $i++) {
                if (($username == $users[$i]['username'])) {
                    unset($users[$i]);
                    $users = array_values($users);
                    session_unset();
                    writeAndDelete($users, "files/users.txt");

                    $host = $_SERVER['HTTP_HOST'];

                    header("Location: http://$host/modules/login.php");
                    exit;
                    break;
                }
            }
        }
    }

    else {

        if (isset($_POST['name']))
            $name = $_POST['name'];

        if (isset($_POST['password']))
            $password = md5($_POST['password']);

        $users = readFromFile("files/users.txt");
        if ($username && !empty($users)) {
            if($name) {
                for ($i = 0; $i < count($users); $i++) {
                    if (($username == $users[$i]['username'])) {
                        $users[$i]['name'] = $name;
                        break;
                    }
                }
            }
            
            if($password) {
                for ($i = 0; $i < count($users); $i++) {
                    if (($username == $users[$i]['username'])) {
                        $users[$i]['password'] = $password;
                        break;
                    }
                }
            }
        }

        writeAndDelete($users, "files/users.txt");

    }



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="https://www.bootdey.com/cache-css/cache-1622257314-7d15aeec98ffe3b293bae970f481103b.css">
    <title>Profile</title>
</head>
<body>
<div class="container">
<div class="row gutters">
<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
<div class="card h-100">
	<div class="card-body">
		<div class="account-settings">
			<div class="user-profile">
				<div class="user-avatar">
					<img src="img/user-profile.png" alt="Maxwell Admin">
				</div>
				<h5 class="user-name">
                    <?php
                        if(isset($_SESSION["username"]))
                            echo $_SESSION["username"];
                        else
                            echo "Deleted Account";
                    ?>
                </h5>
				<h6 class="user-email">
                <?php
                    if(isset($_SESSION["email"]))
                        echo $_SESSION["email"];
                    else
                        echo "";
                ?>
                </h6>
			</div>
			
		</div>
	</div>
</div>
</div>
<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
<div class="card h-75">

    <form action="" method="post">
        <div class="card-body">
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <h6 class="mb-2 text-primary">Personal Details</h6>
                </div>


                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter New name">
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="password">password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter New Password">
                    </div>
                </div>
                
            </div>
            <div class="row gutters">
                
            </div>
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="text-right">
                        <button type="submit" id="submit" name="submit" class="btn btn-primary">Update</button> | 
                        <button type="submit" id="delete" name="delete" class="btn btn-danger">Delete Account</button>
                    </div>
                </div>
            </div>
        </div>
    </form>


</div>
</div>
</div>
</div>
</body>
</html>