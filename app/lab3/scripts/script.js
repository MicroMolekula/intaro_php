let submitForm = document.getElementById("submit");
let form = document.getElementById("form");
let responseDiv = document.getElementById('response');
let errorsDiv = [
    document.getElementById("error-name"),
    document.getElementById("error-phone"),
    document.getElementById("error-email"),
    document.getElementById("error-comment")
];

// Функция обработки ответа на запрос
function procRequest(data) {
    console.log(data);
    // Переменная с ответом для пользователя
    let htmlResponse;
    // Проверка ответа запроса
    if(data['message'] === 'ok') {
        htmlResponse = `
        <div><b>Отправлено сообщение из формы обратной связи</b></div>
        <div><b>Имя:</b> ${data['name']}</div>
        <div><b>Фамилия:</b> ${data['surname']}</div>
        <div><b>Отчество:</b> ${data['middle_name']}</div>
        <div><b>E-mail:</b> ${data['email']}</div>
        <div><b>Телефон:</b> ${data['phone']}</div>
        <div>С вами свяжутся после <b>${data['date']}</b></div>
        `;  
        responseDiv.innerHTML = htmlResponse;
    }
    // Если случилась ошибка на сервере
    else if (data['message'] === 'fail') {
        htmlResponse = `<div>Ошибка, повторить отправку можно будет после ${data['date'].trim("\'")}</div>`;  
        responseDiv.innerHTML = htmlResponse;
    }
}

// Функция реализация ajax запроса
function ajax(data){
    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            procRequest(this.response);
        }
    };


    xhttp.open("POST", "http://localhost:888/lab3/php/form.php", true);
    xhttp.responseType = "json";
    xhttp.setRequestHeader("Accept", "application/json");
    // Создание Json для запроса
    let jsonData = JSON.stringify({
        "name": data['name'],
        "phone": data['phone'],
        "email": data['email'],
        "comment": data['comment']
    });
    // Отправка запроса
    xhttp.send(jsonData);
}

// Прослушиватель событий для кнопки "Отправить"
submitForm.addEventListener("click", function () {
    // Переменная для сбора данных из формы
    let valuesForm = {};
    // Массив флагов, который показывает какое поле не прошло валидацию
    let validate = Array(4).fill(true);
    // Массив для собрания ошибок валидаций
    let errors = Array(4).fill("");
    //  Процесс валидации
    Array.from(form.elements).forEach(function (element) {
        if(element.id !== "submit"){
            let val;
            switch (element.id) {
                // Валидации ФИО, проверка на кириллицу
                case "name":
                    val = element.value
                    validate[0] = val.search(/^[А-я]+ [А-я]+ [А-я]+$/g) !== -1;
                    errors[0] = validate[0] ? "" : "Некорректное ФИО";
                    valuesForm[element.id] = val;
                    return;
                // Валидация номера телефона, больше в файле phone-validate.js
                case "phone":
                    val = element.value.replace(/\D+/g, "").split("").splice(1).join("");
                    validate[1] = val.search(/\d{10}/g) !== -1;
                    errors[1] = validate[1] ? "" : "Некорректный номер телефона";
                    valuesForm[element.id] = val;
                    return;
                // Валидация адреса электронной почты
                case "email":
                    val = element.value
                    validate[2] = val.search(/^(^[a-zA-Z0-9][a-zA-Z0-9_]{3,29})@([a-zA-Z]{2,30})\.([a-z]{2,10})$/g) !== -1;
                    errors[2] = validate[2] ? "" : "Некорректный адрес электронной почты";
                    valuesForm[element.id] = val;
                    return;
                // Валидация сообщения
                case "comment":
                    val = element.value;
                    validate[3] = val.search(/^(?!\s+$)[\w\W]+/) !== -1;
                    errors[3] = validate[3] ? "" : "Комментарий не должен быть пустым";
                    valuesForm[element.id] = val;
                    return;
            }
        }
    })
    // Вывод ошибок на экран
    for (let i = 0; i < errorsDiv.length; i++){
        errorsDiv[i].innerText = errors[i];
    }
    // Проверка есть ли ошибки в валидации
    if(validate.indexOf(false) === -1){
        //  Очистка ошибок валидации
        errors = Array(errors.length).fill("");
        // Отправка запроса
        ajax(valuesForm);
    }
    else {
        console.log("Errors");
    }
});

