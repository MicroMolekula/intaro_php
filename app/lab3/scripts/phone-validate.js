let inputPhone=document.getElementById("phone");
inputPhone.oninput=()=>phoneMask(inputPhone)
// Функция для маски на поле для ввода телефона
function phoneMask(inputEl) {
    // Разбиваем строку на символы
    let patStringArr = "+7(___)___-__-__".split('');
    // Массив для позиций коретки в input
    let arrPush = [3, 4, 5, 7, 8, 9, 11, 12, 14, 15]
    // Введенная строка
    let val = inputEl.value;
    // Получаем цифры из номера телефона и удаляем первую цифру 7
    let arr = val.replace(/\D+/g, "").split('').splice(1);
    let n;
    let ni;
    arr.forEach((s, i) => {
        n = arrPush[i];
        patStringArr[n] = s
        ni = i
    });
    // Проверка размера номера телефона, если он меньше 10, то будет подсвечиваться красным иначе зеленным
    arr.length < 10 ? inputEl.style.color = 'red' : inputEl.style.color = 'green';
    // Собираем строку с цифрами и символами
    inputEl.value = patStringArr.join('');
    // Указываем позицию для коретки ввода
    n ? inputEl.setSelectionRange(n + 1, n + 1) : inputEl.setSelectionRange(17, 17)
}