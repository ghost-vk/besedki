<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex" />
    <title>404 - Страница не найдена</title>
</head>
<body>
<style>
    .pageNotFound {
        text-align: center;
        font-family: "Helvetica";
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    h1 {
        font-size: 30px;
        margin-bottom: 20px;
    }
    p {
        font-size: 18px;
        margin-bottom: 10px;
    }
</style>
<div class="pageNotFound">
    <h1>Ошибка 404</h1>
    <p>Страница не найдена</p>
    <a href="<?php echo home_url(); ?>">Вернуться на главную</a>
</div>
</body>
</html>