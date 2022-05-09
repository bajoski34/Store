<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entry to Shop implemetation using Flutterwave-PHP</title>
</head>

<body>
    <form action="" method="post">
        <input id="inline-input" type="radio" name="inline" value="1">
        <input id="standard-input" type="radio" name="standard" value="0">
    </form>

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