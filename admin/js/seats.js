function loadSeats(hallId) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `load_seats.php?hall_id=${hallId}`, true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            const seatLayoutDiv = document.getElementById('seat-layout');
            const rowsInput = document.getElementById('rows-input');
            const seatsInput = document.getElementById('seats-input');
            const responseText = xhr.responseText;

            if (responseText.trim() !== '') {
                seatLayoutDiv.innerHTML = responseText;
                addSeatClickListeners();

                const rows = seatLayoutDiv.querySelectorAll('.conf-step__row').length;
                const seats = seatLayoutDiv.querySelector('.conf-step__row').querySelectorAll('.conf-step__chair').length;
                rowsInput.value = rows;
                seatsInput.value = seats;
            } else {
                seatLayoutDiv.innerHTML = '';
                rowsInput.value = '';
                seatsInput.value = '';
            }
        } else {
            console.error('Error:', xhr.statusText);
        }
    };
    xhr.onerror = function () {
        console.error('Request failed');
    };
    xhr.send();
}

function addSeatClickListeners() {
    const seatsElements = document.querySelectorAll('.conf-step__chair');
    seatsElements.forEach((seatElement) => {
        seatElement.addEventListener('click', (e) => {
            const currentType = seatElement.getAttribute('data-seat-type');
            let newType;
            switch (currentType) {
                case 'standart':
                    newType = 'vip';
                    break;
                case 'vip':
                    newType = 'disabled';
                    break;
                case 'disabled':
                    newType = 'standart';
                    break;
            }
            seatElement.setAttribute('data-seat-type', newType);
            seatElement.className = `conf-step__chair conf-step__chair_${newType}`;
        });
    });
}

const rowsInput = document.getElementById('rows-input');
const seatsInput = document.getElementById('seats-input');
const seatLayoutDiv = document.getElementById('seat-layout');

rowsInput.addEventListener('input', generateSeatLayout);
seatsInput.addEventListener('input', generateSeatLayout);

function generateSeatLayout() {
    const rows = parseInt(rowsInput.value);
    const seats = parseInt(seatsInput.value);
    const hallId = document.querySelector('input[name="chairs-hall"]:checked').getAttribute('value');

    const seatLayout = [];
    for (let i = 0; i < rows; i++) {
        const row = [];
        for (let j = 0; j < seats; j++) {
            row.push({
                hall_id: hallId, row_num: i + 1, seat_num: j + 1, type: 'standart'
            });
        }
        seatLayout.push(row);
    }

    let seatLayoutHtml = [];
    seatLayoutHtml.push(`<div class="conf-step__hall">`);
    seatLayoutHtml.push(`<div class="conf-step__hall-wrapper">`);
    seatLayout.forEach((row, rowIndex) => {
        seatLayoutHtml.push(`<div class="conf-step__row">`);
        row.forEach((seat, seatIndex) => {
            if (seat.type === 'standart') {
                seatLayoutHtml.push(`<span class="conf-step__chair conf-step__chair_standart" data-seat-type="standart"></span>`);
            } else if (seat.type === 'vip') {
                seatLayoutHtml.push(`<span class="conf-step__chair conf-step__chair_vip" data-seat-type="vip"></span>`);
            } else {
                seatLayoutHtml.push(`<span class="conf-step__chair conf-step__chair_disabled" data-seat-type="disabled"></span>`);
            }
        });
        seatLayoutHtml.push(`</div>`);
    });
    seatLayoutHtml.push(`</div>`);
    seatLayoutHtml.push(`</div>`);
    seatLayoutHtml = seatLayoutHtml.join('');

    seatLayoutDiv.innerHTML = seatLayoutHtml;

    const seatsElements = seatLayoutDiv.querySelectorAll('.conf-step__chair');
    seatsElements.forEach((seatElement) => {
        seatElement.addEventListener('click', (e) => {
            const currentType = seatElement.getAttribute('data-seat-type');
            let newType;
            switch (currentType) {
                case 'standart':
                    newType = 'vip';
                    break;
                case 'vip':
                    newType = 'disabled';
                    break;
                case 'disabled':
                    newType = 'standart';
                    break;
            }
            seatElement.setAttribute('data-seat-type', newType);
            seatElement.className = `conf-step__chair conf-step__chair_${newType}`;
        });
    });
}

const saveButton = document.getElementById('save-button');

saveButton.addEventListener('click', (e) => {
    e.preventDefault();
    const rows = parseInt(rowsInput.value);
    const seats = parseInt(seatsInput.value);
    const hallId = document.querySelector('input[name="chairs-hall"]:checked').value;

    const seatLayoutData = [];
    const seatsElements = seatLayoutDiv.querySelectorAll('.conf-step__chair');
    seatsElements.forEach((seatElement, index) => {
        const seatType = seatElement.getAttribute('data-seat-type');
        const rowIndex = Math.floor(index / seats) + 1;
        const seatIndex = index % seats + 1;
        seatLayoutData.push({
            hall_id: hallId, row_num: rowIndex, seat_num: seatIndex, type: seatType
        });
    });

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'save_seats.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onload = function () {
        if (xhr.status === 200) {
            alert("Конфигурация залов успешно сохранена");
        } else {
            alert("Ошибка" + xhr.statusText);
        }
    };
    xhr.onerror = function () {
        console.error('Ошибка запроса');
    };
    xhr.send(JSON.stringify({seatLayoutData, hall_id: hallId}));
});