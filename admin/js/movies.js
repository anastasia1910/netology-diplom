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
                    addMovieForm.reset();
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
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'get_movies.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var moviesData = JSON.parse(xhr.responseText);
                    displayMovies(moviesData);
                    setupDeleteButtons();
                } else {
                    console.error('Error:', xhr.statusText);
                }
            }
        };
        xhr.send();
    }

    function displayMovies(moviesData) {
        const moviesContainer = document.querySelector('.conf-step__movies');
        moviesContainer.innerHTML = '';

        if (Array.isArray(moviesData) && moviesData.length > 0) {
            moviesData.forEach(movie => {
                const movieElement = document.createElement('div');
                movieElement.classList.add('conf-step__movie');
                movieElement.innerHTML = `
                    <div>
                    <img class="conf-step__movie-poster" alt="poster" src="${movie.poster}">
                    <h3 class="conf-step__movie-title">${movie.name}</h3>
                    <p class="conf-step__movie-duration">${movie.duration} минут</p>
                    </div>
                    <div>
                    <button class="conf-step__button conf-step__button-trash" data-movie-id="${movie.id}"></button>
                    </div>
                `;
                moviesContainer.appendChild(movieElement);
            });
        } else {
            console.log('No data available');
        }
    }

    function setupDeleteButtons() {
        const deleteButtons = document.querySelectorAll('.conf-step__button-trash');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const movieId = this.dataset.movieId;
                if (confirm('Вы уверены, что хотите удалить этот фильм?')) {
                    deleteMovie(movieId);
                }
            });
        });
    }

    function deleteMovie(movieId) {
        fetch('delete_movie.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: movieId })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateMoviesList();
                    const event = new Event('movieDeleted');
                    document.dispatchEvent(event);
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Произошла ошибка при отправке запроса на сервер');
            });
    }

});
