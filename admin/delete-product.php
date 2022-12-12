<?php
    require('../functions.php');
    if(isset($_POST['btnRemove'])){
        $con = openConnection();
        $strSQL = "
            DELETE FROM tbl_products
            WHERE id = " . $_GET['k'];
    
        if(mysqli_query($con, $strSQL))
            header("location: products.php");
        else
            $arrError[] = 'Error: Failed Delete SQL';
        closeConnections($con);
    }


    $con = openConnection();
    $strSQLSELECT = "SELECT * FROM tbl_products WHERE id = " . $_GET['k'];
    $recProduct = getRecord($con, $strSQLSELECT);
    
?>
<?php require_once("header.php")?>
    <div class="container-fluid">
        <div class="row">
            <?php require_once("nav.php")?>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2"><i class="fa fa-users"></i> Delete Product</h1>
                </div>
                <p>Do you want delete this record?</p>
                <p><b>Product Name: </b><?php echo $recProduct[0]['name']?></p>
                <p><b>Product Dexcription: </b><?php echo $recProduct[0]['description']?></p>
                <p><b>Product Price: </b><?php echo $recProduct[0]['price']?></p>
                <form action="" method="post">
                    <button type="submit" name="btnRemove" class="btn btn-dark"> Yes</button>
                    <a href="products.php" class="btn btn-dark"> No</a>
                </form>
            </main>
        </div>
    </div>
<?php require_once("footer.php")?>




