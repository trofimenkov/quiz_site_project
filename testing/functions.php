<?php
session_start();

require_once("../vendor/connect.php");
function getTests($connect)
{
    $query = "SELECT * FROM `tests` WHERE `test_enable` = '1'";
    $result = mysqli_query($connect, $query);
    if(!$result) return false;
    $data=array();
    while($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    return $data;
}

function get_test_data($connect,$test_id)
{
    $query = "SELECT q.question_text, q.test_id, a.answer_id, a.answer_text, a.question_id
        FROM questions q 
            LEFT JOIN answers a
                ON q.question_id = a.question_id
            LEFT JOIN tests
                ON tests.test_id = q.test_id
                    WHERE q.test_id = $test_id AND tests.test_enable = '1'";

    $result = mysqli_query($connect, $query);
    $data=null;
    while($row = mysqli_fetch_assoc($result)) {
        //if(!$row['question_id']) return false;
        $data[$row['question_id']][0] = $row['question_text'];
        $data[$row['question_id']][$row['answer_id']] = $row['answer_text'];
    }
    return $data;
}

function get_correct_answers($connect, $test)
{
    if(!$test) return false;
    $query = "SELECT q.question_id, a.answer_id
        FROM questions q
        LEFT JOIN answers a
            ON q.question_id = a.question_id
        LEFT JOIN tests
            ON tests.test_id = q.test_id
                WHERE q.test_id = $test AND a.answer_correct = '1' AND tests.test_enable = '1'";

    $res = mysqli_query($connect, $query);
    $data = null;
    while($row = mysqli_fetch_assoc($res)) {
        $data[$row['question_id']] = $row['answer_id'];
    }
    return $data;
}

function data_initialize($connect, $data, $query)
{
    $result = mysqli_query($connect, $query);

}

function pagination($q_count, $test_data, $style)
{
    $keys = array_keys($test_data);
    if($style == 'pagination')
    {
        $pagination = '<div class="pagination">';
        for($i = 1; $i <= $q_count; $i++)
        {
            $key = array_shift($keys);//забираємо елемент та видаляємо з масиву
            if($i == 1)
            {
                $pagination .= '<a class="nav-active" href="#question-'. $key .'">'. $i .'</a>';
            }
            else {
                $pagination .= '<a href="#question-'. $key .'">'. $i .'</a>';
            }

        }
        $pagination .= '</div>';
        return $pagination;
    }
    else 
    {
        $transition = '<div class="transition">'; 
            $transition .= '<a class="transition-active" href="#">Попередня</a>';
            $transition .= '<a href="#">Наступна</a>';
        $transition .= '</div>';
        return $transition;
    }
}

function get_test_data_result($connect, $test_all_data, $result, $_POST)
{
    $test = null;
    foreach($result as $q => $a) {
        $test_all_data[$q]['correct_answer'] = $a;
        if(!isset($_POST[$q])){
            $test_all_data[$q]['incorrect_answer'] = 0;
        }
    }

    foreach($_POST as $q => $a) {
        if(!isset($test_all_data[$q])){
            unset($_POST[$q]);
            continue;
        }

        if(!isset($test_all_data[$q][$a])){
            $test_all_data[$q]['incorrect_answer'] = 0;
            continue;
        }

        if($test_all_data[$q]['correct_answer']!=$a) {
            $test_all_data[$q]['incorrect_answer'] = $a;
        }
    }

    return $test_all_data;
}

function get_result($test_all_data_result){
    $all_count = count($test_all_data_result);
    $correct_answer_count = 0; 
    $incorrect_answer_count = 0;
    $percent = 0;

    foreach($test_all_data_result as $item)
    {
        if(isset($item['incorrect_answer'])) {
            $incorrect_answer_count++;
        }
    }
    $correct_answer_count = $all_count-$incorrect_answer_count;
    $percent = round($correct_answer_count/$all_count*100, 2);

    /*$print_res = '<div class="questions">';
        $print_res .= '<div class"count-res">';
            $print_res .= '<p>Кількість питань: <b>'.$all_count.'</b> </p>';
            $print_res .= '<p>Правильних відповідей: <b>'.$correct_answer_count.'</b> </p>';
            $print_res .= '<p>Неправильних відповідей: <b>'.$incorrect_answer_count.'</b> </p>';
            $print_res .= '<p>Процент вірних відповідей: <b>'.$percent.'</b> </p>';
        $print_res .= '</div>';
    $print_res .= '</div>';*/

    $test_result_info = array(
        "a_count" => $all_count,
        "a_correct" => $correct_answer_count,
        "a_incorrect" => $incorrect_answer_count,
        "a_percent" => $percent
    );

    return $test_result_info;

}

function save_result($connect, $test_result_info, $test)
{
    // Отримуємо інформацію про пройдений тест користувачем
    $user_id = $_SESSION['user']['id'];
    $query = "SELECT * FROM `tests_results` WHERE `user_id` = $user_id AND `test_id` = $test";
    $data = mysqli_query($connect, $query);
    $result = mysqli_fetch_assoc($data);
    // Обробляємо запит в БД
    /*$a_correct = max($result['test_result_correct'],$test_result_info['a_correct']);
    $a_incorrect = min($result['test_result_incorrect'],$test_result_info['a_incorrect']);
    $a_percent = max($result['test_result_percent'],$test_result_info['a_percent']);*/
    switch(mysqli_num_rows($data))
    {
        case 0:
            $a_correct = $test_result_info['a_correct'];
            $a_incorrect = $test_result_info['a_incorrect'];
            $a_percent = $test_result_info['a_percent'];
            $query = "INSERT INTO `tests_results`
                (`test_result_id`, `user_id`, `test_id`, `test_result_correct`, `test_result_incorrect`, `test_result_percent`) 
                VALUES 
                    (NULL,'$user_id','$test','$a_correct','$a_incorrect','$a_percent')";

        break;
        default:
            $a_correct = max($result['test_result_correct'],$test_result_info['a_correct']);
            $a_incorrect = min($result['test_result_incorrect'],$test_result_info['a_incorrect']);
            $a_percent = max($result['test_result_percent'],$test_result_info['a_percent']);
            $query = "UPDATE `tests_results` SET 
            `test_result_correct`=$a_correct,
            `test_result_incorrect`=$a_incorrect,
            `test_result_percent`=$a_percent
            WHERE `user_id` = $user_id AND `test_id` = $test";
        break;
    }
    mysqli_query($connect, $query);
}

?>