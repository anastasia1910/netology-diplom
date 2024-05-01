const headers = Array.from(document.querySelectorAll('.conf-step__header'));
headers.forEach(header => header.addEventListener('click', () => {
  header.classList.toggle('conf-step__header_closed');
  header.classList.toggle('conf-step__header_opened');
}));

function showPopup(popupSelector) {
  const popup = document.querySelector(popupSelector);
  if (popup) {
    popup.classList.add('active');
  }
}

function hidePopup(popupSelector) {
  const popup = document.querySelector(popupSelector);
  if (popup) {
    popup.classList.remove('active');
  }
}