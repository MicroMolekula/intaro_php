let submitForm = document.getElementById("submit");
let form = document.getElementById("form");
let responseDiv = document.getElementById('response');
let errorsDiv = [
    document.getElementById("error-name"),
    document.getElementById("error-phone"),
    document.getElementById("error-email"),
    document.getElementById("error-comment")
];

function procRequest(data) {
    console.log(data);
    let htmlResponse;
    if(data['message'] == 'ok') {
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
    else if (data['message'] == 'fail') {
        htmlResponse = `<div>Ошибка, повторить отправку можно будет после ${data['date'].trim("\'")}</div>`;  
        responseDiv.innerHTML = htmlResponse;
    }
}

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
    let jsonData = JSON.stringify({
        "name": data['name'],
        "phone": data['phone'],
        "email": data['email'],
        "comment": data['comment']
    });
    xhttp.send(jsonData);
}


submitForm.addEventListener("click", function () {
    let valuesForm = {};
    let validate = Array(4).fill(true);
    let errors = Array(4).fill("");
    Array.from(form.elements).forEach(function (element) {
        if(element.id !== "submit"){
            let val;
            switch (element.id) {
                case "name":
                    val = element.value
                    validate[0] = val.search(/^[А-я]+ [А-я]+ [А-я]+$/g) !== -1;
                    errors[0] = validate[0] ? "" : "Некорректное ФИО";
                    valuesForm[element.id] = val;
                    return;
                case "phone":
                    val = element.value.replace(/\D+/g, "").split("").splice(1).join("");
                    validate[1] = val.search(/\d{10}/g) !== -1;
                    errors[1] = validate[1] ? "" : "Некорректный номер телефона";
                    valuesForm[element.id] = val;
                    return;
                case "email":
                    val = element.value
                    validate[2] = val.search(/^(^[a-zA-Z0-9][a-zA-Z0-9_]{3,29})@([a-zA-Z]{2,30})\.([a-z]{2,10})$/g) !== -1;
                    errors[2] = validate[2] ? "" : "Некорректный адрес электронной почты";
                    valuesForm[element.id] = val;
                    return;
                case "comment":
                    val = element.value;
                    validate[3] = val.search(/^(?!\s+$)[\w\W]+/) !== -1;
                    errors[3] = validate[3] ? "" : "Комментарий не должен быть пустым";
                    valuesForm[element.id] = val;
                    return;
            }
        }
    })
    for (let i = 0; i < errorsDiv.length; i++){
        errorsDiv[i].innerText = errors[i];
    }
    if(validate.indexOf(false) === -1){
        errors = Array(errors.length).fill("");
        ajax(valuesForm);
    }
    else {
        console.log("Errors");
    }
});

