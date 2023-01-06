<!-- Database connection code -->

<?php

ob_start();
    $db = mysqli_connect('localhost', 'root', '', 'user_management');

    if($db){
        // echo 'stublished';

    }
    else{
        echo 'Database connection error!';
    }
?>



<!-- insert code -->
<?php
$error_msg = '';

if(isset($_POST['saveinfo'])){
    $name = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['password'];

    if(empty(!$name) && empty(!$email) && empty(!$pass)){
            
    $upass = sha1($pass);

    $sql2 = "INSERT INTO users(name, email, pass) VALUES ('$name', '$email', '$upass')";
    $res2 = mysqli_query($db,$sql2);
    

    if($res2){
        header('Location: index.php');
    }
    else{
        echo 'Value insertion error!';
    }
}


else{
    echo 'All fields are required.';
}

}
?>



<!-- delete code -->
<?php
if(isset($_GET['id'])){
    $del_id =  $_GET['id'];

    $sql3 = "DELETE FROM users WHERE id = '$del_id'";
    $res3 = mysqli_query($db, $sql3);

    if($res3){
        header('Location: index.php');
    }
    else{
        echo 'Delete error!';
    }
}
?>


<!-- update code -->
<?php

if(isset($_POST['updateinfo'])){
    $name = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $role = $_POST['role'];
    $status = $_POST['status'];
    $id = $_POST['editid'];


    if(!empty($pass)){
        $pass = sha1($pass);
        $sql4 = "UPDATE users SET name='$name', email='$email', pass='$pass', role='$role', status='$status' WHERE id='$id' ";
    }

    if(empty($pass)){
        $sql4 = "UPDATE users SET name='$name', email='$email', role='$role', status='$status' WHERE id='$id' ";
    }

    $res4 = mysqli_query($db, $sql4);

        if($res4){
            header('Location: index.php');
        }
        else{
            echo 'Edit error!';
        }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>User Management</title>
    <style>
        a{
            text-decoration: none;
        }
    </style>
</head>

<body class="">
    <div class="users m-4 ">
        <div class="row g-0">
            <div class="col-md-4">
                <h3>Add a new user</h3>
                <form action="" class="my-5" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Enter your name</label>
                    <input type="text" name="username" class="form-control" id="username" placeholder="Fullname">
                    <?php
                        echo '<small class="text-danger">'.$error_msg.'</small>';
                    ?>
                    </div>

                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Email address</label>
                    <input type="email" name="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                    </div>

                    <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                    <small class="text-danger">Password should be 6 character long!</small>
                    </div>

                    <input type="submit" name="saveinfo" class="btn btn-md btn-info" value="Add new user" name="">
                </form>


                <!-- edit info -->
                <?php

                if(isset($_GET['edit_id'])){


                    $editid = $_GET['edit_id'];

                    $sql = "SELECT * FROM users WHERE id='$editid'";
                                $res = mysqli_query($db,$sql);

                                $row = mysqli_fetch_assoc($res);
                                $id        = $row['ID'];
                                $name      = $row['name'];
                                $email     = $row['email'];
                                $pass      = $row['pass'];
                                $role      = $row['role'];
                                $status    = $row['status'];

                    ?>
                        <h3>Update user</h3> 
                        <form action="" class="my-5" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Enter your name</label>
                                <input type="text" name="username" value="<?php echo $name;?>" class="form-control" id="username" placeholder="Fullname">
                                <?php
                                    echo '<small class="text-danger">'.$error_msg.'</small>';
                                ?>
                                </div>

                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Email address</label>
                                <input type="email" name="email" value="<?php echo $email;?>" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                                </div>

                                <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Set new password</label>
                                <input type="password" name="password" class="form-control mb-3" id="password" placeholder="Password">

                                <label>Set user role</label>
                                <select class="form-control" name="role">
                                    <option value="2" <?php if($role ==2) echo 'selected'; ?>>Admin</option>
                                    <option value="1" <?php if($role ==1) echo 'selected'; ?>>Editor</option>
                                    <option value="0" <?php if($role ==0) echo 'selected'; ?>>Subscriber</option>
                                </select>

                                <label>Set user status</label>
                                <select class="form-control" name="status">
                                    <option value="1" <?php if($status ==1) echo 'selected'; ?>>Active</option>
                                    <option value="0" <?php if($status ==0) echo 'selected'; ?>>Inactive</option>
                                </select>


                                <input type="hidden" value="<?php echo $editid; ?> " name="editid">

                                </div>

                                <input type="submit" name="updateinfo" class="btn btn-md btn-info" value="Update user" name="">
                        </form>


                    <?php

                    //if we dont want to use input type hidden then simply put the edit code here

                }

                ?>
            </div>

            <div class="col-md-8">
                    <h3 class="ms-5">All users information table</h3>

                         <table class="table table-striped m-5">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">UserRole</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            

                            <?php
                                $sql = "SELECT * FROM users";
                                $res = mysqli_query($db,$sql);

                                $serial = 0;

                                while($row = mysqli_fetch_assoc($res)){
                                    $id        = $row['ID'];
                                    $name      = $row['name'];
                                    $email     = $row['email'];
                                    $pass      = $row['pass'];
                                    $role      = $row['role'];
                                    $status    = $row['status'];

                                    $serial++;

                                    ?>

                                    <tr>
                                    <th scope="row"><?php echo $serial; ?></th>
                                    <td><?php echo $name; ?></td>
                                    <td><?php echo $email; ?></td>
                                    <td><?php 
                                    if($role == 0){
                                        echo '<span class="badge bg-info">Subscriber</span>';
                                    }
                                    if($role == 1){
                                        echo '<span class="badge bg-success">Editor</span>';
                                    }
                                    if($role == 2){
                                        echo '<span class="badge bg-danger">Admin</span>';
                                    }
                                    ?></td>
                                    <td><?php
                                     if($status == 0){
                                        echo '<span class="badge bg-danger">Inactive</span>';
                                    }
                                    if($status == 1){
                                        echo '<span class="badge bg-success">Active</span>';
                                    }
                                     
                                     ?></td>
                                    <td>
                                        <a href="index.php?edit_id=<?php echo $id;?>" class="badge bg-success">Edit</a>
                                        <a href="index.php?id=<?php echo $id; ?>" class="badge bg-danger">Delete</a>
                                    </td>
                                    </tr>

                                    <?php

                                }
                            ?>
                            
                        </tbody>
                        </table>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

    <?php ob_end_flush(); ?>
</body>
</html>