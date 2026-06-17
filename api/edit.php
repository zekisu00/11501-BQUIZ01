<?php 
include_once "db.php";

// 從 URL 取得資料表名稱並動態建立對應的 DB 物件
$table = $_GET['table'];
$db = ${ucfirst($table)};

// 遍歷表單傳送過來的 id 陣列，進行逐筆處理
foreach($_POST['id'] as $idx => $id){
    
    // --- 刪除邏輯 ---
    // 檢查是否有傳入刪除陣列 $_POST['del']，且目前的 id 包含在其中
    if(isset($_POST['del']) && in_array($id, $_POST['del'])){
        $db->del($id); // 執行刪除
    } else {
        // --- 修改邏輯 ---
        // 先將該筆資料從資料庫讀出來 (為了保留原本的內容)
        $row = $db->find($id);

        // 根據不同的資料表，更新不同的欄位資料
        switch($table){
            case "title": // 標題：更新文字，且 sh 欄位為單選 (radio)
                $row['text'] = $_POST['text'][$idx];
                $row['sh'] = (isset($_POST['sh']) && $_POST['sh'] == $id) ? 1 : 0;
            break;
            case "ad":
            case "news": // 廣告與新聞：更新文字，且 sh 為多選 (checkbox)
                $row['text'] = $_POST['text'][$idx];
                $row['sh'] = (isset($_POST['sh']) && in_array($id, $_POST['sh'])) ? 1 : 0;
            break;
            case "mvim":
            case "image": // 圖片：只有顯示狀態需更新
                $row['sh'] = (isset($_POST['sh']) && in_array($id, $_POST['sh'])) ? 1 : 0;
            break;
            case "admin": // 管理者：更新帳號與密碼
                $row['acc'] = $_POST['acc'][$idx];
                $row['pw'] = $_POST['pw'][$idx];
            break;
            case "menu": // 選單：更新連結網址、名稱與顯示狀態
                $row['href'] = $_POST['href'][$idx];
                $row['text'] = $_POST['text'][$idx];
                $row['sh'] = (isset($_POST['sh']) && in_array($id, $_POST['sh'])) ? 1 : 0;
            break;
        }
        
        // 將更新後的 $row 資料存回資料庫
        $db->save($row);
    }
}

// 處理完畢後跳轉回後台列表頁
to("../admin.php?do=$table");