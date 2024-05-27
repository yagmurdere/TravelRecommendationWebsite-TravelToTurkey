<?php

include 'components/connect.php';


if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = $_POST['pass'];
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $verify_email = $conn->prepare("SELECT * FROM `users` WHERE email = ? LIMIT 1");
   $verify_email->execute([$email]);
   

   if($verify_email->rowCount() > 0){
      $fetch = $verify_email->fetch(PDO::FETCH_ASSOC);
      $verfiy_pass = password_verify($pass, $fetch['password']);
      if($verfiy_pass == 1){
         setcookie('user_id', $fetch['id'], time() + 60*60*24*30, '/');
         header('location:main.php');
      }else{
         $warning_msg[] = 'Incorrect password!';
      }
   }else{
      $warning_msg[] = 'Incorrect email!';
   }
   
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>TravettoTurkey!</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/header.php'; ?>
<!-- header section ends -->

<!-- login section starts  -->

<section class="account-form">

   <form action="" method="post" enctype="multipart/form-data">
      <h3>Welcome Back!</h3>
      <p class="placeholder">Your Email <span>*</span></p>
      <input type="email" name="email" required maxlength="50" placeholder="enter your email" class="box">
      <p class="placeholder">Your Password <span>*</span></p>
      <input type="password" name="pass" required maxlength="50" placeholder="enter your password" class="box">
      <p class="link">Don't have an account? <a href="register.php">Register now</a></p>
      <input type="submit" value="login now" name="submit" class="btn">
   </form>

</section>

<!-- login section ends -->



<!-- sweetalert cdn link  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php include 'components/alers.php'; ?>

</body>
</html>