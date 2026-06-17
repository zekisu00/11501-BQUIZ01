<?php 
// 1. 引入資料庫類別定義檔 (內含 DB 類別以及各個資料表實例，如 $Title, $Admin 等)
include_once "db.php";

// 2. 從網址參數 (URL) 取得要操作的資料表名稱 (例如：?table=image)
$table = $_GET['table'];

// 3. 利用可變變數，動態取得對應的資料表物件
// 例如：若 $table 為 'image'，ucfirst($table) 會變成 'Image'
// ${'Image'} 就等同於呼叫你在 db.php 裡定義好的 $Image 物件
$db = ${ucfirst($table)};

// 4. 呼叫 DB 類別的 save 方法
// 因為 $_POST 裡面已經包含了表單的所有欄位資料，
// save() 方法會自動根據 $_POST 陣列中是否有 'id' 欄位，來決定要執行 SQL 的 INSERT 或 UPDATE
$db->save($_POST);

// 5. 執行跳轉，處理完後自動回到該資料表的管理頁面
to("../admin.php?do=$table");


//系統性觀點：為什麼這樣寫很聰明？
//DRY 原則 (Don't Repeat Yourself)：
//如果沒有這種寫法，你可能需要寫 save_title.php、save_news.php、save_admin.php……等等幾十個檔案。
//使用這種寫法，你只需維護這一個檔案，所有資料表都能共用這個邏輯。

//物件導向的威力：
//這段程式碼展示了「封裝」後的威力。
//你只需要關心「存進去」這個動作，而不必去管底層是如何連線到 MySQL、如何組裝 SQL 語法、如何執行預處理。

//開發建議：
//這種寫法雖然簡潔，但有一個小缺點：它對表單的 name 屬性要求非常嚴格。
//你的 HTML 表單欄位名稱（例如 name="subject"）必須與資料庫的欄位名稱完全一致，
//否則 save($_POST) 就會因為欄位對不上而存入失敗。