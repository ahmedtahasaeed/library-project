<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit();
}

include("../config/db.php");
include("../includes/header.php");
include("../includes/sidebar.php");

// جلب بيانات الإعارة حسب ID
$id = $_GET['id'];
$query = "
    SELECT borrow.*, students.name AS student_name, books.title AS book_title
    FROM borrow
    JOIN students ON borrow.student_id = students.id
    JOIN books ON borrow.book_id = books.id
    WHERE borrow.id=$id
";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

// تحديث بيانات الإعارة عند الضغط على زر "تحديث"
if (isset($_POST['update'])) {
    $student_id = $_POST['student_id'];
    $book_id = $_POST['book_id'];
    $borrow_date = $_POST['borrow_date'];
    $return_date = $_POST['return_date'];
    $status = $_POST['status'];

    $update = "
        UPDATE borrow SET 
            student_id='$student_id',
            book_id='$book_id',
            borrow_date='$borrow_date',
            return_date='$return_date',
            status='$status'
        WHERE id=$id
    ";
    mysqli_query($conn, $update);
    header("Location: index.php"); // العودة لصفحة الإعارة
    exit();
}

// جلب الطلاب والكتب للاختيار في الفورم
$students = mysqli_query($conn, "SELECT * FROM students ORDER BY name ASC");
$books = mysqli_query($conn, "SELECT * FROM books ORDER BY title ASC");
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
    <h2 class="text-center mb-4">تعديل بيانات الإعارة</h2>

    <form method="post">
        <div class="mb-2">
            <select name="student_id" class="form-control" required>
                <?php while($s = mysqli_fetch_assoc($students)): ?>
                    <option value="<?= $s['id'] ?>" <?= $s['id'] == $row['student_id'] ? 'selected' : '' ?>>
                        <?= $s['name'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-2">
            <select name="book_id" class="form-control" required>
                <?php while($b = mysqli_fetch_assoc($books)): ?>
                    <option value="<?= $b['id'] ?>" <?= $b['id'] == $row['book_id'] ? 'selected' : '' ?>>
                        <?= $b['title'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-2">
            <input type="date" name="borrow_date" class="form-control" value="<?= $row['borrow_date'] ?>" required>
        </div>

        <div class="mb-2">
            <input type="date" name="return_date" class="form-control" value="<?= $row['return_date'] ?>" required>
        </div>

        <div class="mb-2">
            <select name="status" class="form-control" required>
                <option value="معار" <?= $row['status']=='معار' ? 'selected' : '' ?>>معار</option>
                <option value="تم الإرجاع" <?= $row['status']=='تم الإرجاع' ? 'selected' : '' ?>>تم الإرجاع</option>
            </select>
        </div>

        <button name="update" class="btn btn-update w-100 mb-2">تحديث</button>
        <a href="index.php" class="btn btn-secondary w-100">رجوع</a>
    </form>
</div>

<?php include("../includes/footer.php"); ?>تعديل  الاعاره 
