<?php

namespace App\Notifications;

use App\Models\invoices;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AddInvoicesNew extends Notification
{
    use Queueable;

    private $invoices;
    public function __construct(invoices $invoices)
    {
        $this->invoices = $invoices;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'id' => $this->invoices->id,
            'title' => 'A new invoice has been added by:',
            'user' => Auth::user()->name
        ];
    }
}