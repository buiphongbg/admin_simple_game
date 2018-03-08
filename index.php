<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$total_topic = 3;
$topic_question = 9;

// Lay duong dan thu muc hien tai
$base_path = dirname(__FILE__);
$image_path = $base_path . DIRECTORY_SEPARATOR . 'Pic' . DIRECTORY_SEPARATOR;
$data_file_name = 'Questions_answers.json';

if ($_POST) {
    $data = [];
    // Xu ly upload anh
    foreach ($_POST['group'] as $index => $group) {
        if (!empty($_FILES['group']['name'][$index]['NameOfPic'])) {
            if (move_uploaded_file($_FILES['group']['tmp_name'][$index]['NameOfPic'], $image_path . $_FILES['group']['name'][$index]['NameOfPic'])) {
                $group['NameOfPic'] = 'Pic/' . $_FILES['group']['name'][$index]['NameOfPic'];
            }
        }
        $data[] = $group;
    }

    // Luu du lieu
    $data = json_encode($data);

    // Luu du lieu vao file
    file_put_contents($base_path . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . $data_file_name, $data);
}
// Xu ly hien thi du lieu
// Lay du lieu tu file json
$data = file_get_contents($base_path . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . $data_file_name);

if ($data) {
    $data = json_decode($data, true);
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
        .topic-wrapper { border: 1px solid #333; padding: 10px; margin-bottom: 15px;}
        .list-question-wrapper { margin-left: 15px;}
        .list-question-wrapper label { font-weight: 700; margin-bottom: 5px;}
        .question-wrapper { margin-left: 15px;}
    </style>
</head>
<body>
    <head>

    </head>
    <section>
        <form action="logout.php" method="post">
            <button type="submit">Logout</button>
        </form>
        <div class="wrapper">
            <div class="main-content">
                <form method="post" enctype="multipart/form-data">
                    <?php for($i = 0; $i < $total_topic; $i++) : ?>
                        <div class="topic-wrapper">
                            <h2>Chủ đề <?= $i + 1 ?></h2>
                            <p>Level: <input type="text" name="group[<?= $i ?>][Level]" value="<?= isset($data[$i]['Level']) ? $data[$i]['Level'] : '' ?>"/></p>
                            <input type="hidden" name="group[<?= $i ?>][NumOfCard]" value="<?= $topic_question ?>"/>
                            <p>Câu hỏi chủ đề: <input type="text" name="group[<?= $i ?>][TopicQuest]" value="<?= isset($data[$i]['TopicQuest']) ? $data[$i]['TopicQuest'] : '' ?>"/></p>
                            <p>Đáp án câu hỏi: <input type="text" name="group[<?= $i ?>][TopicAnswer]" value="<?= isset($data[$i]['TopicAnswer']) ? $data[$i]['TopicAnswer'] : '' ?>"/></p>
                            <p>
                                Hình ảnh: <input type="file" name="group[<?= $i ?>][NameOfPic]"/>
                                <?php if (!empty($data[$i]['NameOfPic'])) : ?>
                                <img src="<?= $data[$i]['NameOfPic'] ?>" height="70"/>
                                <?php endif; ?>
                            </p>
                            <h3>Danh sách câu hỏi:</h3>
                            <div class="list-question-wrapper">
                                <?php for($j = 0; $j < $topic_question; $j++) : ?>
                                    <label><?= $j + 1; ?>. Câu hỏi <?= $j + 1; ?>: </label>
                                    <div class="question-wrapper">
                                        <textarea name="group[<?= $i ?>][Questions][<?= $j ?>][quest]"><?= isset($data[$i]['Questions'][$j]['quest']) ? $data[$i]['Questions'][$j]['quest'] : '' ?></textarea>
                                        <p>Đáp án A: <input type="text" name="group[<?= $i ?>][Questions][<?= $j ?>][A]" value="<?= isset($data[$i]['Questions'][$j]['A']) ? $data[$i]['Questions'][$j]['A'] : '' ?>"/></p>
                                        <p>Đáp án B: <input type="text" name="group[<?= $i ?>][Questions][<?= $j ?>][B]" value="<?= isset($data[$i]['Questions'][$j]['B']) ? $data[$i]['Questions'][$j]['B'] : '' ?>"/></p>
                                        <p>Đáp án C: <input type="text" name="group[<?= $i ?>][Questions][<?= $j ?>][C]" value="<?= isset($data[$i]['Questions'][$j]['C']) ? $data[$i]['Questions'][$j]['C'] : '' ?>"/></p>
                                        <p>Đáp án D: <input type="text" name="group[<?= $i ?>][Questions][<?= $j ?>][D]" value="<?= isset($data[$i]['Questions'][$j]['D']) ? $data[$i]['Questions'][$j]['D'] : '' ?>"/></p>
                                        <p>Đáp án đúng:
                                            <select name="group[<?= $i ?>][Questions][<?= $j ?>][answer]" value="<?= isset($data[$i]['Questions'][$j]['answer']) ? $data[$i]['Questions'][$j]['answer'] : '' ?>">
                                                <option <?= isset($data[$i]['Questions'][$j]['answer']) && $data[$i]['Questions'][$j]['answer'] == 'A' ? 'selected' : ''?> value="A">A</option>
                                                <option <?= isset($data[$i]['Questions'][$j]['answer']) && $data[$i]['Questions'][$j]['answer'] == 'B' ? 'selected' : ''?> value="B">B</option>
                                                <option <?= isset($data[$i]['Questions'][$j]['answer']) && $data[$i]['Questions'][$j]['answer'] == 'C' ? 'selected' : ''?> value="C">C</option>
                                                <option <?= isset($data[$i]['Questions'][$j]['answer']) && $data[$i]['Questions'][$j]['answer'] == 'D' ? 'selected' : ''?> value="D">D</option>
                                            </select>
                                        </p>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                    <?php endfor; ?>
                    <div>
                        <button type="submit">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <footer>

    </footer>
</body>
</html>

