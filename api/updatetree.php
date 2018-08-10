<?php
/**
 * Created by PhpStorm.
 * User        : times
 * Time        : 2018/8/9 0009 14:53
 * Description : description
 */

require 'conn.php';
$key = $_GET['key'];
$md5 = $_GET['md5'];
$name = $_GET['name'];
$info = $_GET['info'];
// 判断参数是否为空
if ($key == '' || $name == '' || $info == '' || $md5 == '') {
    $json['msg'] = '参数为空';
    $json['status'] = 'fail';
    echo json_encode($json);
    return;
}
// 检测key是否合法
$con = connect($key);
if (!$con) {
    $json['msg'] = '未授权';
    $json['status'] = 'fail';
    echo json_encode($json);
    return;
}
// 防止SQL注入
if (get_magic_quotes_gpc()) {
    $md5 = stripslashes($md5);
    $name = stripslashes($name);
    $info = stripslashes($info);
}
$md5 = mysqli_real_escape_string($con, $md5);
$name = mysqli_real_escape_string($con, $name);
$info = mysqli_real_escape_string($con, $info);

$sql = "SELECT EXISTS(SELECT * FROM f_tree WHERE t_name = '{$name}') AS result";
$result = mysqli_query($con, $sql);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_array($result);
    if ($row[0] == 1) {
        $json['msg'] = '数据已存在';
        $json['status'] = 'fail';
    } else {
        $sql = "UPDATE f_tree SET t_name = '{$name}', t_info = '{$info}' WHERE t_md5 = '" . md5($name) . "'";
        if (mysqli_query($con, $sql)) {
            $json['status'] = 'success';
        } else {
            $json['msg'] = 'database error';
            $json['status'] = 'fail';
        }
    }
    echo json_encode($json);
}
mysqli_close($con);
?>