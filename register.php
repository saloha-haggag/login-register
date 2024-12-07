<?php
include 'config.php';
if (isset($_POST['submit'])) 
{
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
    $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_img/' . $image;
    $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email = '$email'") or die('query failed');
    if (mysqli_num_rows($select) > 0) 
    {
        $message[] = 'User already exists!';
    } else 
    {
        if ($pass != $cpass) 
        {
            $message[] = 'Confirm password not matched!';
        } elseif ($image_size > 2000000) 
        {
            $message[] = 'Image size is too large!';
        } else 
        {
            $insert = mysqli_query($conn, "INSERT INTO `user_form`(name, email, password, image) VALUES('$name', '$email', '$pass', '$image')") or die('query failed');
            if ($insert) 
            {
                move_uploaded_file($image_tmp_name, $image_folder);
                $message[] = 'Registered successfully!';
                header('location:login.php');
            } else 
            {
                $message[] = 'Registration failed!';
            }
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
    <title>Register</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body 
        {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #ff9966, #ff5e62);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff;
        }
        .form-container
         {
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            width: 400px;
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }
        .form-container h3 {
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: bold;
            color: #fdfdfd;
        }
        .form-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            outline: none;
            font-size: 16px;
        }
        .form-container input[type="text"],
        .form-container input[type="email"],
        .form-container input[type="password"],
        .form-container input[type="file"] {
            background: rgba(255, 255, 255, 0.8);
            color: #333;
        }
        .form-container input[type="submit"] {
            background: #ff5e62;
            color: #fff;
            cursor: pointer;
            transition: background 0.3s;
        }
        .form-container input[type="submit"]:hover {
            background: #ff9966;
        }
        .form-container p {
            margin-top: 15px;
            font-size: 14px;
        }
        .form-container a {
            color: #ffcc00;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }
        .form-container a:hover {
            color: #ffff66;
        }
        .message 
        {
            margin-bottom: 20px;
            padding: 10px;
            background: rgba(255, 0, 0, 0.7);
            color: #fff;
            border-radius: 5px;
            font-size: 14px;
        }
        @keyframes fadeIn
         {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
<div class="form-container">
    <form action="" method="post" enctype="multipart/form-data">
        <h3>Register Now</h3>
        <?php
        if (isset($message)) 
        {
            foreach ($message as $message) 
            {
                echo '<div class="message">' . $message . '</div>';
            }
        }
        ?>
        <input type="text" name="name" placeholder="Enter username" required>
        <input type="email" name="email" placeholder="Enter email" required>
        <input type="password" name="password" placeholder="Enter password" required>
        <input type="password" name="cpassword" placeholder="Confirm password" required>
        <input type="file" name="image" accept="image/jpg, image/jpeg, image/png">
        <input type="submit" name="submit" value="Register Now">
        <p>Already have an account? <a href="login.php">Login now</a></p>
    </form>
</div>
</body>
</html>
