<?php

namespace App\Http\Controllers\api\web;

use App\Mail\MyMail;
use Illuminate\Support\Facades\Mail;

class InquiryController extends Controller
{
    public function post_inquiry_add()
    {
        try {
            $params = request()->all();
            $details = [
                'inquiry_title' => $params['inquiry_title'],
                'inquiry_content' => $params['inquiry_content'],
                'address_info' => $params['address1'] . $params['address2'] . $params['address3'] . "〒　" . $params['number1'] . $params['number2'],
                'user_name' => $params['user_name'],
                'company_name' => $params['company_name'],
                'phone_number' => $params['phone_number'],
                'email' => $params['email']
            ];
            Mail::to(env('MAIL_TO_ADDRESS', 'hello@example.com'))->send(new MyMail($details,'お問い合わせ','web.emails.inquiryTemplate'));
            return $this->ok(array('RESULT' => 'OK', 'MESSAGE' => 'SUCCESS。'));
        } catch (\Exception $e) {
            return $this->error(array('RESULT' => 'NG', 'MESSAGE' => 'ERROR。<br>' . $e->getMessage() ));
        }
    }
}
