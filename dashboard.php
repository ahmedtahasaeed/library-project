<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: auth/login.php");
    exit();
}

include("config/db.php");
include("includes/header.php");
include("includes/sidebar.php");

// احصائيات للنظام
$students_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM students"))['total'];  
$books_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM books"))['total'];
$borrowed_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM borrow WHERE status='معار'"))['total'];
$returned_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM borrow WHERE status='تم الإرجاع'"))['total'];
?>

<style>
.dashboard {
    margin-left: 240px; /* لتجنب الـ sidebar */
    padding: 20px;
}

.card {
    background: #fff;
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    text-align: center;
    transition: transform 0.3s;
}

.card:hover {
    transform: scale(1.05);
}

.card h3 {
    font-size: 22px;
    margin-bottom: 10px;
}

.card p {
    font-size: 18px;
    color: #555;
}

.cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 20px;
}
</style>

<div class="dashboard">
    <h2>لوحة التحكم - نظام المكتبة</h2>
    <div class="cards mt-4">
        <div class="card" style="background: #6a11cb; color: #fff;">
            <h3><?= $students_count ?></h3>
            <p>الطلاب</p>
        </div>
        <div class="card" style="background: #2575fc; color: #fff;">
            <h3><?= $books_count ?></h3>
            <p>الكتب</p>
        </div>
        <div class="card" style="background: #28a745; color: #fff;">
            <h3><?= $borrowed_count ?></h3>
            <p>الإعارات الحالية</p>
        </div>
        <div class="card" style="background: #ffc107; color: #fff;">
            <h3><?= $returned_count ?></h3>
            <p>الإعارات المسترجعة</p>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>
