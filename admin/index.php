<?php
session_start();
require_once "../vendor/connect.php";
if(!isset($_SESSION['user'])) Header("Location: /index.php");
if($_SESSION['user']['admin']==0) Header("Location: /index.php");
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
                        <a href="#"> <i class="menu-icon fa fa-dashboard"></i>Головна </a>
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
                        <h1>Головна</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="col-xl-3 col-lg-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="stat-widget-one">
                                                <div class="stat-icon dib"><i class="ti-user text-primary border-primary"></i></div>
                                                <div class="stat-content dib">
                                                <?php
                                                    $query = "SELECT COUNT(user_id) as user_count FROM users";
                                                    $data = mysqli_fetch_array(mysqli_query($connect,$query));
                                                    ?>
                                                    <div class="stat-text">Користувачі</div>
                                                    <div class="stat-digit"><?php echo $data['user_count'];?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-lg-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="stat-widget-one">
                                                <div class="stat-icon dib"><i class="ti-layout-grid2 text-warning border-warning"></i></div>
                                                <div class="stat-content dib">
                                                    <?php
                                                    $query = "SELECT COUNT(test_id) as test_count FROM tests";
                                                    $data = mysqli_fetch_array(mysqli_query($connect,$query));
                                                    ?>
                                                    <div class="stat-text">Тести</div>
                                                    <div class="stat-digit"><?php echo $data['test_count'];?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                    <!--/.col-->





                </div>
            </div><!-- .animated -->
        </div><!-- .content -->

</body>

</html>