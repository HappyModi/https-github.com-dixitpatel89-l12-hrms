<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $template->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }
        .letter-head {
            text-align: center;
            margin-bottom: 20px;
        }
        .letter-body {
            text-align: justify;
        }
    </style>
</head>
<body>
    <div class="letter-head">
        <h2>{{ $template->name }}</h2>
    </div>
    <div class="letter-body">
        {!! $letterBody !!}
    </div>
</body>
</html>
