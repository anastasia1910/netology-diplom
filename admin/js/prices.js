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

        fetch('save_prices.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    standardPriceInput.value = '';
                    vipPriceInput.value = '';
                    window.alert(data.message);
                } else {
                    console.error(data.message);
                }
            })

            .catch(error => console.error(error));
    });
});