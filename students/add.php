<!-- <?php  
  
include "config/db.php";

$name = $_POST['name'];
$major = $_POST['major'];
$level = $_POST['level'];
$phone = $_POST['phone'];

$result=mysqli_query($conn,"INSERT INTO    (name, major, level, phone) VALUES ('$name','$major','$level','$phone')");
if($result)
{
    header("Location: index.php");
}
//$query = "INSERT INTO students (name, major, level, phone) VALUES ('$name','$major','$level','$phone')";
// mysqli_query($conn, $query);
// header("Location: index.php");


?> -->