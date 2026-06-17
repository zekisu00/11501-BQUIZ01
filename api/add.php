<?php 
// 引入資料庫操作檔案 (裡面應該包含了 $Title, $Admin, $Menu 等物件實例)
include_once "db.php";

// 從網址參數 (URL) 取得要操作的資料表名稱 (例如：?table=title)
$table = $_GET['table'];

// 利用可變變數將 $table 字首大寫並串接成物件變數 (例如：$table 為 'title'，則變數為 $Title)
$db = ${ucfirst($table)};

// --- 圖片處理區 ---
// 檢查是否有上傳圖片 (如果表單有選擇檔案)
if(!empty($_FILES['img']['tmp_name'])){
    // 將上傳的暫存檔案移到指定的伺服器資料夾
    move_uploaded_file($_FILES['img']['tmp_name'], "../upload/" . $_FILES['img']['name']);
    // 將檔名存入 $_POST 陣列中，以便後續存入資料庫
    $_POST['img'] = $_FILES['img']['name'];
}

// --- 資料欄位預設值處理區 (根據不同的 table 有不同的規則) ---
switch($table){
    case 'title':
        // 標題預設不顯示
        $_POST['sh'] = 0;
    break;
    case 'admin':
        // 管理員密碼確認欄位不需要存入資料庫，故刪除它
        unset($_POST['pw2']);
    break;
    case "menu":
        // 選單預設為母選單 (main_id=0) 且顯示 (sh=1)
        $_POST['main_id'] = 0;
        $_POST['sh'] = 1;
    break;
    default:
        // 其他資料表預設皆設定為顯示 (sh=1)
        $_POST['sh'] = 1;
}

// --- 資料儲存 ---
// 呼叫該資料表對應類別的 save 方法，將處理好的 $_POST 資料存入資料庫
$db->save($_POST);

// --- 頁面跳轉 ---
// 執行自定義的 to() 函式，跳轉回該資料表的管理頁面
to("../admin.php?do=$table");
?>