<?php
include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];
if (!isset($user_id)) 
{
    header('location:login.php');
};
if (isset($_GET['logout'])) 
{
    unset($user_id);
    session_destroy();
    header('location:login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #4facfe, #00f2fe);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #fff;
        }
        .container
         {
            width: 100%;
            max-width: 400px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            animation: slideIn 1s ease-out;
        }
        .profile img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin: 20px 0;
            border: 2px solid #fff;
            animation: fadeIn 1.5s ease-in-out;
        }
        .profile h3 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #fff;
            text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.5);
        }

        .btn, .delete-btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            transition: all 0.3s;
        }
        .btn {
            background: #4caf50;
            color: #fff;
        }
        .btn:hover {
            background: #45a049;
        }
        .delete-btn {
            background: #f44336;
            color: #fff;
        }
        .delete-btn:hover {
            background: #e53935;
        }
        p {
            margin-top: 15px;
            font-size: 14px;
        }
        p a {
            color: #ffeb3b;
            text-decoration: none;
            font-weight: bold;
        }
        p a:hover {
            color: #ffe082;
        }
        @keyframes slideIn {
            from {
                transform: translateY(30px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="profile">
        <?php
        $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('query failed');
        if (mysqli_num_rows($select) > 0) 
        {
            $fetch = mysqli_fetch_assoc($select);
        }
        if ($fetch['image'] == '') 
        {
            echo '<img src="images/default-avatar.png" alt="Default Avatar">';
        } else 
        {
            echo '<img src="uploaded_img/' . $fetch['image'] . '" alt="User Avatar">';
        }
        ?>
        <h3><?php echo $fetch['name']; 
        ?>
      </h3>
        <a href="update_profile.php" class="btn">Update Profile</a>
        <a href="home.php?logout=<?php echo $user_id; 
        ?>
        " class="delete-btn">Logout</a>
        <p>New <a href="login.php">Login</a> or <a href="register.php">Register</a></p>
    </div>
</div>
</body>
</html>
