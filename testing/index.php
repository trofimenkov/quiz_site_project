<?php
session_start();
require_once "../vendor/connect.php";
require_once("functions.php");
if(!isset($_SESSION['user'])) Header("Location: /index.php");
if (isset($_POST['test'])) {
    $test = (int)$_POST['test'];
    unset($_POST['test']);
    $result = get_correct_answers($connect, $test);
    if (!is_array($result)) exit('ERROR! Not array');

    $test_all_data = get_test_data($connect, $test);
    $test_all_data_result = get_test_data_result($connect, $test_all_data, $result, $_POST);
    //print_r($test_all_data_result);

    $test_result_info = get_result($test_all_data_result);

    echo '<div class="col-lg-3 col-md-6">
    <div class="card">
        <div class="card-body">
            <div class="stat-widget-three">
                <div class="stat-icon">
                    <i class="ti-layers-alt text-muted"></i>
                </div>
                <div class="stat-content">
                    <div class="text-left">
                        <div class="stat-heading"><b>Кількість питань:</b></div>
                        <div class="stat-text">'.$test_result_info['a_count'].'</div>
                    </div>
                </div>
            </div>
            <div class="stat-widget-three">
                <div class="stat-icon">
                    <i class="ti-check text-muted"></i>
                </div>
                <div class="stat-content">
                    <div class="text-left">
                        <div class="stat-heading"><b>Вірні відповіді:</b></div>
                        <div class="stat-text">'.$test_result_info['a_correct'].'</div>
                    </div>
                </div>
            </div>
            <div class="stat-widget-three">
                <div class="stat-icon">
                    <i class="ti-close text-muted"></i>
                </div>
                <div class="stat-content">
                    <div class="text-left">
                        <div class="stat-heading"><b>Невірні відповіді:</b></div>
                        <div class="stat-text">'.$test_result_info['a_incorrect'].'</div>
                    </div>
                </div>
            </div>
            <div class="stat-widget-three">
                <div class="progress mb-2">
                    <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width:'.$test_result_info["a_percent"].'%" aria-valuenow="'.$test_result_info["a_percent"].'" aria-valuemin="0" aria-valuemax="100">'.$test_result_info["a_percent"].'%</div>
                </div>
            </div>
            <a href="/testing/">Повернутися до тестів</a>
        </div>
    </div>
</div>
    ';
/*
    $print_res = '<div class="questions">';
    $print_res .= '<div class"count-res">';
    $print_res .= '<p>Кількість питань: <b>' . $test_result_info['a_count'] . '</b> </p>';
    $print_res .= '<p>Правильних відповідей: <b>' . $test_result_info['a_correct'] . '</b> </p>';
    $print_res .= '<p>Неправильних відповідей: <b>' . $test_result_info['a_incorrect'] . '</b> </p>';
    $print_res .= '<p>Процент вірних відповідей: <b>' . $test_result_info['a_percent'] . '</b> </p>';
    $print_res .= '</div>';
    $print_res .= '</div>';


    echo $print_res;
*/
    //echo print_result($test_all_data_result);
    echo save_result($connect, $test_result_info, $test);
    die();
}

$tests = getTests($connect);

if (isset($_GET['test'])) {
    $test_id = (int)$_GET['test'];
    $test_data = get_test_data($connect, $test_id);

    if (is_array($test_data)) {
        $q_count = count($test_data);
        $pagination = pagination($q_count, $test_data, 'pagination'); // STYLES = 1: Pagination 2: Transition
    }
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
    <title>Тести</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">


    <link rel="stylesheet" href="../admin/vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../admin/vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../admin/vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="../admin/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="../admin/vendors/selectFX/css/cs-skin-elastic.css">

    <link rel="stylesheet" href="../admin/assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/test.css">

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
                            <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="/profile.php" role="tab" aria-controls="pills-profile" aria-selected="false">Профіль</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-tests-tab" data-toggle="pill" href="#" role="tab" aria-controls="pills-tests" aria-selected="false">Тести</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-tests-tab" data-toggle="pill" href="/rate.php" role="tab" aria-controls="pills-tests" aria-selected="false">Рейтинг</a>
                        </li>
                        <?php
                        if ($_SESSION['user']['admin'] == 1) {
                            echo '<li class="nav-item">
                                <a class="nav-link" id="pills-apanel-tab" data-toggle="pill" href="/admin/" role="tab" aria-controls="pills-apanel" aria-selected="false">Адмін панель</a>
                            </li>';
                        }
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-logout-tab" data-toggle="pill" href="/vendor/logout.php" role="tab" aria-controls="pills-logout" aria-selected="false">Вийти</a>
                        </li>
                    </ul>
                </div>
            </div>

        </header><!-- /header -->
        <!-- Header-->

        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">

                                


                                <?php
                                if ($tests) :
                                    $count = 0;
                                    foreach ($tests as $test) :
                                        $count == 5 ? $count = 1 : $count++;
                                ?>
                                        <div class="col-sm-6 col-lg-3">
                                            <div class="card text-white bg-flat-color-<?= $count ?>">
                                                <div class="card-body pb-2">
                                                    <h4 class="mb-0">
                                                        <span class="count"><?= $test['test_name'] ?></span>
                                                    </h4>
                                                    <a class="text-light" href="?test=<?= $test['test_id'] ?>">
                                                        <p class="text-light">
                                                            <span class="count">Пройти</span>
                                                        </p>
                                                    </a>

                                                </div>

                                            </div>
                                        </div>
                                <?php
                                    endforeach;
                                endif;
                                ?>
                            </div>
                            <hr>
                            <div class="col-md-6 offset-md-3">

                                <div class="content">
                                    <?php if (isset($test_data)) : ?>
                                                <?= $pagination ?>
                                        <span class="none" id="test-id"><?= $test_id ?></span>
                                        <div class="test-data">
                                            <?php foreach ($test_data as $id_q => $item) : ?>
                                                <div class="question" data-id="<?= $id_q ?>" id="question-<?= $id_q ?>">
                                                    <div class="card">
                                                        <?php foreach ($item as $id_answer => $answer) : ?>



                                                            <?php if (!$id_answer) : ?>
                                                                <div class="card-header">
                                                                    <strong class="card-title mb-3"><?= $answer ?></strong>
                                                                </div>
                                                                <div class="card-body">
                                                                <?php else : ?>
                                                                    <div class="tdiv">
                                                                        <input type="radio" id="answer-<?= $id_answer ?>" name="question-<?= $id_q ?>" value="<?= $id_answer ?>">
                                                                        <label for="answer-<?= $id_answer ?>" class ="tradio"><?= $answer ?></label>
                                                                        </div>
                                                                <?php endif; ?>

                                                            <?php endforeach; ?>
                                                                </div>
                                                    </div>
                                                </div>

                                            <?php endforeach; ?>
                                            <div class="buttons">
                                                <button type="button" class="btn btn-success btn-lg btn-block" id="btn">Здати</button>
                                            </div>
                                        </div>

                                    <?php endif; ?>


                                    <script src="http://code.jquery.com/jquery-latest.js"></script>
                                    <script src="scripts.js"></script>
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
<?php

/* <div class="card text-white bg-flat-color-1">
                                        <div class="card-body pb-2">
                                            <h4 class="mb-0">
                                                <span class="count">Опитування 1</span>
                                            </h4>
                                            <p class="text-light">
                                                <span class="count">Пройти</span>
                                            </p>

                                        </div>

                                    </div> */
?>