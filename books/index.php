<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit();
}


include ("../config/db.php");
include ("../includes/header.php");
include ("../includes/sidebar.php");

// إضافة كتاب جديد
if (isset($_POST['add'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $quantity = $_POST['total_qty'];

    mysqli_query($conn, "INSERT INTO books(title, author, total_qty) VALUES('$title','$author',$quantity)");
    header("Location: index.php");
    exit();
}

// حذف كتاب
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM books WHERE id=$id");
    header("Location: index.php");
   
}

// جلب جميع الكتب
$books = mysqli_query($conn, "SELECT * FROM books");
?>

<style>
.container-books {
    margin-left: 240px; /* لتجنب sidebar */
    padding: 20px;
}
.card {
    background: #fff;
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}
.btn-add {
    background: #6a11cb;
    color: #fff;
}
.btn-add:hover {
    background: #2575fc;
}
</style>


<div class="container-books">
    <h2>الكتب</h2>

    <!-- نموذج إضافة كتاب جديد -->
    <div class="card">
        <h4>إضافة كتاب جديد</h4>
        <form method="post" class="row g-3">
            <div class="col-md-4">
                <input type="text" name="title" class="form-control" placeholder="عنوان الكتاب" required>
            </div>
            <div class="col-md-4">
                <input type="text" name="author" class="form-control" placeholder="المؤلف" required>
            </div>
            <div class="col-md-2">
                <input type="number" name="total_qty" class="form-control" placeholder="الكمية" min="1" required>
            </div>
            <div class="col-md-2">
                <button type="submit" name="add" class="btn btn-add w-100">إضافة</button>
            </div>
        </form>
    </div>

    <!-- جدول الكتب -->
    <div class="card">
        <h4>قائمة الكتب</h4>
        <table class="table table-bordered table-striped text-center">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>العنوان</th>
                    <th>المؤلف</th>
                    <th>الكمية</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php  while($row=mysqli_fetch_assoc($books)): ?>
                <tr>
                   <td><?= $row['id'] ;?></td>
                    <td><?= $row['title'] ;?></td>
                    <td><?= $row['author'] ;?></td>
                    <td><?= $row['total_qty']; ?></td>
                    <td>

                    <a href="index.php?delete=<?=$row['id'];?>" class="btn btn-danger btn-sm" onclick="return confirm('هل انت متاكد من عمليه الحذف') ">حذف</a>

                    <!-- <a href="index.php?delete=<?= $row['id'];?>" class="btn btn-sm btn-danger"
                           onclick="return confirm('هل أنت متأكد من حذف هذا الكتاب؟');">حذف</a> -->
                        <a href="edit.php?id=<?= $row['id'];?>" class="btn btn-sm btn-primary">تعديل</a>

                    </td>
                   
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>


<?php include("../includes/footer.php"); ?>
