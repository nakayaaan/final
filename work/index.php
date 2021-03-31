<?php

$dataFile = 'bbs.dat';


session_start();

function setToken() {
    $token = sha1(uniqid(mt_rand(), true));
    $_SESSION['token'] = $token;
}

function checkToken() {
    if (empty($_SESSION['token']) || ($_SESSION['token'] != $_POST['token'])) {
        echo "不正なPOSTが行われました！";
        exit;
    }
}

function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && 
    isset($_POST['message']) &&
    isset($_POST['user'])) {

    checkToken();

    $message = trim($_POST['message']);
    $user = trim($_POST['user']);

    if ($message !== '') {
        
        $user = ($user === '') ? 'ななしさん' : $user;

        $message = str_replace("\t", ' ', $message);
        $user = str_replace("\t", ' ', $user);

        $postedAt = date('Y-m-d H:i:s');

        $newData = $message . "\t" . $user . "\t" . $postedAt. "\n";

        $fp = fopen($dataFile, 'a');
        fwrite($fp, $newData);
        fclose($fp);
    }
} else {
    setToken();
}

$posts = file($dataFile, FILE_IGNORE_NEW_LINES);

$posts = array_reverse($posts);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>シンプル掲示板</title>
 
  <style>
      h1 {border-bottom: solid red;

  color: blue;
}
body{
  text-align: center;
}

      </style>
  
</head>
<body>


<h1>シンプル掲示板</h1>
    <form action="" method="post" autocomplete="off">
        message: <input type="text" name="message">
        user: <input type="text" name="user">
        <input type="submit" value="投稿">
        <input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
    </form>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.3.1/p5.min.js" integrity="sha512-gQVBYBvfC+uyor5Teonjr9nmY1bN+DlOCezkhzg4ShpC5q81ogvFsr5IV4xXAj6HEtG7M1Pb2JCha97tVFItYQ==" crossorigin="anonymous"></script>
    <script src="myscript.js"></script>
    
    <h2>投稿一覧（<?php echo count($posts); ?>件）</h2>
    <ul>
        <?php if (count($posts)) : ?>
            <?php foreach ($posts as $post) : ?>
            <?php list($message, $user, $postedAt) = explode("\t", $post); ?>
                <li><?php echo h($message); ?> (<?php echo h($user); ?>) - <?php echo h($postedAt); ?></li>
            <?php endforeach; ?>
        <?php else : ?>
            <li>まだ投稿はありません。</li>
        <?php endif; ?>
    </ul>

    <!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/8.3.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.1/firebase-firestore.js"></script>
<script src="firebase.js"></script>
</body>
</html>