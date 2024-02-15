<!-- 24週目 -->
<?php
    require('../dbconnect.php');
    $questions = $dbh->query("SELECT * FROM quiz")->fetchAll(PDO::FETCH_ASSOC);
    $choices = $dbh->query("SELECT * FROM quiz_answers")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($questions as $qKey => $question) {
        $question["choices"] = [];
        foreach ($choices as $cKey => $choice) {
            if ($choice["question_id"] == $question["id"]) {
                $question["choices"][] = $choice;
            }
        }
        $questions[$qKey] = $question;
    }
    // var_dump($questions)


    $is_empty = count($questions) === 0;

    if (!isset($_SESSION['id'])) {
        // header('Location: /admin/auth/signin.php');
    } else {
        if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
        }
        $questions = $dbh->query("SELECT * FROM quiz")->fetchAll();
        $is_empty = count($questions) === 0;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $dbh->beginTransaction();

            // 削除する問題の画像ファイル名を取得
            $sql = "SELECT image FROM quiz WHERE id = :id";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(":id", $_POST["id"]);
            $stmt->execute();
            $question = $stmt->fetch();
            $image_name = $question['image'];

            // 画像ファイルが存在する場合、削除する
            if ($image_name) {
            $image_path = __DIR__ . '/../assets/img/quiz/' . $image_name;
            if (file_exists($image_path)) {
                unlink($image_path);
            }
            }

            // 問題と選択肢をデータベースから削除
            $sql = "DELETE FROM choices WHERE question_id = :question_id";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(":question_id", $_POST["id"]);
            $stmt->execute();

            $sql = "DELETE FROM quiz WHERE id = :id";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(":id", $_POST["id"]);
            $stmt->execute();

            $dbh->commit();
            $_SESSION['message'] = "問題削除に成功しました。";
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        } catch (PDOException $e) {
            $dbh->rollBack();
            $_SESSION['message'] = "問題削除に失敗しました。";
            error_log($e->getMessage());
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>


<header>

<div>
    <form method="POST" action="../admin/auth/signin.php">
        <input type="submit" value="ログアウト" class="submit"/>
    </form>
</div>

</header>
<main>
    <!-- <?php for ($i=0; $i < count($questions); $i++){?>
        <p>
            <?= $questions[$i]["id"]?>
        </p>
        <p>
            <a href="./questions/edit.php?id=<?= $questions[$i]["id"] ?>"><?=$questions[$i]["content"]?></a>
        </p>
    <?php } ?>
    <td>
        <form method="POST">
            <input type="hidden" value="<?= $question["id"] ?>" name="id">
            <input type="submit" value="削除" class="submit">
                    </form>
    </td>
    </form> -->
    <div>
        <div>
            <ul>
                <li>ユーザー招待</li>
                <li><a href="http://localhost:8080/admin/index.php">問題一覧</a></li>
                <li><a href="http://localhost:8080/admin/questions/create.php">問題作成</a></li>
            </ul>
        </div>
    </div>



    <div class="container">
        <h1 class="mb-4">問題一覧</h1>
        <?php if (isset($message)) { ?>
        <p><?= $message ?></p>
        <?php } ?>
        <?php if (!$is_empty) { ?>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>問題</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($questions as $question) { ?>
                <tr id="question-<?= $question["id"] ?>">
                <td><?= $question["id"]; ?></td>
                <td>
                    <a href="./questions/edit.php?id=<?= $question["id"] ?>">
                    <?= $question["content"]; ?>
                    </a>
                </td>
                <td>
                    <form method="POST">
                    <input type="hidden" value="<?= $question["id"] ?>" name="id">
                    <input type="submit" value="削除" class="submit">
                    </form>
                </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <?php } else { ?>
        問題がありません。
        <?php } ?>
    </div>








</main>
<footer></footer>
</body>
</html>