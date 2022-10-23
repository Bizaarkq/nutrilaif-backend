<!DOCTYPE html>
<html>
<head>
    <title>Nutrilife</title>
</head>
<body>
    <h1>{{ $details['title'] }}</h1>
    <p>{{ $details['body'] }}</p>
   

    <p>Saludos cordiales,</p>
    
    <table>
        <tr>
            <td>
                <img src="{{asset('storage/images/logo.png')}}" alt="Nutrilife" width="200" height="200">
            </td>
            <td>
                <span style="font-size: bold;">{{ $details['att'] }}</span><br>
                <span>Nutricionista</span>
            </td>
        </tr>
    </table>
    <br>
    <small>Este correo es creado por el sistema de Nutrilife, para mas información contacte al correo: correodenutrilife@gmail.com</small>
</body>
</html>