<!--  登録者数分布 -->
<?php
// データベース接続
try {
    $pdo = new PDO('mysql:dbname=gs_daily_db;charset=utf8;host=localhost', 'root', '');
} catch (PDOException $e) {
    exit('DB_CONNECT:' . $e->getMessage());
}

// SQLクエリの実行
$sql = "SELECT COUNT(*) AS count FROM children";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

// クエリ実行の成功チェック
if ($status == false) {
    // エラーの場合はエラーメッセージを出力
    $error = $stmt->errorInfo();
    exit("QueryError:".$error[2]);
} else {
    // 成功の場合は結果を取得
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $count = $result['count']; // 登録者数
    // echo "登録者数: " . $count;
}

// 性別に応じた登録者数を取得
$sql = "SELECT gender, COUNT(*) AS count FROM children GROUP BY gender";
$stmt = $pdo->prepare($sql);
$stmt->execute();

$genderData = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $genderData[$row['gender']] = (int)$row['count'];
}

// データベース接続とクエリの実行

$stmt = $pdo->query($sql);
$sqlAgeGroups = "
SELECT
  CASE
    WHEN TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) BETWEEN 0 AND 2 THEN '0-2歳'
    WHEN TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) BETWEEN 3 AND 5 THEN '3-5歳'
    WHEN TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) BETWEEN 6 AND 12 THEN '6-12歳'
    WHEN TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) BETWEEN 13 AND 15 THEN '13-15歳'
    WHEN TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) BETWEEN 16 AND 18 THEN '16-18歳'
    ELSE 'それ以上'
  END AS age_group,
  COUNT(*) AS count
FROM children
GROUP BY age_group
";

$stmt = $pdo->prepare($sqlAgeGroups);
$stmt->execute();
$ageGroups = $stmt->fetchAll(PDO::FETCH_ASSOC);



?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>利用者比率グラフ</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
.counter {
    background-color: #f2f2f2;
    padding: 20px;
    margin-top: 20px;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    text-align: center;
}

.counter h3 {
    margin: 0;
    font-size: 24px;
    color: #333;
}

.counter p {
    margin: 5px 0 0;
    font-size: 16px;
    color: #666;
}
</style>

    <div class="counter">
    <h3>登録者数</h3>
    <p><?php echo $count; ?></p>
</div>
</head>
<body>

<div>
<canvas id="genderChart"></canvas>
</div>

<script>
// PHPから取得したデータをJavaScriptで利用する
var genderData = <?= json_encode($genderData); ?>;
var ctx = document.getElementById('genderChart').getContext('2d');
var genderChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: Object.keys(genderData),
        datasets: [{
            label: '性別比率',
            data: Object.values(genderData),
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)'
            ],
        //     borderColor: [
        //         'rgba(255,99,132,1)',
        //         'rgba(54, 162, 235, 1)',
        //         'rgba(255, 206, 86, 1)'
        //     ],
        //     borderWidth: 1
        }]
    },
    options: {
        maintainAspectRatio: false, // グラフのコンテナのサイズに合わせて、高さと幅の比率を保持しない
    aspectRatio: 1, // アスペクト比（幅/高さ）を指定
    responsive: true, // レスポンシブ対応を有効にする
    scales: {
        // y: {
        //     beginAtZero: true // Y軸のスケールが0から始まるように設定
        // }
    },
    plugins: {
        legend: {
            position: 'top', // 凡例を上部に配置
        },
        title: {
            display: true,
            text: '性別比率' // グラフのタイトルを設定
        }
    }
    },
});
</script>
<canvas id="ageGroupChart" width="300" height="100"></canvas>
<script>
var ctx = document.getElementById('ageGroupChart').getContext('2d');
var chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode(array_column($ageGroups, 'age_group')); ?>,
        datasets: [{
            label: '年齢範囲別の子供の数',
            data: <?php echo json_encode(array_column($ageGroups, 'count'), JSON_NUMERIC_CHECK); ?>,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)'
                // 他の色を追加
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)'
                // 他の色を追加
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
</body>
</html>
