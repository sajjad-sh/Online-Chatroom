<?php require_once "../libs/functions.php"; ?>

<?php    
    $submit = '';

    if(isset($_POST['submit']))
        $submit = $_POST['submit'];

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="https://getbootstrap.com/docs/4.0/assets/img/favicons/favicon.ico">

    <title>Signin Template for Bootstrap</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/sign-in/">

    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="https://getbootstrap.com/docs/4.0/examples/sign-in/signin.css" rel="stylesheet">
  </head>

  <body class="text-center">
    <form class="form-signin" method="post">
      <img class="mb-4" src="https://d338t8kmirgyke.cloudfront.net/icons/icon_pngs/000/007/568/original/chat-bubble.png" alt="" width="150" height="150">
      <h1 class="h3 mb-3 font-weight-normal">Please sign up</h1>
      
      <label for="name" class="sr-only">Name</label>
      <input type="text" name="name" id="name" class="form-control" placeholder="Name" required autofocus>
      
      <label for="username" class="sr-only">Username</label>
      <input type="text" name="username" id="username" class="form-control" placeholder="Username" required autofocus>
      
      <label for="email" class="sr-only">Email address</label>
      <input type="text" name="email" id="email" class="form-control" placeholder="Email" required autofocus>
      
      <label for="password" class="sr-only">Password</label>
      <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
      
      <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me"> Remember me
        </label>
      </div>
      <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit" id="submit" value="submit">Sign up</button>
      <br>
      <span><a href="login.php">I have an account.</a></span>
      <p class="mt-3 mb-3 text-muted">&copy; 2020-2021</p>
    </form>
    <?php 
        if($submit == "submit")      
            register();
    ?>
  </body>
</html>