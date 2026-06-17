<?php 
// 檢查是否收到表單送出的帳號資料
if(isset($_POST['acc'])){
    // 驗證帳號與密碼是否正確 (此處為簡易硬編碼驗證)
    if($_POST['acc']=='admin' && $_POST['pw']=='1234'){
        // 驗證成功：設定 Session 標記已登入
        $_SESSION['login'] = 1;
        // 跳轉至後台管理頁面
        to("admin.php");
    }else{
        // 驗證失敗：透過 JavaScript 顯示錯誤提示訊息
        echo "<script>";
        echo "alert('帳號或密碼錯誤')";
        echo "</script>";
    }
}
?>

<div class="di" style="height:540px; border:#999 1px solid; width:53.2%; margin:2px 0px 0px 0px; float:left; position:relative; left:20px;">
    <?php include "include/marquee.php";?> <div style="height:32px; display:block;"></div>
    
    <form method="post" action="?do=login">
        <p class="t botli">管理員登入區</p>
        <p class="cent">帳號 ： <input name="acc" autofocus="" type="text"></p>
        <p class="cent">密碼 ： <input name="pw" type="password"></p>
        <p class="cent">
            <input value="送出" type="submit">
            <input type="reset" value="清除">
        </p>
    </form>
</div>