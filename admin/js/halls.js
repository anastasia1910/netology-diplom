function addHall(event) {
    event.preventDefault();
    var formData = new FormData(document.getElementById("addHallForm"));
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "create_hall.php", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            document.getElementById("addHallForm").reset();
            hidePopup('#hall');
            updateHallsList();
        }
    };
    xhr.send(formData);
}


function updateHallsList() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "get_halls.php", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            var hallsList = document.querySelector(".conf-step__list");
            hallsList.innerHTML = "";
            response.forEach(function (hall) {
                var listItem = document.createElement("LI");
                listItem.textContent = hall.name;
                var deleteButton = document.createElement("BUTTON");
                deleteButton.className = "conf-step__button conf-step__button-trash";
                deleteButton.onclick = function () {
                    deleteHall(hall.id);
                };
                listItem.appendChild(deleteButton);
                hallsList.appendChild(listItem);
            });

            var radioButtonLists = document.querySelectorAll(".conf-step__selectors-box");

            radioButtonLists.forEach(function(radioButtonList) {
                radioButtonList.innerHTML = "";

                response.forEach(function(hall) {
                    var radioButtonListItem = document.createElement("LI");
                    var radioButton = document.createElement("INPUT");
                    radioButton.type = "radio";
                    radioButton.className = "conf-step__radio";
                    radioButton.name = "chairs-hall";
                    radioButton.value = hall.id;
                    var radioButtonLabel = document.createElement("SPAN");
                    radioButtonLabel.textContent = hall.name;
                    radioButtonLabel.className = "conf-step__selector";
                    radioButtonListItem.appendChild(radioButton);
                    radioButtonListItem.appendChild(radioButtonLabel);
                    radioButtonList.appendChild(radioButtonListItem);
                });
            });
        }
    };
    xhr.send();
}

document.getElementById("addHallForm").addEventListener("submit", addHall);

function deleteHall(id) {
    var confirmation = confirm("Вы уверены, что хотите удалить этот зал и все связанные с ним записи?");
    if (!confirmation) {
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'delete_hall.php?id=' + id, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            var halls = JSON.parse(xhr.responseText);
            updateHallsList();
            alert("Зал успешно удален!");
        }
    };
    xhr.send();
}

