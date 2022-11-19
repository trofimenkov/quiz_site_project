<?php 
    session_start();
    require_once "../vendor/connect.php";
    if(!isset($_SESSION['user'])) Header("Location: /index.php");
    if($_SESSION['user']['admin']==0) Header("Location: /index.php");
    $id=$_GET["id"];
    $query = "DELETE FROM `tests` WHERE `test_id` = $id";
    mysqli_query($connect, $query);
    ?>
    <script type="text/javascript">
        window.location="exam_category.php";
    </script>
    <?php
?>