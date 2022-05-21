<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lampiran Undangan</title>
</head>
<style>
    .container {
        margin-left: -8px;
        margin-top: -10px;
    }

    .iframe {
        width: calc(100% + 8px);
        height: 100vh;
    }
</style>
<body>
    <div class="container">
        <iframe class="iframe" src="<?= $path ?>"></iframe>
    </div>
</body>
</html>