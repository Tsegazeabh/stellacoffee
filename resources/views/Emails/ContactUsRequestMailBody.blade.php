<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Contact Us Request</title>
</head>
<body class="antialiased bg-white dark:bg-gray-900 text-base">
    <div>
        <h2><span><strong></strong> Contact Us Request Details</span></h2>
    </div>
    <div>
        <div>
            <p>Name: {{$name}}</p>
        </div>
        <div>
            <p>Email: {{$email}}</p>
        </div>
        <div>
            <p>Phone Number: {{$phone_number}}</p>
        </div>
        <div>
            <p>Company Name: {{$company_name}}</p>
        </div>
        <div>
            <p>Area of Profession: {{$professional_area}}</p>
        </div>
        <div>
            <p>Country: {{$country}}</p>
        </div>
        <div>
            <p>Comment Description: {{$detail}}</p>
        </div>
    </div>
</body>
</html>
