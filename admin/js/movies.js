document.addEventListener('DOMContentLoaded', function () {
    updateMoviesList();
    let $movies = [];

    const addMovieForm = document.getElementById('addMovieForm');
    addMovieForm.addEventListener('submit', function (event) {
        event.preventDefault();
        const formData = new FormData(addMovieForm);
        fetch('add_movie.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.success) {
                    hidePopup('#film');
                    updateMoviesList();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Произошла ошибка при отправке запроса на сервер');
            });
    });

    function updateMoviesList() {
        var xhr = new XMLHttpRequest(); // Создаем новый объект XMLHttpRequest
        xhr.open('GET', 'get_movies.php', true); // Настраиваем запрос GET к файлу get_movies.php
        xhr.onreadystatechange = function() { // Устанавливаем обработчик события изменения состояния запроса
            if (xhr.readyState === XMLHttpRequest.DONE) { // Проверяем, что состояние запроса DONE (завершено)
                if (xhr.status === 200) { // Проверяем успешность запроса (статус 200 означает успех)
                    var moviesData = JSON.parse(xhr.responseText); // Парсим полученные данные в формате JSON
                    displayMovies(moviesData); // Вызываем функцию для отображения фильмов на странице
                } else {
                    console.error('Error:', xhr.statusText); // Выводим сообщение об ошибке в консоль
                }
            }
        };
        xhr.send(); // Отправляем запрос на сервер
    }

    function displayMovies(moviesData) {
        const moviesContainer = document.querySelector('.conf-step__movies'); // Находим контейнер для фильмов на странице
        moviesContainer.innerHTML = ''; // Очищаем содержимое контейнера

        if (Array.isArray(moviesData) && moviesData.length > 0) { // Проверяем, что данные являются массивом и содержат хотя бы один элемент
            moviesData.forEach(movie => { // Перебираем каждый элемент массива фильмов
                const movieElement = document.createElement('div'); // Создаем новый элемент div для каждого фильма
                movieElement.classList.add('conf-step__movie'); // Добавляем класс для стилизации
                movieElement.innerHTML = `
                    <img class="conf-step__movie-poster" alt="poster" src="${movie.poster}">
                    <h3 class="conf-step__movie-title">${movie.name}</h3>
                    <p class="conf-step__movie-duration">${movie.duration} минут</p>
                `;
                moviesContainer.appendChild(movieElement); // Добавляем элемент фильма в контейнер на странице
            });
        } else {
            console.log('No data available'); // Выводим сообщение в консоль, если данных нет или они пусты
        }
    }


});
