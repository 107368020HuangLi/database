<?php

//SQL 敘述: 取得 students 資料表總筆數
$sqlTotal = "SELECT count(1) FROM `item`";

//取得總筆數
$total = $pdo->query($sqlTotal)->fetch(PDO::FETCH_NUM)[0];

//每頁幾筆
$numPerPage = 5;

// 總頁數
$totalPages = ceil($total/$numPerPage); 

//目前第幾頁
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

//若 page 小於 1，則回傳 1
$page = $page < 1 ? 1 : $page;
?>
<!DOCTYPYE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>我的 PHP 程式</title>
    <style>
    .border {
        border: 1px solid;
    }
    .w200px {
        width: 200px;
    }
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
<?php require_once('./templates/title.php'); ?>
<hr />
<form name="myForm" method="POST" action="deleteIds.php">
    <table class="border">
        <thead>
            <tr>
                <th class="border">選擇</th>
                <th class="border">商品名稱</th>
                <th class="border">商品價錢</th>
                <th class="border">商品圖片</th>
            </tr>
        </thead>
        <tbody>
        <?php
        //SQL 敘述
        $sql = "SELECT `id`, `itemName`, `itemprice`,`itemImg`
                FROM `item` 
                ORDER BY `id` ASC 
                LIMIT ?, ? ";

        //設定繫結值
        $arrParam = [($page - 1) * $numPerPage, $numPerPage];

        //查詢分頁後的學生資料
        $stmt = $pdo->prepare($sql);
        $stmt->execute($arrParam);

        //資料數量大於 0，則列出所有資料
        if($stmt->rowCount() > 0) {
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
            for($i = 0; $i < count($arr); $i++) {
        ?>
            <tr>
                <td class="border">
                    <input type="checkbox" name="chk[]" value="<?php echo $arr[$i]['id']; ?>" />
                </td>
                <td class="border"><?php echo $arr[$i]['itemName']; ?></td>
                <td class="border"><?php echo $arr[$i]['itemprice']; ?></td>
                <td class="border"><?php echo $arr[$i]['itemImg']; ?></td>
                </td>
                <td class="border">
                <?php if($arr[$i]['itemImg'] !== NULL) { ?>
                    <img class="w200px" src="./photo/<?php echo $arr[$i]['itemImg']; ?>">
                <?php } ?>
                </td>
                <td class="border">
                    <a href="./edit.php?editId=<?php echo $arr[$i]['id']; ?>">編輯</a>
                    <a href="./delete.php?deleteId=<?php echo $arr[$i]['id']; ?>">刪除</a>
                </td>
            </tr>
        <?php
            }
        } else {
        ?>
            <tr>
                <td class="border" colspan="5">沒有資料</td>
            </tr>
        <?php
        }
        ?>
        </tbody>
        <tfoot>
            <tr>
                <td class="border" colspan="5">
                <?php for($i = 1; $i <= $totalPages; $i++){ ?>
                    <a href="?page=<?= $i ?>"><?= $i ?></a>
                <?php } ?>
                </td>
            </tr>
        </tfoot>
    </table>
    <input type="submit" name="smb" value="刪除">
</form>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>