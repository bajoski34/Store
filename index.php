<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entry to Shop implemetation using Flutterwave-PHP</title>
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
        background-color: #121212;
    }
    </style>
</head>

<body class="main-bg">
    <!-- <form action="" method="post">
        <input id="inline-input" type="radio" name="inline" value="1">
        <input id="standard-input" type="radio" name="standard" value="0">
    </form> -->

    <h3
        class="bg-clip-text text-transparent bg-gradient-to-r from-orange-500 to-yellow-500 text-5xl font-extrabold text-center">
        Select on of the
        Two Methods to view the flow</h3>
    <div class="flex flex-row">
        <div id="inline-input" class="text-5xl font-extrabold mx-auto mt-4">
            <span class="bg-clip-text text-transparent bg-gradient-to-r from-pink-500 to-violet-500">
                Inline Method
            </span>
        </div>
        <div id="standard-input" class="text-5xl font-extrabold mx-auto mt-4 content-center">
            <span class="bg-clip-text text-transparent bg-gradient-to-r from-pink-500 to-violet-500">
                Standard Method
            </span>
        </div>
    </div>

    <script>
    const inline = document.querySelector('#inline-input');
    const standard = document.querySelector('#standard-input');

    inline.addEventListener('click', () => {
        inline.value = 1;
        standard.value = 0;
        window.location = '/frontend/index_inline.php';
    });

    standard.addEventListener('click', () => {
        standard.value = 1;
        inline.value = 0;
        window.location = '/frontend/index_standard.php';
    });
    </script>
</body>

</html>