<?php
session_start();
include("../config/db.php");

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['user'] = $username;  //اذاوجد صف واحد فقط يسمح بتسجيل الدخول
        header("Location: ../dashboard.php");
        exit();  //يوقف اي كودبعد التحويل
    } else {
        $error = "بيانات الدخول غير صحيحة";
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تسجيل الدخول - المكتبة</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <style>
        /* خلفية متدرجة */
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            font-family: Arial, sans-serif;
        }

        /* شكل الفورم */
        .login-form {
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 350px;
            transition: transform 0.3s ease;
        }

        /* حركة عند المرور */
        .login-form:hover {
            transform: scale(1.05);
        }

        /* الحقول */
        .form-control:focus {
            box-shadow: 0 0 5px #2575fc;
            border-color: #2575fc;
        }

        /* زر الدخول */
        .btn-login {
            background: #6a11cb;
            color: #fff;
            width: 100%;
            transition: background 0.3s;
        }

        .btn-login:hover {
            background: #2575fc;
        }

        /* رسالة الخطأ */
        .error {
            color: red;
            margin-bottom: 15px;
            text-align: center;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }
    </style>
</head>
<body>

<div class="login-form">
    <h2>تسجيل الدخول</h2>
    <?php if(isset($error)) echo "<div class='error'>$error</div>"; ?>

    <form method="post">
        <input type="text" name="username" class="form-control mb-3" placeholder="اسم المستخدم" required>
        <input type="password" name="password" class="form-control mb-3" placeholder="كلمة المرور" required>
        <button type="submit" name="login" class="btn btn-login mb-2">دخول</button>
    </form>
</div>

</body>
</html>

