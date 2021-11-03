<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome | EEU Portal</title>
</head>
<body>
<h1>Welcome To Ethiopian Electric Utility Portal</h1>
<p>
    Please click <a href="{{route('verification.verify', ['id'=>$userId, 'hash'=>urlencode($token)])}}">here</a> to
    activate your {{env('APP_NAME')}} portal account!
    @if(!empty($plain_passwd))
        <br/>Once you activate your account please use <b>{{$plain_passwd}}</b> as a password to login.
    @endif
</p>
</body>
</html>
