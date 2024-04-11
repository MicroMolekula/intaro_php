<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Задание 3</title>
    <link rel="stylesheet" href="styles/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <main>
        <h4 class="mb-4">Обратная связь</h4>
        <form id="form" method="post">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">ФИО</label>
                <input type="text" class="form-control" id="name" placeholder="Иванов Иван Иванович">
                <div class="errors" id="error-name"></div>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Номер телефона</label>
                <input type="tel" class="form-control" id="phone" value="+7(___)___-__-__">
                <div class="errors" id="error-phone"></div>
                <script src="scripts/phone-validate.js"></script>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Адрес электронной почты</label>
                <input type="email" class="form-control" id="email" placeholder="name@example.com">
                <div class="errors" id="error-email"></div>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Комментарий</label>
                <textarea class="form-control" id="comment" rows="3"></textarea>
                <div class="errors" id="error-comment"></div>
            </div>
            <input class="btn btn-primary" type="button" value="Отправить" id="submit">
        </form>
        <div id="response" class="mt-3">

        </div>
    </main>
</body>
<script src="scripts/script.js"></script>
</html>