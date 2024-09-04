<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .register-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .register-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
        }
        .register-container input[type="text"],
        .register-container input[type="password"],
        .register-container input[type="email"],
        .register-container input[type="tel"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        .register-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        .register-container input[type="submit"]:hover {
            background-color: #45a049;
        }
        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<!-- <body>

<div class="register-container">
    <h2>Đăng Ký</h2>
    // <?php
    // if (isset($_GET['error'])) {
    //     echo '<p class="error-message">Vui lòng điền đầy đủ thông tin!</p>';
    // } elseif (isset($_GET['success'])) {
    //     echo '<p class="success-message">Đăng ký thành công!</p>';
    // }
    // ?>
    <form action="register_process.php" method="post">
        <input type="text" name="username" placeholder="Tên đăng nhập" required>
        <input type="password" name="password" placeholder="Mật khẩu" required>
        <input type="text" name="fullname" placeholder="Họ tên" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="tel" name="phone" placeholder="Số điện thoại" required>
        <input type="submit" value="Đăng Ký">
    </form>
</div> -->

</body>
<body>
    <div class="register-container">
        <h2>Register</h2>
        <form action="register_process.php" method="POST">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" required><br><br>

            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br><br>

            <label for="confirm_password">Confirm Password:</label><br>
            <input type="password" id="confirm_password" name="confirm_password" required><br><br>

            <label for="name">Full Name:</label><br>
            <input type="text" id="name" name="name" required><br><br>

            <label for="mail">Email:</label><br>
            <input type="email" id="mail" name="mail" required><br><br>

            <label for="phone_number">Phone Number:</label><br>
            <input type="text" id="phone_number" name="phone_number" required><br><br>

            <label for="role">Role:</label><br>
            <select id="role" name="role" required>
                <option value="student">Student</option>
                <option value="teacher">Teacher</option>
            </select><br><br>

            <input type="submit" value="Register">
        </form>
        <br>
        <a href="login.php">Already have an account? Login here</a>
    </div>
</body>
</html>
