document.addEventListener('DOMContentLoaded', function () {
    updateSeancesList();
    updateMoviesList();

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
        const pixelsPerMinute = 1.2;
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
                    console.log(data.message);
                } else {
                    console.error(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                console.error('Произошла ошибка при отправке запроса на сервер');
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
