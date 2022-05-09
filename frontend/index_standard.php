<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sample For Abraham's PHP SDK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    clifford: '#da373d',
                }
            }
        }
    }
    </script>
    <style>
    body {
        background-color: #f2f2f2;
    }

    #overlay {
        position: fixed;
        /* Sit on top of the page content */
        display: none;
        /* Hidden by default */
        width: 100%;
        /* Full width (cover the whole page) */
        height: 100%;
        /* Full height (cover the whole page) */
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        /* Black background with opacity */
        z-index: 2;
        /* Specify a stack order in case you're using a different order for other elements */
        cursor: pointer;
        /* Add a pointer on hover */
    }

    #text {
        position: absolute;
        top: 50%;
        left: 50%;
        font-size: 50px;
        color: white;
        transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
    }

    .half-circle-spinner,
    .half-circle-spinner * {
        box-sizing: border-box;
    }

    .half-circle-spinner {
        width: 60px;
        height: 60px;
        border-radius: 100%;
        position: relative;
        margin: auto;
        margin-top: 15em;
    }

    .half-circle-spinner .circle {
        content: "";
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 100%;
        border: calc(60px / 10) solid transparent;
    }

    .half-circle-spinner .circle.circle-1 {
        border-top-color: #ff1d5e;
        animation: half-circle-spinner-animation 1s infinite;
    }

    .half-circle-spinner .circle.circle-2 {
        border-bottom-color: #ff1d5e;
        animation: half-circle-spinner-animation 1s infinite alternate;
    }

    @keyframes half-circle-spinner-animation {
        0% {
            transform: rotate(0deg);

        }

        100% {
            transform: rotate(360deg);
        }
    }
    </style>
</head>

<body class="h-14 bg-gradient-to-r from-cyan-500 to-blue-500">
    <div id="overlay">
        <div class="half-circle-spinner">
            <div class="circle circle-1"></div>
            <div class="circle circle-2"></div>
        </div>
    </div>
    <form id="pay-form" method="POST"
        class="flex flex-col mx-auto space-y-reverse space-y-4 font-mono text-white text-sm font-bold leading-6 max-w-xs mt-4 font-normal text-orange-700">
        <h1>Purchase this fine Dress</h1>
        <input type="hidden" name="amount" value="3000">
        <input type="hidden" name="currency" value="NGN">
        <input type="hidden" name="payment_method" value="card,account,ussd,qr">
        <input type="text" name="customer_name" placeholder="Full Name" />
        <input type="email" name="customer_email" placeholder="Email Address" />
        <input type="phone" name="customer_phone" placeholder="Phone number" />

        <button id="make-payment"
            class="bg-gray-500 hover:bg-sky-700 px-5 py-2 text-sm leading-5 rounded-full font-semibold text-white">
            Buy Now
        </button>

    </form>

    <script>
    const makePayment = document.querySelector('#make-payment');
    const payForm = document.querySelector('#pay-form');
    payForm.addEventListener('submit', (e) => {
        e.preventDefault();
        document.getElementById("overlay").style.display = "block";
        const customer_id = "245535454";;
        const amount = document.querySelector('input[name=amount]').value;
        const currency = document.querySelector('input[name=currency]').value;
        let payment_method = document.querySelector('input[name=payment_method]').value;
        const customer_name = document.querySelector('input[name=customer_name]').value;
        const customer_email = document.querySelector('input[name=customer_email]').value;
        const customer_phone = document.querySelector('input[name=customer_phone]').value;
        payment_method = payment_method.split(',');

        const result = fetch('http://localhost:8086/backend/pay', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                customer_id,
                amount,
                currency,
                payment_method,
                customer_name,
                customer_email,
                customer_phone
            })
        });

        result.then(res => res.json()).then(data => {

            let {
                payment_link
            } = data;
            document.getElementById("overlay").style.display = "none";
            window.location = payment_link;
        });

    });
    </script>

</body>

</html>