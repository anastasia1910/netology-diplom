document.addEventListener('DOMContentLoaded', function () {
    updateSeancesList();
    updateMoviesList();

    function displayMovies(moviesData) {
        const selectElement = document.querySelector('.conf-step__input[name="movie_id"]'); // Находим элемент <select> по его имени

        selectElement.innerHTML = ''; // Очищаем содержимое элемента <select>

        const defaultOption = document.createElement('option'); // Создаем элемент <option> для дефолтного значения
        defaultOption.value = ''; // Задаем значение дефолтной опции пустым
        defaultOption.textContent = 'Выберите фильм'; // Задаем текст дефолтной опции
        selectElement.appendChild(defaultOption); // Добавляем дефолтную опцию в список

        // Перебираем каждый фильм из полученных данных
        moviesData.forEach(movie => {
            const optionElement = document.createElement('option'); // Создаем элемент <option> для каждого фильма
            optionElement.value = movie.id; // Задаем значение опции равное идентификатору фильма
            optionElement.textContent = movie.name; // Задаем текст опции равный названию фильма
            selectElement.appendChild(optionElement); // Добавляем опцию в список
        });
    }

    function updateSeancesList() {
        fetch('get_seances.php')
            .then(response => response.json())
            .then(data => {
                const seancesContainers = document.querySelectorAll('.conf-step__seances-hall');
                seancesContainers.forEach(seanceContainer => {
                    seanceContainer.querySelector('.conf-step__seances-timeline').innerHTML = ''; // Очищаем текущий список сеансов для каждого зала
                });

                data.sort((a, b) => {
                    return a.start_time.localeCompare(b.start_time);
                });

                const maxDuration = Math.max(...data.map(seance => seance.duration));

                data.forEach((seance, index) => {
                    const hallId = seance.hall_id;
                    const seanceElement = document.createElement('div');
                    seanceElement.classList.add('conf-step__seances-movie');
                    const getSeanceStart = (time) => {
                        const [hours, minutes] = time.split(':');
                        return `${hours}:${minutes}`;
                    }
                    const width = calculateWidth(seance.duration, maxDuration);
                    seanceElement.style.width = `${width}px`;

                    const marginLeft = calculateMarginLeft(seance.start_time);
                    seanceElement.style.marginLeft = `${marginLeft}px`;

                    seanceElement.innerHTML = `
                <p class="conf-step__seances-movie-title">${seance.movie_name}</p>
                <p class="conf-step__seances-movie-start">${getSeanceStart(seance.start_time)}</p>
            `;

                    const seanceContainer = document.querySelector(`.conf-step__seances-hall[data-hall-id="${hallId}"]`);
                    const timeline = seanceContainer.querySelector('.conf-step__seances-timeline');
                    timeline.appendChild(seanceElement);
                });
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Произошла ошибка при получении списка сеансов');
            });
    }

    function calculateMarginLeft(startTime) {
        const [hours, minutes] = startTime.split(':').map(Number);
        const startMinutes = hours * 60 + minutes;
        const baseStartTime = 8 * 60;
        const pixelsPerMinute = 1.2; // Уточним коэффициент для преобразования минут в пиксели
        const marginLeft = (startMinutes - baseStartTime) * pixelsPerMinute;
        return marginLeft;
    }

    function calculateWidth(duration, maxDuration) {
        const maxWidth = 240;
        return (duration / maxDuration) * maxWidth;
    }

    updateSeancesList();

    const form = document.getElementById('addSeanceForm');

    form.addEventListener('submit', function (event) {
        event.preventDefault();

        const formData = new FormData(form);

        fetch('add_seance.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    hidePopup('#seance');
                    updateSeancesList();
                    console.log(data.message); // log the message to the console instead of alert
                } else {
                    console.error(data.message); // log the error message to the console instead of alert
                }
            })
            .catch(error => {
                console.error('Error:', error);
                console.error('Произошла ошибка при отправке запроса на сервер'); // log the error message to the console instead of alert
            });
    });

    function updateMoviesList() {
        fetch('get_movies.php')
            .then(response => response.json())
            .then(moviesData => {
                displayMovies(moviesData);
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Произошла ошибка при получении списка фильмов');
            });
    }
});
