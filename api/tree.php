<?php
/**
 * Created by PhpStorm.
 * User        : times
 * Time        : 2018/8/9 0009 14:52
 * Description : description
 */
require 'conn.php';

$key = $_GET['key'];
// 判断参数是否为空
if ($key == '') {
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
//  限制返回数据数量为5条
$sql = "SELECT * FROM f_tree ORDER BY t_id ASC LIMIT 5";
$result = mysqli_query($con, $sql);
$i = 0;
$data = array();
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $data[$i++] = array('id' => $row[0], 'md5' => $row[1], 'name' => $row[2], 'info' => json_decode($row[3]));
    }
    $json['data'] = $data;
    $json['status'] = 'success';
    echo json_encode($json);
}
mysqli_close($con);
?>