<?php
include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];
if (isset($_POST['update_profile'])) 
{
    $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
    $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);
    mysqli_query($conn, "UPDATE `user_form` SET name = '$update_name', email = '$update_email' WHERE id = '$user_id'") or die('query failed');
    $old_pass = $_POST['old_pass'];
    $update_pass = mysqli_real_escape_string($conn, md5($_POST['update_pass']));
    $new_pass = mysqli_real_escape_string($conn, md5($_POST['new_pass']));
    $confirm_pass = mysqli_real_escape_string($conn, md5($_POST['confirm_pass']));
    if (!empty($update_pass) || !empty($new_pass) || !empty($confirm_pass)) 
    {
        if ($update_pass != $old_pass) 
        {
            $message[] = 'Old password does not match!';
        } elseif ($new_pass != $confirm_pass) 
        {
            $message[] = 'Confirm password does not match!';
        } else 
        {
            mysqli_query($conn, "UPDATE `user_form` SET password = '$confirm_pass' WHERE id = '$user_id'") or die('query failed');
            $message[] = 'Password updated successfully!';
        }
    }
    $update_image = $_FILES['update_image']['name'];
    $update_image_size = $_FILES['update_image']['size'];
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_image_folder = 'uploaded_img/' . $update_image;
    if (!empty($update_image)) 
    {
        if ($update_image_size > 2000000) 
        {
            $message[] = 'Image is too large!';
        } else 
        {
            $image_update_query = mysqli_query($conn, "UPDATE `user_form` SET image = '$update_image' WHERE id = '$user_id'") or die('query failed');
            if ($image_update_query) 
            {
                move_uploaded_file($update_image_tmp_name, $update_image_folder);
            }
            $message[] = 'Image updated successfully!';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff;
        }
        .update-profile {
            width: 100%;
            max-width: 600px;
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.3);
            text-align: center;
        }
        .update-profile img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin: 15px 0;
            border: 2px solid #fff;
        }
        .update-profile form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .update-profile .flex {
            display: flex;
            gap: 10px;
        }
        .update-profile .inputBox {
            flex: 1;
        }
        .update-profile .inputBox span {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        .update-profile .inputBox .box {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.9);
            font-size: 14px;
            color: #333;
        }
        .update-profile .btn,
        .update-profile .delete-btn {
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .update-profile .btn {
            background: #4caf50;
            color: #fff;
        }
        .update-profile .btn:hover {
            background: #45a049;
        }
        .update-profile .delete-btn {
            background: #f44336;
            color: #fff;
        }
        .update-profile .delete-btn:hover {
            background: #e53935;
        }
        .message {
            background: #ff9800;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="update-profile">
    <?php
    $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('query failed');
    if (mysqli_num_rows($select) > 0) 
    {
        $fetch = mysqli_fetch_assoc($select);
    }
    ?>
    <form action="" method="post" enctype="multipart/form-data">
        <?php
        if ($fetch['image'] == '') 
        {
            echo '<img src="images/default-avatar.png" alt="Default Avatar">';
        } else 
        {
            echo '<img src="uploaded_img/' . $fetch['image'] . '" alt="User Avatar">';
        }
        if (isset($message)) 
        {
            foreach ($message as $msg) 
            {
                echo '<div class="message">' . $msg . '</div>';
            }
        }
        ?>
        <div class="flex">
            <div class="inputBox">
                <span>Username:</span>
                <input type="text" name="update_name" value="<?php echo $fetch['name']; 
                ?>
                " class="box">
                <span>Email:</span>
                <input type="email" name="update_email" value="<?php echo $fetch['email']; 
                ?>" 
                class="box">
                <span>Update Image:</span>
                <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="box">
            </div>
            <div class="inputBox">
                <input type="hidden" name="old_pass" value="<?php echo $fetch['password']; 
                ?>
                ">
                <span>Old Password:</span>
                <input type="password" name="update_pass" placeholder="Enter previous password" class="box">
                <span>New Password:</span>
                <input type="password" name="new_pass" placeholder="Enter new password" class="box">
                <span>Confirm Password:</span>
                <input type="password" name="confirm_pass" placeholder="Confirm new password" class="box">
            </div>
        </div>
        <input type="submit" value="Update Profile" name="update_profile" class="btn">
        <a href="home.php" class="delete-btn">Go Back</a>
    </form>

</div>
</body>
</html>


