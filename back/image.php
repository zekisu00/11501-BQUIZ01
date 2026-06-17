<div class="di" style="height:540px; border:#999 1px solid; width:76.5%; margin:2px 0px 0px 0px; float:left; position:relative; left:20px;">
    <table width="100%">
        <tbody>
            <tr>
                <td style="width:70%;font-weight:800; border:#333 1px solid; border-radius:3px;" class="cent">
                    <a href="?do=admin" style="color:#000; text-decoration:none;">後台管理區</a>
                </td>
                <td>
                    <button onclick="document.cookie=&#39;user=&#39;;location.replace(&#39;index.php&#39;)"
                        style="width:99%; margin-right:2px; height:50px;">管理登出</button>
                </td>
            </tr>
        </tbody>
    </table>

    <div style="width:99%; height:87%; margin:auto; overflow:auto; border:#666 1px solid;">
        <p class="t cent botli">校園映像資料管理</p>
        
        <form method="post" action="./api/edit.php?table=<?= $do ?>">
            <table width="100%">
                <tbody>
                    <tr class="yel">
                        <td width="70%">校園映像資料</td>
                        <td width="10%">顯示</td>
                        <td width="10%">刪除</td>
                        <td></td>
                    </tr>
                    
                    <?php 
                    $db = ${ucfirst($do)};
                    
                    // --- 分頁邏輯 ---
                    $all = $db->count();      // 1. 計算總筆數
                    $div = 3;                 // 2. 每頁顯示筆數
                    $pages = ceil($all / $div); // 3. 計算總頁數 (向上取整)
                    $now = $_GET['p'] ?? 1;   // 4. 取得當前頁碼 (若無則預設為第1頁)
                    $start = ($now - 1) * $div; // 5. 計算資料起始偏移量 (SQL limit 用)
                    
                    // 6. 撈出當前分頁的資料
                    $rows = $db->all(" limit $start,$div");
                    
                    foreach($rows as $row):
                    ?>
                    <tr>
                        <td>
                            <img src="./upload/<?= $row['img']; ?>" style="width:150px;height:103px">
                        </td>
                        <td>
                            <input type="checkbox" name="sh[]" value="<?= $row['id']; ?>" <?= ($row['sh']==1)?'checked':''; ?> >
                        </td>
                        <td>
                            <input type="checkbox" name="del[]" value="<?= $row['id']; ?>">
                        </td>
                        <td>
                            <input type="button" value="更新圖片" onclick="op('#cover','#cvr','include/update_<?= $do; ?>.php?id=<?= $row['id'];?>')">
                        </td>
                        <input type="hidden" name="id[]" value="<?= $row['id']; ?>">
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class='cent'>
                <?php
                    // 顯示「上一頁」連結
                    if($now - 1 > 0){
                        $prev = $now - 1;
                        echo "<a href='?do=$do&p=$prev'> < </a>";
                    }

                    // 循環顯示頁碼 (當前頁面文字放大)
                    for($i = 1; $i <= $pages; $i++){
                        $size = ($i == $now) ? '20px' : '16px';
                        echo "<a href='?do=$do&p=$i' style='font-size:$size'> $i </a>";
                    }

                    // 顯示「下一頁」連結
                    if($now + 1 <= $pages){
                        $next = $now + 1;
                        echo "<a href='?do=$do&p=$next'> > </a>";
                    }
                ?>
            </div>

            <table style="margin-top:40px; width:70%;">
                <tbody>
                    <tr>
                        <td width="200px">
                            <input type="button" onclick="op('#cover','#cvr','include/<?= $do; ?>.php')" value="新增校園映像資料">
                        </td>
                        <td class="cent">
                            <input type="submit" value="修改確定">
                            <input type="reset" value="重置">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</div>