<?php
include 'config.php';
session_start();
if (isset($_POST['submit'])) 
{
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
    $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email = '$email' AND password = '$pass'") or die('query failed');
    if (mysqli_num_rows($select) > 0) 
    {
        $row = mysqli_fetch_assoc($select);
        $_SESSION['user_id'] = $row['id'];
        header('location:home.php');
    } else 
    {
        $message[] = 'Incorrect email or password!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body, html
         {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body 
        {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
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
            width: 350px;
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }
        .form-container h3 
        {
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
        .form-container input[type="email"],
        .form-container input[type="password"] {
            background: rgba(255, 255, 255, 0.8);
            color: #333;
        }
        .form-container input[type="submit"] {
            background: #6a11cb;
            color: #fff;
            cursor: pointer;
            transition: background 0.3s;
        }
        .form-container input[type="submit"]:hover {
            background: #2575fc;
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
        .message {
            margin-bottom: 20px;
            padding: 10px;
            background: rgba(255, 0, 0, 0.7);
            color: #fff;
            border-radius: 5px;
            font-size: 14px;
        }
        @keyframes fadeIn 
        {
            from 
            {
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
        <h3>Login Now</h3>
        <?php
        if (isset($message)) 
        {
            foreach ($message as $message) 
            {
                echo '<div class="message">' . $message . '</div>';
            }
        }
        ?>
        <input type="email" name="email" placeholder="Enter email" required>
        <input type="password" name="password" placeholder="Enter password" required>
        <input type="submit" name="submit" value="Login Now">
        <p>Don't have an account? <a href="register.php">Register now</a></p>
    </form>
</div>
</body>
</html>
