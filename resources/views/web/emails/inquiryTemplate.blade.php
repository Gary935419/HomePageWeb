<!DOCTYPE html>
<html>
<head>
    <title>お問い合わせ</title>
</head>
<body>
<h1>{{ $details['inquiry_title'] }}</h1>
<p>{{ $details['inquiry_content'] }}</p>
<span>お名前: {{ $details['user_name'] }}</span>
<span>電話番号: {{ $details['phone_number'] }}</span>
<span>メールアドレス: {{ $details['email'] }}</span>
<span>会社名: {{ $details['company_name'] }}</span>
<span>ご住所: {{ $details['address_info'] }}</span>
</body>
</html>
