<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit();
}

include("../config/db.php");
include("../includes/header.php");
include("../includes/sidebar.php");

// إضافة إعارة جديدة
if (isset($_POST['add'])) {
    $student_id = $_POST['student_id'];
    $book_id = $_POST['book_id'];
    $borrow_date = $_POST['borrow_date'];
    $return_date = $_POST['return_date'];

    $query = "INSERT INTO borrow (student_id, book_id, borrow_date, return_date, status) 
              VALUES ('$student_id','$book_id','$borrow_date','$return_date','معار')";
    mysqli_query($conn, $query);
    header("Location: index.php");
    exit();
}


//delete

if(isset($_GET['delete']))
{
    $id=$_GET['delete'];
    mysqli_query($conn,"DELETE FROM borrow WHERE  id=$id");
    header("location: index.php");

}

// تحديث حالة الإرجاع مباشرة
if (isset($_GET['return'])) {
    $id = $_GET['return'];
    mysqli_query($conn, "UPDATE borrow SET status='تم الإرجاع' WHERE id=$id");
    header("Location: index.php");
    exit();
}

// جلب جميع الإعارات مع أسماء الطلاب والكتب
$result = mysqli_query($conn, "
    SELECT borrow.id, students.name AS student_name, books.title AS book_title, 
           borrow.borrow_date, borrow.return_date, borrow.status
    FROM borrow
    JOIN students ON borrow.student_id = students.id
    JOIN books ON borrow.book_id = books.id
    ORDER BY borrow.id DESC
");

// جلب الطلاب والكتب للاختيار في الفورم
$students = mysqli_query($conn, "SELECT * FROM students ORDER BY name ASC");
$books = mysqli_query($conn, "SELECT * FROM books ORDER BY title ASC");
?>

<style>
    .form-container {
        background: #fff;
        padding: 20px;
        border-radius: 15px;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }

    table tbody tr:hover {
        background-color: #f1f1f1;
        transform: scale(1.01);
        transition: all 0.2s;
    }

    .btn-add {
        background: #6a11cb;
        color: #fff;
        transition: background 0.3s;
    }

    .btn-add:hover {
        background: #2575fc;
    }

    .btn-return {
        background: #28a745;
        color: #fff;
        transition: background 0.3s;
    }

    .btn-return:hover {
        background: #218838;
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
    }
</style>

<div class="container mt-4">
    <h2>نظام الإعارة</h2>

    <!-- نموذج إضافة إعارة -->
    <div class="form-container">
        <form method="post" class="row g-2">
            <div class="col-md-3">
                <select name="student_id" class="form-control" required>
                    <option value="">اختر الطالب</option>
                    <?php while($s = mysqli_fetch_assoc($students)): ?>
                        <option value="<?= $s['id'] ?>"><?= $s['name'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-3">
                <select name="book_id" class="form-control" required>
                    <option value="">اختر الكتاب</option>
                    <?php while($b = mysqli_fetch_assoc($books)): ?>
                        <option value="<?= $b['id'] ?>"><?= $b['title'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="borrow_date" class="form-control" required>
            </div>
            <div class="col-md-2">
                <input type="date" name="return_date" class="form-control" required>
            </div>
            <div class="col-md-2">
                <button name="add" class="btn btn-add w-100">إضافة</button>
            </div>
        </form>
    </div>

    <!-- جدول الإعارات -->
    <table class="table table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>الطالب</th>
                <th>الكتاب</th>
                <th>تاريخ الإعارة</th>
                <th>تاريخ الإرجاع</th>
                <th>الحالة</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['student_name'] ?></td>
                <td><?= $row['book_title'] ?></td>
                <td><?= $row['borrow_date'] ?></td>
                <td><?= $row['return_date'] ?></td>
                <td><?= $row['status'] ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">تعديل</a>
                    
                    <?php if($row['status'] == 'معار'): ?>
                        <a href="index.php?return=<?= $row['id'] ?>" class="btn btn-return btn-sm"
                           onclick="return confirm('تأكيد إرجاع الكتاب؟')">تم الإرجاع</a>
                    <?php endif; ?>

                    <a href="index.php?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
                       onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include("../includes/footer.php"); ?>
