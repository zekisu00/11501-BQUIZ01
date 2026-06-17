// 確保網頁讀取完畢後，才執行裡面的程式碼
$(document).ready(function(e) {
    
    // 當滑鼠移動到 class 為 "mainmu" 的元素上時
    $(".mainmu").mouseover(
        function()
        {
            // 找到該元素底下的子元素 ".mw" (通常是下拉選單)
            // .stop() 是為了避免滑鼠快速進出導致動畫效果「卡住」
            // .show() 顯示出該選單
            $(this).children(".mw").stop().show()
        }
    )

    // 當滑鼠移出 class 為 "mainmu" 的元素時
    $(".mainmu").mouseout(
        function ()
        {
            // 隱藏該元素底下的子元素 ".mw"
            $(this).children(".mw").hide()
        }
    )
});

// 定義一個函式，功能是用新的網頁連結取代目前的頁面
function lo(x)
{
    location.replace(x)
}

// 定義一個開啟視窗的函式 (x: 彈出視窗, y: 內容區域, url: 要載入的網頁)
function op(x, y, url)
{
    $(x).fadeIn() // 把物件 x 淡入顯示
    
    // 如果有傳入 y (例如內容層)，也把它淡入
    if(y)
    $(y).fadeIn() 
    
    // 如果同時有 y 和 url，就用 .load() 將網頁內容載入到 y 裡面
    if(y && url)
    $(y).load(url)
}

// 定義一個關閉視窗的函式，將物件 x 淡出消失
function cl(x)
{
    $(x).fadeOut();
}