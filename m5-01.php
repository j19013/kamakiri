<html>
    <head>

        <meta charset="utf-8">
        <html lang="ja">
        <title>m3-05</title>
        <?php session_start();

        $dsn = 'データベース名';
        $user = 'ユーザー名';
        $password = 'パスワード';
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        ?>
    </head>
    <body>
        <form action="" method="post">

            <?php
                $f=0;
                if(!empty($_POST["comment3"])){
                    if($_POST["comment3"]!=""){

                        $id =$_POST["comment3"];
                        $pass =$_POST["pass3"];
                        $sql = 'SELECT * FROM mission';
                        $stmt = $pdo->query($sql);
                        $results = $stmt->fetchAll();
                        foreach ($results as $row){
                            //$rowの中にはテーブルのカラム名が入る
                            if($row['id']==$id &&$row['pass']==$pass){
                                $_SESSION["nam"] = $row['id'];
                                $_SESSION["pass3"] = $row['pass'];
                                $name_ed = $row['name'];
                                $com_ed = $row['comment'];
                                $pass_ed = $row['pass'];
                                $f=1;
                            }

                        }


                    }
                }
            ?>
            <?php if($f==1&&!empty($_POST["comment3"])):?>
            名前<input type="text" name="name_2" value=<?php echo $name_ed ?>>
            コメント<input type="text" name="comment4" value=<?php echo $com_ed ?>>
            パスワード<input type="text" name="pass4" value=<?php echo $pass_ed ?>>
            <input type="submit" name=but_4 value="送信"><br>

            <?php endif; ?>
            <?php  if($f==0):?>
            名前   <input type="text" name="name_1" >
            コメント<input type="text" name="comment" >
            パスワード<input type="text" name="pass" >
            <input type="submit" name=but_1 value="送信"><br>
            <?php endif;?>
        </form>
        <form action="" method="post"><br>
            番号<input type="text" name="comment2" >
            パスワード<input type="text" name="pass2" >
            <input type="submit" name=but_2 value="削除"><br>
        </form>
        <form action="" method="post"><br>
            番号<input type="text" name="comment3" >
            パスワード<input type="text" name="pass3" >
            <input type="submit" name=but_3 value="編集"><br>
        </form>
    </body>
</html>

<?php

    if(!empty($_POST["comment"])&&!empty($_POST["name_1"])&&!empty($_POST["pass"])){//登録処理
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

        $sql = "CREATE TABLE IF NOT EXISTS mission"
        ." ("
        . "id INT AUTO_INCREMENT PRIMARY KEY,"
        . "name char(32),"
        . "comment TEXT,"
        . "pass char(10),"
        . "day char(200)"
        .");";
        $stmt = $pdo->query($sql);


        $sql = $pdo -> prepare("INSERT INTO mission (name, comment, pass, day) VALUES (:name, :comment, :pass, :day)");
        $sql->bindParam(':name',$name, PDO::PARAM_STR);
        $sql->bindParam(':comment', $comment, PDO::PARAM_STR);
        $sql->bindParam(':pass', $pass, PDO::PARAM_STR);
        $sql->bindParam(':day', $date, PDO::PARAM_STR);
        $name = $_POST["name_1"];
        $comment = $_POST["comment"];
        $pass = $_POST["pass"];
        $date = date("Y-m-d");
        $sql->execute();


        //}


    }
if(!empty($_POST["comment2"])&&!empty($_POST["pass2"])){//削除処理
    if($_POST["comment2"]!=""&&$_POST["pass2"]!=""){
        $id = $_POST["comment2"];
        $pass = $_POST["pass2"];
        $sql = 'delete from mission where id=:id && pass=:pass';
        $sql = $pdo->prepare($sql);
        $sql->bindParam(':id', $id, PDO::PARAM_INT);
        $sql->bindParam(':pass', $pass, PDO::PARAM_STR);
        $sql->execute();
    }

}
if(!empty($_POST["comment4"])){//編集処理

    if($_POST["comment4"]!=""){
        $id = $_SESSION["nam"]; //変更する投稿番号
        $name = $_POST["name_2"];
        $comment = $_POST["comment4"];
        $pass = $_POST["pass4"];
        $date = date("Y-m-d");
        $sql = 'UPDATE mission SET name=:name,comment=:comment,pass=:pass,day=:day WHERE id=:id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
        $stmt->bindParam(':day', $date, PDO::PARAM_STR);
        $stmt->execute();

    }

}
echo "<hr>";
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    $sql = 'SELECT * FROM mission';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        //$rowの中にはテーブルのカラム名が入る
        echo $row['id'].',';
        echo $row['name'].',';
        echo $row['comment'].',';
        echo $row['pass'].",";
        echo $row['day'].'<br>';
        echo "<hr>";
    }


?>
