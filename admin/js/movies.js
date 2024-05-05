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
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'get_movies.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var moviesData = JSON.parse(xhr.responseText);
                    displayMovies(moviesData);
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
                    <img class="conf-step__movie-poster" alt="poster" src="${movie.poster}">
                    <h3 class="conf-step__movie-title">${movie.name}</h3>
                    <p class="conf-step__movie-duration">${movie.duration} минут</p>
                `;
                moviesContainer.appendChild(movieElement);
            });
        } else {
            console.log('No data available');
        }
    }


});
