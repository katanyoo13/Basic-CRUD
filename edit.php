<?php
require_once('connection.php');

if (isset($_REQUEST['update_id'])) {
    try {
        $id = $_REQUEST['update_id'];
        $select_stml = $db->prepare("SELECT * FROM tbl_person WHERE id = :id");
        $select_stml->bindParam(':id', $id);
        $select_stml->execute();
        $row = $select_stml->fetch(PDO::FETCH_ASSOC);
        extract($row);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

if (isset($_REQUEST['btn_update'])) {
    $firstname_up = $_REQUEST['txt_firstname'];
    $lastname_up = $_REQUEST['txt_lastname'];
    $phonenumber_up = $_REQUEST['txt_phonenumber'];

    if (empty($firstname_up)) {
        $errorMsg = "Please Enter Firstname";
    } elseif (empty($lastname_up)) {
        $errorMsg = "Please Enter Lastname";
    } elseif (empty($phonenumber_up)) {
        $errorMsg = "Please Enter PhoneNumber";
    } else {
        try {
            if (!isset($errorMsg)) {
                $update_stmt = $db->prepare("UPDATE tbl_person SET firstname = :fname_up, lastname = :lname_up, phonenumber = :phonenumber_up WHERE id = :id");
                $update_stmt->bindParam(':fname_up', $firstname_up);
                $update_stmt->bindParam(':lname_up', $lastname_up);
                $update_stmt->bindParam(':phonenumber_up', $phonenumber_up);
                $update_stmt->bindParam(':id', $id);

                if ($update_stmt->execute()) {
                    $updateMsg = "Record Update Successfully...";
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
    <div class="display-3 text-center">Edit Page</div>

    <?php
        if(isset($errorMsg)) {

    ?>
        <div class="alert alert-danger">
            <strong>wrong!<?php echo $errorMsg ?></strong>
        </div>
    <?php } ?>

    <?php
        if(isset($updateMsg)) {

    ?>
        <div class="alert alert-success">
            <strong>Success<?php echo $updateMsg ?></strong>
        </div>
    <?php } ?>

    <form method="post" class="form-horizontal text-center">
            <div class="form-group">
                <div class="row">
                    <label for="firstname" class="col-sm-3 control-label mt-5 ">Firstname</label>
                    <div class="col-sm-9 mt-5">
                        <input type="text" name="txt_firstname" class="form-control" value="<?php echo $firstname; ?>">
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="lastname" class="col-sm-3 control-label">Lastname</label>
                    <div class="col-sm-9">
                        <input type="text" name="txt_lastname" class="form-control" value="<?php echo $lastname; ?>">
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="phone" class="col-sm-3 control-label">PhoneNumber</label>
                    <div class="col-sm-9">
                        <input type="text" name="txt_phonenumber" class="form-control" value="<?php echo $phonenumber; ?>">
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="col-sm-offset-3 col-md-12 mt-3">
                    <input type="submit" name="btn_update" class="btn btn-success" value="Update">
                    <a href="index.php" class="btn btn-danger">Cancel</a>
                </div>
            </div>
        </form>
</div>

</body>
</html>
