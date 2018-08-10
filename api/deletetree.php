<?php
/**
 * Created by PhpStorm.
 * User        : times
 * Time        : 2018/8/9 0009 14:53
 * Description : description
 */

require 'conn.php';

$key = $_GET['key'];
$m = $_GET['md5'];
// 判断参数是否为空
if ($key == '' || $m == '') {
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
    $m = stripslashes($m);
}
$m = mysqli_real_escape_string($con, $m);
$sql = "DELETE FROM f_tree WHERE t_md5 = '{$m}'";
if (mysqli_query($con, $sql)) {
    $json['status'] = 'success';
} else {
    $json['msg'] = 'database error';
    $json['status'] = 'fail';
}
echo json_encode($json);
mysqli_close($con);
?>