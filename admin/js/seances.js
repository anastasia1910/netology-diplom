document.addEventListener('DOMContentLoaded', function () {
    updateSeancesList();
    updateMoviesList();

    document.addEventListener('movieDeleted', function() {
        updateSeancesList();
        updateMoviesList();
    });

    function displayMovies(moviesData) {
        const selectElement = document.querySelector('.conf-step__input[name="movie_id"]');

        selectElement.innerHTML = '';

        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = 'Выберите фильм';
        selectElement.appendChild(defaultOption);

        moviesData.forEach(movie => {
            const optionElement = document.createElement('option');
            optionElement.value = movie.id;
            optionElement.textContent = movie.name;
            selectElement.appendChild(optionElement);
        });
    }

    function updateSeancesList() {
        fetch('get_seances.php')
            .then(response => response.json())
            .then(data => {
                const seancesContainers = document.querySelectorAll('.conf-step__seances-hall');
                seancesContainers.forEach(seanceContainer => {
                    seanceContainer.querySelector('.conf-step__seances-timeline').innerHTML = '';
                });

                data.sort((a, b) => {
                    return a.start_time.localeCompare(b.start_time);
                });

                const seanceTimeline = document.querySelector('.conf-step__seances-timeline');
                const timelineWidth = seanceTimeline.offsetWidth;

                const hourWidth = timelineWidth / 16;

                data.forEach((seance, index) => {
                    const hallId = seance.hall_id;
                    const seanceElement = document.createElement('div');
                    seanceElement.classList.add('conf-step__seances-movie');

                    const width = calculateWidth(seance.duration, hourWidth);
                    const marginLeft = calculateMarginLeft(seance.start_time, hourWidth);

                    seanceElement.style.width = `${width}px`;
                    seanceElement.style.marginLeft = `${marginLeft}px`;

                    seanceElement.innerHTML = `
        <p class="conf-step__seances-movie-title">${seance.movie_name}</p>
        <p class="conf-step__seances-movie-start">${seance.start_time}</p>
        <span class="conf-step__seances-movie-delete" data-seance-id="${seance.id}">❌</span>
    `;

                    const deleteButton = seanceElement.querySelector('.conf-step__seances-movie-delete');
                    deleteButton.addEventListener('click', () => {
                        deleteSeance(seance.id);
                    });

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

    function deleteSeance(seanceId) {
        if (confirm('Вы уверены, что хотите удалить этот сеанс?')) {
            fetch('delete_seance.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ seance_id: seanceId })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateSeancesList();
                        alert(data.message);
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    console.error('Произошла ошибка при отправке запроса на сервер');
                });
        }
    }




    function calculateMarginLeft(startTime, hourWidth) {
        const [hours, minutes] = startTime.split(':').map(Number);
        const startMinutes = hours * 60 + minutes;
        const baseStartTime = 8 * 60; // Начало отсчета с 08:00
        const marginLeft = (startMinutes - baseStartTime) / 60 * hourWidth;
        return marginLeft;
    }

    function calculateWidth(duration, hourWidth) {
        return (duration / 60) * hourWidth; // Продолжительность в минутах, преобразуем в ширину блока
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
                    console.log(data.message);
                    // Очистка полей формы после успешной отправки
                    form.reset();
                } else {
                    console.error(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                console.error('Произошла ошибка при отправке запроса на сервер');
            });
    });

    const startTimeInput = document.querySelector('.conf-step__input[name="start_time"]');
    startTimeInput.addEventListener('blur', function() {
        const startTime = this.value;
        const startTimeParts = startTime.split(':');
        const hours = parseInt(startTimeParts[0], 10);
        if (hours < 8 || hours >= 23) {
            alert('Время начала сеанса должно быть в диапазоне от 08:00 до 23:00');
            this.value = '';
        }
    });

    startTimeInput.addEventListener('input', function() {
        // Ограничение на ввод только цифр и двоеточия
        this.value = this.value.replace(/[^\d:]/g, '');
        // Ограничение на количество символов
        if (this.value.length > 5) {
            this.value = this.value.slice(0, 5);
        }
        // Автоматическая вставка двоеточия после ввода двух цифр в часах
        if (this.value.length === 2 && !this.value.includes(':')) {
            this.value += ':';
        }
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
