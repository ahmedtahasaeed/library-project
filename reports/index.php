<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit();
}

include("../config/db.php");
include("../includes/header.php");
include("../includes/sidebar.php");

// بيانات الطلاب
$students = mysqli_query($conn, "SELECT * FROM students ORDER BY name ASC");

// بيانات الكتب
$books = mysqli_query($conn, "SELECT * FROM books ORDER BY title ASC");

// بيانات الإعارات
$borrow = mysqli_query($conn, "
    SELECT borrow.id, students.name AS student_name, books.title AS book_title,      
           borrow.borrow_date, borrow.return_date, borrow.status
    FROM borrow
    JOIN students ON borrow.student_id = students.id
    JOIN books ON borrow.book_id = books.id
    ORDER BY borrow.id DESC
");
?>

<style>
/* تصميم Tabs */
.tabs {
    display: flex;
    margin-bottom: 20px;
}

.tab-button {
    padding: 10px 20px;
    background: #6a11cb;
    color: #fff;
    border: none;
    cursor: pointer;
    margin-right: 5px;
    border-radius: 8px 8px 0 0;
    transition: background 0.3s;
}

.tab-button.active, .tab-button:hover {
    background: #2575fc;
}

.tab-content {
    display: none;
    background: #fff;
    padding: 20px;
    border-radius: 0 15px 15px 15px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

.tab-content.active {
    display: block;
}
</style>

<div class="container mt-4" style="margin-left:240px;">
    <h2>التقارير</h2>
    
    <div class="tabs">
        <button class="tab-button active" onclick="openTab(event, 'students')">الطلاب</button>
        <button class="tab-button" onclick="openTab(event, 'books')">الكتب</button>
        <button class="tab-button" onclick="openTab(event, 'borrow')">الإعارات</button>
    </div>

    <!-- تقرير الطلاب -->
    <div id="students" class="tab-content active">
        <h3>تقرير الطلاب</h3>
        <table class="table table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>المستوئ</th>

                </tr>
            </thead>
            <tbody>
                <?php $i=1; while($row=mysqli_fetch_assoc($students)): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= $row['name'] ?></td>
                  <td><?= $row['level'] ?></td>

                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- تقرير الكتب -->
    <div id="books" class="tab-content">
        <h3>تقرير الكتب</h3>
        <table class="table table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>العنوان</th>
                    <th>المؤلف</th>
                    <th>الكمية</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1; mysqli_data_seek($books,0); while($row=mysqli_fetch_assoc($books)): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= $row['title'] ?></td>
                    <td><?= $row['author'] ?></td>
                    <td><?= $row['total_qty'] ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- تقرير الإعارات -->
    <div id="borrow" class="tab-content">
        <h3>تقرير الإعارات</h3>
        <table class="table table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>الطالب</th>
                    <th>الكتاب</th>
                    <th>تاريخ الإعارة</th>
                    <th>تاريخ الإرجاع</th>
                    <th>الحالة</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1; mysqli_data_seek($borrow,0); while($row=mysqli_fetch_assoc($borrow)): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= $row['student_name'] ?></td>
                    <td><?= $row['book_title'] ?></td>
                    <td><?= $row['borrow_date'] ?></td>
                    <td><?= $row['return_date'] ?></td>
                    <td><?= $row['status'] ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function openTab(evt, tabName) {
    var i, tabcontent, tabbuttons;
    tabcontent = document.getElementsByClassName("tab-content");
    for(i=0;i<tabcontent.length;i++){ tabcontent[i].classList.remove("active"); } //
    tabbuttons = document.getElementsByClassName("tab-button");
    for(i=0;i<tabbuttons.length;i++){ tabbuttons[i].classList.remove("active"); }
    document.getElementById(tabName).classList.add("active");
    evt.currentTarget.classList.add("active");
}
</script>

<?php include("../includes/footer.php"); ?>
