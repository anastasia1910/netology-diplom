document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('save-button-price').addEventListener('click', function (event) {
        event.preventDefault();

        const standardPriceInput = document.getElementById('standard-price');
        const vipPriceInput = document.getElementById('vip-price');

        const standardPrice = standardPriceInput.value;
        const vipPrice = vipPriceInput.value;

        const data = {
            hall: document.querySelector('input[name="prices-hall"]:checked').value,
            standardPrice: standardPrice,
            vipPrice: vipPrice
        };

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'save_prices.php', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onload = function () {
            if (xhr.status === 200) {
                standardPriceInput.value = '';
                vipPriceInput.value = '';
            }
        };
        xhr.send(JSON.stringify(data));
    });
});