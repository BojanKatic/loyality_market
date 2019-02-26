<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Projekti</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
 <h1>Kreiraj projekat !!</h1>

    <a href="/projects">Nazad</a>
    <form method="post" action="/projects">
        @csrf
        <input name="title" val="{{ old('title')}}"/>
        <textarea name="description" val="{{ old('description')}}"></textarea>
        <button type="submit">Kreiraj</button>
    </form>
    <?php ?>
        @extends('layouts.error')
 </body>
</html>