<?php
    session_start();
    require("../functions.php");
    $_SESSION['CUR_PAGE'] = 'changepass';

    $sucessAlert = false;
    if(isset($_POST['btnChangePass'])){
        $con = openConnection();
        
        $username = sanitizeInputs($con, $_POST['txtUsername']);
        $oldpassword = sanitizeInputs($con, $_POST['txtOldPassword']);
        $newpassword = sanitizeInputs($con, $_POST['txtNewPassword']);
        $confirmpassword = sanitizeInputs($con, $_POST['txtConfirmPassword']);
        $arrError = [];

        $oldpassword = md5($oldpassword);
        $newpassword = md5($newpassword);
        $confirmpassword = md5($confirmpassword);

        if(empty($username))
            $arrError[] = "Username is Required";
        
        if(empty($newpassword))
            $arrError[] = "Old Password is Required";

        if(empty($newpassword))
            $arrError[] = "New Password is Required";

        if(empty($confirmpassword))
            $arrError[] = "Confirm Password is Required";    

        if($newpassword != $confirmpassword)
            $arrError[] = "Your password is doesn't match";          

                // Next time tuloy mo yun arrError printing

        if(empty($arrError) && $newpassword == $confirmpassword){
            // Inserting Multiple Rows
            $strSQL = "
            
                UPDATE tbl_user SET 
                password = '$confirmpassword'
                WHERE username = '$username' AND password = '$oldpassword'
               
            ";
        
            if(mysqli_query($con, $strSQL))
                $sucessAlert = true;
            else
                $arrError[] = 'Error: Failed SQL';
        }
        closeConnections($con);
        
    }
?>
<?php require_once("header.php")?>
    <div class="container-fluid">
        <div class="row">
            <?php require_once("nav.php")?>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
            <?php
                    if(!empty($arrError)){
                        foreach ($arrError as $key => $value) {
                            echo 
                            '
                            
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error: </strong>
                                <ul>
                                    <li>' . $value . '</li>
                                </ul>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            
                            ';
                        }

                    }
                    if($sucessAlert === true){
                        echo 
                        '
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Change password successfully update
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    
                        ';
                    }
                
                
                ?>
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2"><i class="fa fa-users"></i> Change password</h1>
                </div>
                <form method="post">
                    <div class="form-row">
                        <div class="form-group col-12">
                            <label for="txtProductPrice"> Username <span class="text-danger">*</span></label>
                            <input type="text" name="txtUsername" class="form-control" id="txtProductPrice"required>
                        </div>
                        <div class="form-group col-12">
                            <label for="txtOldPassword">Old Password <span class="text-danger">*</span></label>
                            <input type="password" name="txtOldPassword" class="form-control" id="txtOldPassword" required autofocus>
                        </div>
                        <div class="form-group col-12">
                            <label for="txtNewPassword">New Password <span class="text-danger">*</span></label>
                            <input type="password" name="txtNewPassword" class="form-control" id="txtNewPassword" required autofocus>
                        </div>
                        <div class="form-group col-12">
                            <label for="txtConfirmPassword">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" name="txtConfirmPassword" class="form-control" id="txtConfirmPassword" required>
                        </div>
                    </div>
                    <button type="submit" name="btnChangePass" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModal"><i class="fa-solid fa-circle-check"></i> Confirm</button>
                </form>
            </main>
        </div>
    </div>
<?php require_once("footer.php")?>










?>