<?php
    require_once('connection.php');

    if (isset($_REQUEST['delete_id'])) {
        $id = $_REQUEST['delete_id'];

        $select_stmt = $db->prepare("SELECT * FROM tbl_person WHERE id = :id");
        $select_stmt->bindParam(':id', $id);
        $select_stmt->execute();
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

        $delete_stmt = $db->prepare('DELETE FROM tbl_person WHERE id = :id');
        $delete_stmt->bindParam(':id', $id);
        $delete_stmt->execute();

        header('Location: index.php');
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
    <div class="display-3 text-center">Information</div>
    <a href="add.php" class="btn btn-success mb-3">Add+</a>
    <table class="table table-striped table-bordered table-hover">
        <thead>
             <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Phone</th>
                <th>Edit</th>
                <th>Delete</th>
             <tr>
        </thead>

        <tbody>
            <?php
                $select_stmt = $db->prepare("SELECT * FROM tbl_person");
                $select_stmt->execute();

                while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>

                    <tr>
                        <td><?php echo $row["firstname"]; ?></td>
                        <td><?php echo $row["lastname"]; ?></td>
                        <td><?php echo $row["phonenumber"]; ?></td>
                        <td><a href="edit.php?update_id=<?php echo $row["id"];?>" <button class="btn btn-primary" type="Edit">Edit</button></a></td>
                        <td><a href="?delete_id=<?php echo $row["id"]; ?> "<button class="btn btn-danger" type="Delete">Delete</button></a></td>
                    </tr>

            <?php } ?>
        </tbody>
    </table>

    </div>
   
</body>
</html>