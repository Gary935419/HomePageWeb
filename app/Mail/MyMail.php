<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;
    /**
     * @var mixed
     */
    private $subject_name;
    /**
     * @var mixed
     */
    private $template_path;

    public function __construct($details,$subject_name,$template_path)
    {
        $this->details = $details;
        $this->subject_name = $subject_name;
        $this->template_path = $template_path;
    }

    public function build()
    {
        return $this->subject($this->subject_name)->view($this->template_path);
    }
}
