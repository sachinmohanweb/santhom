<!DOCTYPE html>
<html>
<head>
    <title>Santhom Connect</title>
</head>
<body>
    <p>Dear {{$data['member']->name }},</p>

    <p>
        Your One-Time Password (OTP) for Santhom App login is: 
        <span style="font-size:15px"><b>{{ $data['otp']}}</b></span>.
    </p>

    <p>
        Please use this OTP to complete the verification process and do not share this OTP with anyone.
    </p>

    <p> Warm Regards, <br>Santhom Connect.</p>
     
    <p>Thank you.</p>
    
</body>
</html>