<?php 
session_start();
require_once "../vendor/connect.php"; 
if(!isset($_SESSION['user'])) Header("Location: /index.php");
if($_SESSION['user']['admin']==0) Header("Location: /index.php");
$id = $_GET["id"];
if (isset($_POST["add_answer"]) && !empty($_POST["answer_name"])) {
    $correct = 0;
    if(isset($_POST["is_correct"]))
    {
        $correct = 1;
    }
    $question_name = $_POST["question_name"];
    $query = "INSERT INTO `answers`(`answer_id`, `answer_text`, `answer_correct`, `question_id`) VALUES (NULL,'$_POST[answer_name]','$correct',$id)";
    mysqli_query($connect, $query) or die(mysqli_error($connect));
    Header("Location: ../admin/add_answer.php?id=$id");
}
?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/selectFX/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
</head>

<body>
    <!-- Left Panel -->
    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">
            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="./"><img src="images/logo.png" alt="Logo"></a>
            </div>
            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li>
                    <a href="demo.php"> <i class="menu-icon fa fa-dashboard"></i>Головна </a>
                        <a href="exam_category.php"> <i class="menu-icon fa fa-dashboard"></i>Панель тестів </a>
                        <a href="qpanel.php"> <i class="menu-icon fa fa-dashboard"></i>Панель питань </a>
                        <a href="/index.php"> <i class="menu-icon fa fa-dashboard"></i>Назад </a>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside><!-- /#left-panel -->
    <!-- Left Panel -->
    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">
        <!-- Header-->
        <header id="header" class="header">
            <div class="header-menu">
                <div class="col-sm-7">
                </div>
                <div class="col-sm-5">
                    <div class="user-area dropdown float-right">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="user-avatar rounded-circle" src="images/admin.jpg" alt="User Avatar">
                        </a>

                        <div class="user-menu dropdown-menu">
                            <a class="nav-link" href="#"><i class="fa fa-power-off"></i> Logout</a>
                        </div>
                    </div>
                </div>
            </div>

        </header><!-- /header -->
        <!-- Header-->
        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Створення варіантів відповідей</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <form name="form1" action="" method="post">
                                <div class="card-body">
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-header"><strong>Новий варіант відповіді</strong></div>
                                            <div class="card-body card-block">
                                                <div class="form-group"><label for="vat" class=" form-control-label">Назва варіанту</label><input type="text" name="answer_name" id="answer_name" placeholder="Введіть варіант відповіді" class="form-control"></div>
                                                <div class="form-group"><input type="checkbox" name="is_correct"><label for="vat" class=" form-control-label">Вірний варіант</label></div>
                                                <div class="form-group"><input type="submit" value="Додати питання" name="add_answer" class="btn btn-success"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <strong class="card-title">Список питань</strong>
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">Питання</th>
                                                            <th scope="col">Тип</th>
                                                            <th scope="col">Видалення</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $query = "SELECT * FROM `answers` WHERE `question_id`=$id";
                                                            $res = mysqli_query($connect, $query);
                                                            while ($row = mysqli_fetch_array($res)) {
                                                                $count++;
                                                                $status = $row["answer_correct"] ? "<font color='green'>"."Корректне"."</font color>" : "<font color='red'>"."Некорректне"."</font color>";
                                                           
                                                        ?>
                                                                <tr>
                                                                    <th scope="row"><?php echo $count; ?></th>
                                                                    <td><?php echo $row["answer_text"]; ?></td>
                                                                    <td><?php echo $status; ?></td>
                                                                    <td><a href="delete_answer.php?id=<?php echo $row["question_id"]; ?>&a_id=<?php echo $row["answer_id"]; ?>">Видалити</a></td>
                                                                </tr>
                                                        <?php
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>

                    </div>
                    <!--/.col-->
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->

</body>

</html>
