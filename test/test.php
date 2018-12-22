<?php

require __DIR__ . '/_config.php';

// Fake data
$count = 1000;

$pagination = new \yidas\data\Pagination([
    'totalCount' => $count,
]);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <div>
    <?=\yidas\widgets\Pagination::widget([
        'pagination' => $pagination,
        // 'view' => 'simple',
    ])?>
    </div>
</body>
</html>