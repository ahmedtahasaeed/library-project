<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit();
}

include("../config/db.php");
include("../includes/header.php");
include("../includes/sidebar.php");

// جلب بيانات الطالب حسب ID
$id = $_GET['id'];
$query = "SELECT * FROM students WHERE id=$id";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

// تحديث بيانات الطالب عند الضغط على زر "تحديث"
if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $major = $_POST['major'];
    $level = $_POST['level'];
    $phone = $_POST['phone'];

    $update = "UPDATE students SET name='$name', major='$major', level='$level', phone='$phone' WHERE id=$id";
    mysqli_query($conn, $update);
    header("Location: index.php"); // العودة لصفحة الطلاب
    exit();
}
?>

<style>
    .edit-form {
        max-width: 600px;
        margin: 40px auto;
        padding: 30px;
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .btn-update {
        background: #6a11cb;
        color: #fff;
        transition: background 0.3s;
    }

    .btn-update:hover {
        background: #2575fc;
    }
</style>

<div class="edit-form">
    <h2 class="text-center mb-4">تعديل بيانات الطالب</h2>

    <form method="post">
        <div class="mb-2">
            <input type="text" name="name" class="form-control" value="<?= $row['name'] ?>" required>
        </div>
        <div class="mb-2">
            <input type="text" name="major" class="form-control" value="<?= $row['major'] ?>" required>
        </div>
        <div class="mb-2">
            <input type="text" name="level" class="form-control" value="<?= $row['level'] ?>" required>
        </div>
        <div class="mb-2">
            <input type="text" name="phone" class="form-control" value="<?= $row['phone'] ?>" required>
        </div>
        <button name="update" class="btn btn-update w-100 mb-2">تحديث</button>
        <a href="index.php" class="btn btn-secondary w-100">رجوع</a>
    </form>
</div>

<?php include("../includes/footer.php"); ?>
