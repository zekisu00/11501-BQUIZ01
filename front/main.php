<div class="di" style="height:540px; border:#999 1px solid; width:53.2%; margin:2px 0px 0px 0px; float:left; position:relative; left:20px;">
    <?php include "include/marquee.php";?>
    <div style="height:32px; display:block;"></div>
    
    <div style="width:100%; padding:2px; height:290px;">
        <div id="mwww" loop="true" style="width:100%; height:100%;">
            <div style="width:99%; height:100%; position:relative;" class="cent">沒有資料</div>
        </div>
    </div>
    
    <script>
        // 1. 初始化圖片陣列
        var lin = new Array();
        <?php 
            // 從資料庫撈出所有「已顯示 (sh=1)」的動畫圖片
            $mvs = $Mvim->all(['sh'=>1]);
            foreach($mvs as $mv){
                echo "lin.push('upload/{$mv['img']}')\n";
            }
        ?>
        
        // 2. 如果圖片多於一張，啟動自動輪播 (每 3 秒執行一次)
        var now = 0;
        if (lin.length > 1) {
            setInterval("ww()", 3000);
        }
        
        // 3. 輪播核心函式：使用 <embed> 標籤呈現動畫，並更新 index
        function ww() {
            $("#mwww").html("<embed loop=true src='" + lin[now] + "' style='width:99%; height:100%;'></embed>")
            now++;
            if (now >= lin.length)
                now = 0;
        }
        ww(); // 初始執行
    </script>

    <div style="width:95%; padding:2px; height:190px; margin-top:10px; padding:5px 10px 5px 10px; border:#0C3 dashed 3px; position:relative;">
        <span class="t botli">最新消息區
            <a href="?do=news" style="float:right">
                <?php 
                // 若消息數量超過 5 筆，顯示 "More..." 連結
                if($News->count(['sh'=>1]) > 5){
                    echo "More...";
                }
                ?>
            </a>
        </span>
        
        <ul class="ssaa" style="list-style-type:decimal;">
            <?php 
            $news = $News->all(['sh'=>1]," limit 5");
            foreach($news as $n):
            ?>
            <li><?= mb_substr($n['text'],0,25); ?>... <div class="all" style="display:none"><?= $n['text']; ?></div> </li>
            <?php endforeach;?>
        </ul>

        <div id="altt" style="position: absolute; width: 350px; min-height: 100px; background-color: rgb(255, 255, 204); top: 50px; left: 130px; z-index: 99; display: none; padding: 5px; border: 3px double rgb(255, 153, 0);">
        </div>
        
        <script>
            // jQuery 懸停效果：滑鼠進入顯示完整內容，滑鼠移出隱藏
            $(".ssaa li").hover(
                function() {
                    $("#altt").html("<pre>" + $(this).children(".all").html() + "</pre>")
                    $("#altt").show()
                }
            )
            $(".ssaa li").mouseout(
                function() {
                    $("#altt").hide()
                }
            )
        </script>
    </div>
</div>