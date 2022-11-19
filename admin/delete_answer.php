<?php 
    session_start();
    require_once "../vendor/connect.php";
    if(!isset($_SESSION['user'])) Header("Location: /index.php");
    if($_SESSION['user']['admin']==0) Header("Location: /index.php");
    $id=$_GET["a_id"];
    $redirect_id=$_GET["id"];
    $query = "DELETE FROM `answers` WHERE `answer_id` = $id";
    mysqli_query($connect, $query);
    ?>
    <script type="text/javascript">
        window.location="add_answer.php?id=<?php echo $redirect_id; ?>";
    </script>
    <?php
?>