<?php
    session_start();
    require("functions.php");
   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap.css">
    <link rel="stylesheet" href="./css/login.css">
    <title>Log-In Form</title>
</head>
<?php
  $arrUserType = array("admin"=>"admin","rey marco"=>"admin","pepito"=>"content manager","juan"=>"content manager","pedro"=>"system user");
  $arrPassword = array("admin"=>"Pass1234","rey marco"=>"hi1234","pepito"=>"manaloto","juan"=>"delacruz","pedro"=>"penduko");

?>

<body id="LoginForm">
<div class="container">
    <!-- Here to show to alert box when you click submit -->
    <?php
 if(isset($_POST['btnLogin'])){
        $con = openConnection();
        $username = htmlspecialchars( $_POST['username']); // anti xss
        $password = htmlspecialchars( $_POST['password']);

        $username = stripslashes($username);    // removal of single quotes, slash specifically
        $password = stripslashes($password);

        $username = mysqli_real_escape_string($con, $username); //escaping any attempts for SQL Injection
        $password = mysqli_real_escape_string($con, $password);

        $password = md5($password); // hash the password

        $strSQL = "
                    SELECT * FROM tbl_user 
                    WHERE username = '$username' 
                    AND password = '$password'

        ";
        if($rsLogin = mysqli_query($con, $strSQL)){
            if(mysqli_num_rows($rsLogin) > 0){
                while($arrRec = mysqli_fetch_array($rsLogin)){
                    $_SESSION['username'] = $arrRec['username'];
                }
                if($_SESSION['username'] == "admin"){
                    header("location: admin/");
                }
                else{
                    header("location: user/");
                }
                mysqli_free_result($rsLogin);
            }
            else{
               echo 
               '
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Wrong Username/Password.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
               
               
               ';
            }
        }
        else
            echo 'ERROR: Could not execute your request';
        
            closeConnections($con);
    }

    ?>
<h1 class="form-heading">login Form</h1>
<div class="login-form">
<div class="main-div">
    <div class="panel">
   <h2>Admin Login</h2>
   </div>
    <form id="Login" method="post">
        <div class="form-group">


            <!-- change email type to text and placeholder and name="txtUsername"-->
            <input type="text" class="form-control" name="username" id="username" placeholder="Username">
        </div>

        <div class="form-group">

        <!-- change email type to text and placeholder and name="txtPassword"-->
        <input type="password" class="form-control" name="password" id="password" placeholder="Password">

            
        </div>
        <!--Put name="btnSubmit here" -->
        <button type="submit" class="btn btn-primary" name="btnLogin">Login</button>

    </form>
    </div>
</div></div></div>


     <script href="../js/jquery.js"></script>
     <script href="../js/bootstrap.js"></script> 

     <!-- dsfhjisdhfjsdfjs -->

</body>
</html>