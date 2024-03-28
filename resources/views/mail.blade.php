<DOCTYPE html>
    <html lang="en-US">

    <head>
        <meta charset="utf-8">
    </head>

    <body>
        <h1>Welcome to our company</h1>
        <p>Your account has been successfully created.</p>
        <p>Your details:</p>
        <ul>
            <li>Id: {{$employee->id}}</li>
            <li>Name: {{ $employee->name }}</li>
            <li>Email: {{ $employee->email }}</li>
        </ul>
    </body>

    </html>