<?php 
// 引入資料庫類別定義檔 (內含 DB 類別以及各個資料表實例，如 $Title, $Admin 等)
include_once "db.php";

// 1. 從網址取得 table 參數 (例如：?table=image)
$table = $_GET['table'];

// 2. 利用可變變數，動態取得對應的資料表物件
// 如果 $table 是 'image'，這裡會變成 $db = $Image;
$db = ${ucfirst($table)};

// 3. 呼叫 DB 類別的 save 方法
// 因為 $_POST 裡面已經包含了表單的所有欄位資料，
// save() 方法會自動根據是否有 'id' 欄位來決定要執行 INSERT 還是 UPDATE
$db->save($_POST);

// 4. 執行跳轉，回到該資料表的管理頁面 (admin.php)
to("../admin.php?do=$table");