<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Projekti</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
 <h1>Projekti !!</h1>

    <a href="projects/create">Dodaj novi projekat</a>
    @foreach($projects as $project)
        <p><a href="/projects/{{$project->id}}">{{$project->title}}</a></p>
    @endforeach

 </body>
</html>