<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit();
}

include("../config/db.php");
include("../includes/header.php");
include("../includes/sidebar.php");

// إضافة طالب جديد
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $major = $_POST['major'];
    $level = $_POST['level'];
    $phone = $_POST['phone'];

    $query = "INSERT INTO students (name, major, level, phone) VALUES ('$name','$major','$level','$phone')";
    mysqli_query($conn, $query);
    header("Location: index.php");
    exit();
}


if(isset($_GET['delete']))
{
    $id=$_GET['delete'];
    mysqli_query($conn,"DELETE FROM students WHERE id=$id");
    header("location:index.php");
}

// جلب جميع الطلاب
$result = mysqli_query($conn, "SELECT * FROM students ORDER BY id DESC");
?>

<style>
    /* تأثير على صفوف الجدول */
    
.container-student {
    margin-left: 240px; /* لتجنب sidebar */
    padding: 20px;
}

    table tbody tr:hover {
        background-color: #f1f1f1;
        transform: scale(1.01);
        transition: all 0.2s;
    }

    /* الفورم */
    .form-container {
        background: #fff;
        padding: 20px;
        border-radius: 15px;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }

    /* زر الحفظ */
    .btn-add {
        background: #6a11cb;
        color: #fff;
        transition: background 0.3s;
    }

    .btn-add:hover {
        background: #2575fc;
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
    }




</style>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
     <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>



<div class="container_student">
    <h2>نظام إدارة الطلاب</h2>

    <!-- نموذج إضافة طالب -->
    <div class="form-container">
        <form method="post" class="row g-2">
            <div class="col-md-3">
                <input type="text" name="name" placeholder="اسم الطالب" class="form-control" required>
            </div>
            <div class="col-md-3">
                <input type="text" name="major" placeholder="التخصص" class="form-control" required>
            </div>
            <div class="col-md-2">
                <input type="text" name="level" placeholder="المستوى" class="form-control" required>
            </div>
            <div class="col-md-2">
                <input type="text" name="phone" placeholder="الهاتف" class="form-control" required>
            </div>
            <div class="col-md-2">
                <button name="add" class="btn btn-add w-100">إضافة</button>
            </div>
        </form>
    </div>

    <!-- جدول الطلاب -->
    <div class="card-body">

   
    <table class="table table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>الاسم</th>
                <th>التخصص</th>
                <th>المستوى</th>
                <th>الهاتف</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row=mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= $row['name']; ?></td>
                <td><?= $row['major']; ?></td>
                <td><?= $row['level']; ?></td>
                <td><?= $row['phone']; ?></td>
                <td>
                 <a href="index.php?delete=<?=$row['id'];?>" class="btn btn-danger btn-sm"
                       onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</a>

                <a href="edit.php?id=<?=$row['id']; ?>" class="btn btn-primary btn-sm">تعديل</a>

                </td>

                <!-- <a href="index.php?delete=<?=$row['id'];?>" 
                class="btn btn-danger btn-sm" onclick="return confirm('هل انت متاكد من عمليه الحذف') ">حذف</a> -->

            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    </div>
</div>

<?php include("../includes/footer.php"); ?>


    
</body>
</html>

