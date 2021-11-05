<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome | EEU Portal</title>
    <style>
        * {
            font-family: Roboto, RobotoDraft, Helvetica, Arial, sans-serif;
            font-size: 16px;
        }

        .btn-container {
            display: flex;
            min-width: 200px;
            align-items: center;
            justify-items: right;
            width: 100%;
        }

        .btn {
            padding: 10px 25px;
            background: #555;
            color: #fff !important;
            border-radius: 5px;
            margin: 50px;
            font-weight: bold;
            font-size: 16px;
            text-transform: uppercase;
            text-decoration: none;
        }
    </style>
</head>
<body>
<p>
    Dear {{$userfirstName}},
</p>
<p>
    Based on your request to reset password for your {{env('APP_NAME')}} account, we have sent you this email.
    To reset your password please click the following button.<br/>
</p>
<div class="btn-container">
    <a href="{{route('password-reset-page', ['id'=>$userId, 'token'=>urlencode($token)])}}" class="btn">
        Reset Your Password
    </a>
</div>
<p style="color: red;">
    <b>Note:</b> If you have not requested to reset your password, please ignore this message.
</p>
<p>Kind regards,<br/>Ethiopian Electric Utility Portal Administrator</p>
</body>
</html>
<script>
    import Button from "@components/Button";
    import {defineComponent} from 'vue'

    export default defineComponent({
        components: {Button}
    })
</script>

