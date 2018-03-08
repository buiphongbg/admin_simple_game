<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Lay duong dan thu muc hien tai
$base_path = dirname(__FILE__);
$data_file_name = 'Question_ABCD_answer.json';

if ($_POST) {
    // Luu du lieu
    $data = json_encode($_POST);

    // Luu du lieu vao file
    file_put_contents($base_path . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . $data_file_name, $data);
} else {
    // Xu ly hien thi du lieu
    // Lay du lieu tu file json
    $data = file_get_contents($base_path . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . $data_file_name);

    if ($data) {
        $data = json_decode($data);
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
    </style>
</head>
<body>
    <head>

    </head>
    <section>
        <div class="wrapper">
            <div class="left-side-bar">

            </div>
            <div class="main-content">
                <form method="post">
                    <?php if (!empty($data)) : ?>
                        <?php $index = 0; ?>
                        <?php foreach ($data as $group) : ?>
                            <div>
                                <h2>Chủ đề <?= $index + 1 ?></h2>
                                <p>Level: <input type="text" name="group[<?= $index ?>][Level]" value="<?= $group->Level ?>"/></p>
                                <p>Số lượng thẻ: <input type="text" name="group[<?= $index ?>][NumOfCard]" value="<?= $group->NumOfCard ?>"/></p>
                                <p>Câu hỏi chủ đề: <input type="text" name="group[<?= $index ?>][TopicQuest]" value="<?= $group->TopicQuest ?>"/></p>
                                <p>Đáp án câu hỏi: <input type="text" name="group[<?= $index ?>][TopicAnswer]" value="<?= $group->TopicAnswer ?>"/></p>
                                <p>Hình ảnh: <input type="file" name="group[<?= $index ?>][NameOfPic]"/></p>
                                <h3>Danh sách câu hỏi:</h3>
                                <?php if ($group->Question_ABCDs) : ?>
                                    <?php $question_index = 0; ?>
                                    <div>
                                        <?php foreach ($group->Question_ABCDs as $question) : ?>
                                            <div>
                                                <label>Câu hỏi: </label>
                                                <textarea name="group[<?= $index ?>][Question_ABCDs][<?= $question_index ?>][quest]"><?= $question->quest ?></textarea>
                                                <p>Đáp án A: <input type="text" name="group[<?= $index ?>][Question_ABCDs][<?= $question_index ?>][A]" value="<?= $question->A ?>"/></p>
                                                <p>Đáp án B: <input type="text" name="group[<?= $index ?>][Question_ABCDs][<?= $question_index ?>][B]" value="<?= $question->B ?>"/></p>
                                                <p>Đáp án C: <input type="text" name="group[<?= $index ?>][Question_ABCDs][<?= $question_index ?>][C]" value="<?= $question->C ?>"/></p>
                                                <p>Đáp án D: <input type="text" name="group[<?= $index ?>][Question_ABCDs][<?= $question_index ?>][D]" value="<?= $question->D ?>"/></p>
                                                <p>Đáp án đúng: <input type="text" name="group[<?= $index ?>][Question_ABCDs][<?= $question_index ?>][answer]" value="<?= $question->answer ?>"/></p>
                                            </div>
                                            <?php $question_index++; ?>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php $index++; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
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

