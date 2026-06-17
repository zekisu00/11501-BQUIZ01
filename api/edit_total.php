<?php 
// 引入資料庫操作檔案 (內含 $Total 這個 DB 物件實例)
include_once "db.php";

// 直接呼叫 $Total 物件的 save 方法，將表單內容存入資料庫
// 因為總人次設定頁面通常只有一個欄位 (例如：total)，
// 這裡會將該數值更新到資料庫中
$Total->save($_POST);

// 處理完畢後，直接跳轉回管理頁面的「總瀏覽人次」設定區
to("../admin.php?do=total");