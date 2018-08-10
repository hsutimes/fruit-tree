<?php
/**
 * Created by PhpStorm.
 * User        : times
 * Time        : 2018/8/9 0009 12:43
 * Description : description
 */

header("Content_Type: text/html; charset=utf-8");
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: x-requested-with,content-type");
function connect($key)
{
    // 07c8b314f9a4239290b13aa91be78348 连接数据库的私钥,由md5(fruit_tree)加密
    if ($key != '07c8b314f9a4239290b13aa91be78348') {
        // 未经授权不可获取数据库连接
        return null;
    }
    $host = "localhost";
    $name = "root";
    $password = "";
    $database = "db";
    // 连接数据库
    $conn = mysqli_connect($host, $name, $password, $database);
    // 设置编码，防止中文乱码
    mysqli_set_charset($conn, "utf8");
    // 连接失败
    if (!$conn) {
        die("连接失败" . mysqli_connect_error());
    }
    return $conn;
}

?>
