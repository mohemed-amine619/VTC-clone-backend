<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vtc-Clone</title>
</head>
<body>
    <div class="container">
    <div class="card card-body" style="margin-left: 40px; margin-left: 50px;">
       <div align = "center">
            <h1>
                Vtc Clone
            </h1>
       </div>
       <h3>
        E-mail Verification.
       </h3>
       <p>Hello, {{ $user->name }}
        <br/> <br/>
        we have sent to you this email to check if this E-mail : <a href="">{{ $user->email }}</a> you provide is valide one; Entre this code : .
        Enter this code : {{ $user->otp_code }}
       </p>
    </div>
    </div>
</body>
</html>