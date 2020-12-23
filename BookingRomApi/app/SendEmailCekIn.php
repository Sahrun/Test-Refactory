<?php


namespace App;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Database\Eloquent\Model;

class SendEmailCekIn extends Mailable
{
    use Queueable, SerializesModels;
 
    public $dataEmail ;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($dataEmail)
    {
        $this->dataEmail = $dataEmail;
    }
 
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       return $this->from('sahrun.raja.tega@gmail.com')
                   ->view('email.cekinroom')
                   ->with(
                    [
                        'data' =>  $this->dataEmail,
                    ]);
    }
}
