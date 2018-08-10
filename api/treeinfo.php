<?php
/**
 * Created by PhpStorm.
 * User        : times
 * Time        : 2018/8/9 0009 14:33
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
$sql = "SELECT * FROM f_tree WHERE t_md5 = '{$m}'";
$result = mysqli_query($con, $sql);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_array($result);
    $json['data'] = array('id' => $row[0], 'md5' => $row[1], 'name' => $row[2], 'info' => json_decode($row[3]));
    $json['status'] = 'success';
} else {
    $json['msg'] = '数据不存在';
    $json['status'] = 'fail';
}
echo json_encode($json);
mysqli_close($con);
?>