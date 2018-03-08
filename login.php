<?php
// 12345687
session_start();

$error = '';
if ($_POST) {
    if (isset($_POST['user_name']) && isset($_POST['password'])) {
        if ($_POST['user_name'] == 'administrator' && md5($_POST['password']) == '95d47be0d380a7cd3bb5bbe78e8bed49') {
            $_SESSION['user'] = $_POST['user_name'];
            header('Location: admin.php');
            exit();
        } else {
            $error = 'Tên đăng nhập hoặc tài khoản không đúng';
        }
    } else {
        $error = 'Vui lòng nhập tên đăng nhập và mật khẩu';
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Admin-Game</title>

        <!-- Styles -->
        <style>
            .wrapper { width: 1190px; margin: 0 auto;}
            input, textarea { width: 100%; display: block; padding: 3px 5px;}
            textarea { min-height: 50px;}
            h2, h3 { margin: 0 0 10px;}
            .error-message { color: red; margin-bottom: 10px;}
        </style>
    </head>
    <body>
        <div style="width: 600px; margin: 0 auto;">
            <form method="post">
                <div class="error-message">
                    <?= $error ?>
                </div>
                <div>
                    <label>Tên đăng nhập:</label>
                    <input type="text" name="user_name"/>
                </div>
                <div>
                    <label>Mật khẩu:</label>
                    <input type="password" name="password"/>
                </div>
                <div>
                    <button type="submit">Đăng nhập</button>
                </div>
            </form>
        </div>
    </body>
</html>