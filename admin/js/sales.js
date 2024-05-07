document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('openSaleButton').addEventListener('click', function (event) {
        event.preventDefault();

        const selectedHallId = document.querySelector('input[name="chairs-hall"]:checked').value;

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'hall_activity.php', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onload = function () {
            if (xhr.status === 200) {
                alert(xhr.responseText);
            } else {
                alert('Произошла ошибка при отправке запроса на сервер');
            }
        };
        xhr.send(JSON.stringify({ hall_id: selectedHallId }));
    });
});