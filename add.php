<?php

require_once('connection.php');

if (isset($_REQUEST['btn_insert'])) {
    $firstname = $_REQUEST['txt_firstname'];
    $lastname = $_REQUEST['txt_lastname'];
    $phonenumber = $_REQUEST['txt_phonenumber'];

    if (empty($firstname)) {
        $errorMsg = "Please Enter Firstname";
    } elseif (empty($lastname)) {
        $errorMsg = "Please Enter Lastname";
    } elseif (empty($phonenumber)) {
        $errorMsg = "Please Enter PhoneNumber";
    } else {
        try {
            if (!isset($errorMsg)) {
                $insert_stmt = $db->prepare("INSERT INTO tbl_person(firstname,lastname,phonenumber) VALUES (:fname, :lname, :phone)");
                $insert_stmt->bindParam(':fname', $firstname);
                $insert_stmt->bindParam(':lname', $lastname);
                $insert_stmt->bindParam(':phone', $phonenumber);

                if ($insert_stmt->execute()) {
                    $insertMsg = "Insert Successfully...";
                    header("refresh:2;index.php");
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="bootstrap/bootstrap.css">
</head>

<body>

    <div class="container">
    <div class="display-3 text-center">Add</div>

    <?php
        if(isset($errorMsg)) {

    ?>
        <div class="alert alert-danger">
            <strong>wrong!<?php echo $errorMsg ?></strong>
        </div>
    <?php } ?>

    <?php
        if(isset($insertMsg)) {

    ?>
        <div class="alert alert-success">
            <strong>Success<?php echo $insertMsg ?></strong>
        </div>
    <?php } ?>

    <form method="post" class="form-horizontal text-center">
            <div class="form-group">
                <div class="row">
                    <label for="firstname" class="col-sm-3 control-label">Firstname</label>
                    <div class="col-sm-9">
                        <input type="text" name="txt_firstname" class="form-control" placeholder="Enter Firstname..." required>
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="lastname" class="col-sm-3 control-label">Lastname</label>
                    <div class="col-sm-9">
                        <input type="text" name="txt_lastname" class="form-control" placeholder="Enter Lastname..." required>
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="phone" class="col-sm-3 control-label">PhoneNumber</label>
                    <div class="col-sm-9">
                        <input type="text" name="txt_phonenumber" class="form-control" placeholder="Enter PhoneNumber..." required>
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="col-sm-offset-3 col-md-12 mt-3">
                    <input type="submit" name="btn_insert" class="btn btn-success" value="Insert">
                    <a href="index.php" class="btn btn-danger">Cancel</a>
                </div>
            </div>
        </form>
</div>

</body>
</html>
