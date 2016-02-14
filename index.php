<?php

$name = ''; //お名前
$title = ''; //件名
$email = ''; //メールアドレス
$message = ''; //本文

//エラーメッセージ
$errors = array('name'=>'',
                'title'=>'',
                'email'=>'',
                'message'=>''
                );

//エスケープ関数
function h($s){
  return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}

//カンマの全角変換関数
function c_replace($s){
    return preg_replace("/,/", "，", $s);
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    //フォーム入力値の取得
    $name = $_POST['name'];
    $title = $_POST['title'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    //バリデーション
    if($name == ''){
        $errors['name'] = '名前が未入力です';
    }

    if($title == ''){
        $errors['title'] = '件名が未入力です';
    }

    if($email == ''){
        $errors['email'] = 'メールアドレスが未入力です';
    }

    if($message == ''){
        $errors['message'] = '本文が未入力です';
    }

    //バリデーション突破後処理
    if(empty($errors['name']) && empty($errors['title']) &&
        empty($errors['email']) && empty($errors['message'])){

        $fileName = "contact.csv";

        //1行データの生成
        $data = date("Y/m/d H:i") . ",". c_replace($name) . ",". c_replace($title) . "," . c_replace($email) . "," . c_replace($message) . ",\n";

        //ファイルオープン
        $fp = fopen($fileName, "a");

        //ファイルにデータを書き込む
        if(fwrite($fp, $data) === false)
        {
          echo "書き込みができませんでした。";
          exit;
        }

        //ファイルを閉じる
        fclose($fp);

        //画面遷移
        header('Location: thanks.php');
        exit;
    }


}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>お問い合わせフォーム</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <h1>お問い合わせフォーム</h1>
        <form action="" method="post">
        <table>
            <tr>
                <th>お名前</th>
                <td>
                    <input type="text" name="name" value="<?php echo h($name) ?>">
                    <?php if($errors['name']) : ?>
                        <br>
                        <span><?php echo h($errors['name']) ?></span>
                    <?php endif ?>
                </td>
            </tr>
            <tr>
                <th>件名</th>
                <td>
                    <input type="text" name="title" value="<?php echo h($title) ?>">
                    <?php if($errors['title']) : ?>
                        <br>
                        <span><?php echo h($errors['title']) ?></span>
                    <?php endif ?>
                </td>
            </tr>
            <tr>
                <th>メールアドレス</th>
                <td>
                    <input type="text" name="email" value="<?php echo h($email) ?>">
                    <?php if($errors['email']) : ?>
                        <br>
                        <span><?php echo h($errors['email']) ?></span>
                    <?php endif ?>
                </td>
            </tr>
            <tr>
                <th>本文</th>
                <td>
                    <textarea name="message" cols="40" rows="5"><?php echo h($message) ?></textarea>
                    <?php if($errors['message']) : ?>
                        <br>
                        <span><?php echo h($errors['message']) ?></span>
                    <?php endif ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="submit" value="送信">
                </td>
            </tr>
        </table>
        </form>
    </body>
</html>
