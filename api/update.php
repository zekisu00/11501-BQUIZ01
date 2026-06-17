<?php 
// 引入資料庫操作檔案 (內含 DB 類別定義)
include_once "db.php";

// 1. 取得網址列的 table 參數 (決定要操作哪張資料表，例如 ?table=image)
$table = $_GET['table'];

// 2. 利用可變變數，取得該資料表的物件實例 (例如 $table='image' -> $db=$Image)
$db = ${ucfirst($table)};

// 3. 檢查是否有上傳圖片 (確認 $_FILES 陣列不為空)
if(!empty($_FILES['img']['tmp_name'])){
    
    // 4. 將上傳的圖片從暫存路徑移動到正式的存放路徑 (../upload/檔名)
    move_uploaded_file($_FILES['img']['tmp_name'], "../upload/{$_FILES['img']['name']}");

    // 5. 將目前這筆要修改的資料從資料庫找出來
    // 因為圖片更新通常是基於該筆資料的 ID，所以這裡先用 find 撈出整筆物件
    $row = $db->find($_POST['id']);

    // 6. 更新該資料物件中的圖片欄位名稱為新上傳的檔名
    $row['img'] = $_FILES['img']['name'];
    
    // 7. 將修改後的物件存回資料庫 (save 方法會根據 $row 裡是否有 id 執行 update)
    $db->save($row);
}

// 8. 處理完成後，跳轉回該資料表的後台列表頁面
to("../admin.php?do=$table");