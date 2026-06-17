<?php
session_start();

class DB{
    // 設定資料庫連線參數
    protected $dsn="mysql:host=localhost;charset=utf8;dbname=db21";
    protected $pdo;
    protected $table;

    // 建構子：初始化連線，並鎖定要操作的資料表 ($table)
    function __construct($table){
        $this->table=$table;
        $this->pdo=new PDO($this->dsn,'root','');
    }

    // 讀取所有資料：支援多種參數寫法
    function all(...$arg){
        $sql="SELECT * FROM $this->table ";
        // 處理第一個參數 (如果是陣列代表 WHERE 條件，如果是字串代表 SQL 片段)
        if(isset($arg[0])){
            if(is_array($arg[0])){
                $tmp=$this->a2s($arg[0]);
                $sql .= " WHERE ".join(" AND ",$tmp);
            }else{
                $sql .= $arg[0];
            }
        }
        // 處理第二個參數 (例如：排序 ORDER BY 或限制筆數 LIMIT)
        if(isset($arg[1])){
            $sql .= $arg[1];
        }
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // 計算筆數：邏輯與 all() 幾乎一樣，只是改為 SELECT count(*)
    function count(...$arg){
        $sql="SELECT count(*) FROM $this->table ";
        if(isset($arg[0])){
            if(is_array($arg[0])){
                $tmp=$this->a2s($arg[0]);
                $sql .= " WHERE ".join(" AND ",$tmp);
            }else{
                $sql .= $arg[0];
            }
        }
        if(isset($arg[1])){
            $sql .= $arg[1];
        }
        return $this->pdo->query($sql)->fetchColumn();
    }

    // 搜尋單筆資料：若傳入 id 則以 id 搜尋，否則以陣列條件搜尋
    function find($arg){
        $sql="SELECT * FROM $this->table ";
        if(is_array($arg)){
            $tmp=$this->a2s($arg);
            $sql .= " WHERE ".join(" AND ",$tmp);
        }else{
            $sql .= " WHERE `id`='$arg'";
        }
        return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    }

    // 新增或更新資料：自動判斷是否有 id，有的話 update，沒有則 insert
    function save($arg){
        if(isset($arg['id'])){
            // 更新 (Update)
            $tmp=$this->a2s($arg);
            $sql="UPDATE $this->table SET ".join(" , ",$tmp);
            $sql .=" WHERE `id`='{$arg['id']}'";
        }else{
            // 新增 (Insert)
            $keys=array_keys($arg);
            $sql="INSERT INTO $this->table (`".join("`,`",$keys)."`) VALUES('".join("','",$arg)."');";
        }
        echo $sql; // 除錯用，開發時可看到輸出的 SQL 指令
        return $this->pdo->exec($sql);
    }

    // 刪除資料
    function del($arg){
        $sql="DELETE FROM $this->table ";
        if(is_array($arg)){
            $tmp=$this->a2s($arg);
            $sql .= " WHERE ".join(" AND ",$tmp);
        }else{
            $sql .= " WHERE `id`='$arg'";
        }
        return $this->pdo->exec($sql);
    }

    // 輔助方法：將陣列轉為 SQL 語法格式 (例如：`key`='value')
    protected function a2s($array){
        $tmp=[];
        foreach($array as $key => $val){
            $tmp[]="`$key`='$val'";
        }
        return $tmp;
    }

    // 直接執行自訂 SQL 語法
    function q($sql){
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}

// 偵錯函式：將陣列以漂亮的格式印出
function dd($array){
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

// 頁面跳轉函式
function to($url){
    header("location:$url");
}

// 初始化：為每一張資料表建立一個對應的 DB 物件
$Title=new DB('title');
$Ad=new DB('ad');
$Mvim=new DB('mvim');
$Image=new DB('image');
$News=new DB('news');
$Admin=new DB('admin');
$Menu=new DB('menu');
$Total=new DB('total');
$Bottom=new DB('bottom');