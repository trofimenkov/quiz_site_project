<?php
session_start();
require_once "/vendor/connect.php";
if(!isset($_SESSION['user'])) Header("Location: /index.php");
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
    <title>Профіль</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">


    <link rel="stylesheet" href="admin/vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="admin/vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="admin/vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="admin/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="admin/vendors/selectFX/css/cs-skin-elastic.css">

    <link rel="stylesheet" href="admin/assets/css/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>



</head>

<body>

    <!-- Left Panel -->

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <!-- Header-->
        <header id="header" class="header">

            <div class="header-menu">

                <div class="col-sm-5">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link" id="pills-home-tab" data-toggle="pill" href="/index.php" role="tab" aria-controls="pills-home" aria-selected="true">Головна</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-profile-tab" data-toggle="pill" href="#" role="tab" aria-controls="pills-profile" aria-selected="false">Профіль</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-tests-tab" data-toggle="pill" href="/testing/" role="tab" aria-controls="pills-tests" aria-selected="false">Тести</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-tests-tab" data-toggle="pill" href="/rate.php" role="tab" aria-controls="pills-tests" aria-selected="false">Рейтинг</a>
                        </li>
                        <?php
                            if($_SESSION['user']['admin']==1)
                            {
                                echo '<li class="nav-item">
                                <a class="nav-link" id="pills-apanel-tab" data-toggle="pill" href="/admin/" role="tab" aria-controls="pills-apanel" aria-selected="false">Адмін панель</a>
                            </li>';
                            }
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-logout-tab" data-toggle="pill" href="vendor/logout.php" role="tab" aria-controls="pills-logout" aria-selected="false">Вийти</a>
                        </li>
                    </ul>
                </div>
            </div>

        </header><!-- /header -->
        <!-- Header-->

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Результати</h1>
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
                                <div class="col-lg-8">
                                    <div class="card">
                                        <div class="card-header">
                                            <strong class="card-title">Список результатів</strong>
                                        </div>
                                        <div class="card-body">
                                            <table class="table">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Тест</th>
                                                        <th scope="col">Кількість правильних</th>
                                                        <th scope="col">Кількість неправильних</th>
                                                        <th scope="col">Статус</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $user_id = $_SESSION['user']['id'];
                                                    $count = 0;
                                                    $query = "SELECT * FROM tests_results tr
                                                    LEFT JOIN tests t
                                                    ON t.test_id = tr.test_id
                                                    WHERE tr.user_id = $user_id";
                                                    $res = mysqli_query($connect, $query);
                                                    while ($row = mysqli_fetch_array($res)) {
                                                        $count++;
                                                    ?>
                                                        <tr>
                                                            <th scope="row"><?php echo $count; ?></th>
                                                            <td><?php echo $row["test_name"]; ?></td>
                                                            <td><?php echo $row["test_result_correct"]; ?></td>
                                                            <td><?php echo $row["test_result_incorrect"]; ?></td>
                                                            <td>
                                                                <div class="progress mb-2">
                                                                    <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: <?php echo $row["test_result_percent"]; ?>%" aria-valuenow="<?php echo $row["test_result_percent"]; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $row["test_result_percent"]; ?>%</div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="stat-widget-four">
                                                <div class="stat-icon dib">
                                                    <i class="ti-stats-up text-muted"></i>
                                                </div>
                                                <div class="stat-content">
                                                    <div class="text-left dib">
                                                        <div class="stat-heading"><b>Результат</b></div>
                                                        <div class="stat-text">
                                                            <?php
                                                            $user_id = $_SESSION['user']['id'];
                                                            $query = "SELECT COUNT(user_id) AS best_count FROM `tests_results` WHERE `user_id` = $user_id AND `test_result_percent`= 100";
                                                            $res = mysqli_fetch_array(mysqli_query($connect, $query));
                                                            //Пройдено тестів: $76,58,714
                                                            echo "Пройдено тестів: <b>" . $res['best_count'] . "</b>";
                                                            ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="stat-widget-four">
                                                <div class="stat-icon dib">
                                                    <i class="ti-bar-chart-alt text-muted"></i>
                                                </div>
                                                <div class="stat-content">
                                                    <div class="text-left dib">
                                                        <div class="stat-heading"><b>Рейтинг</b></div>
                                                        <div class="stat-text">Ваш рейтинг: <b>1</b> із 10</div>
                                                    </div>
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