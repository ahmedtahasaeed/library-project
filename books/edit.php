<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit();
}

include("../config/db.php");
include("../includes/header.php");
include("../includes/sidebar.php");

// جلب بيانات الكتاب حسب ID
$id = $_GET['id'];
$query = "SELECT * FROM books WHERE id=$id";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

// تحديث بيانات الكتاب عند الضغط على زر "تحديث"
if (isset($_POST['update'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $quantity = $_POST['total_qty'];

    $update = "UPDATE books SET title='$title', author='$author', total_qty=$quantity WHERE id=$id";
    mysqli_query($conn, $update);
    header("Location: index.php"); // العودة لصفحة الكتب
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

<input type="text" name="title" class="form-control" value="<?=$book['title'];?>" required>

<div class="edit-form">
    <h2 class="text-center mb-4">تعديل بيانات الكتاب</h2>

    <form method="post">
        <div class="mb-2">
            <input type="text" name="title" class="form-control" value="<?=$row['title'];?>" required>
        </div>
        <div class="mb-2">
            <input type="text" name="author" class="form-control" value="<?=$row['author'];?>" required>
        </div>
        
        <div class="mb-2">
            <input type="number" name="total_qty" class="form-control" value="<?=$row['total_qty'];?>" required>
        </div>
        <button name="update" class="btn btn-update w-100 mb-2">تحديث</button>
        <a href="index.php" class="btn btn-secondary w-100">رجوع</a>
    </form>
</div>

<?php include("../includes/footer.php"); ?>
