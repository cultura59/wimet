<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nuevo espacio</title>
</head>
<body>
    <h1>Se registro un nuevo espacio!</h1>
    <ul>
        <li>Link: <a href="http://localhost:8000/publicar/espacio/{{$espacio->id}}">{{$espacio->name}}</a></li>
        <li>Nombre dueño: {{$usuario->firstname}}</li>
        <li>Apellido dueño: {{$usuario->lastname}}</li>
        <li>Email: {{$usuario->email}}</li>
    </ul>
</body>
</html>