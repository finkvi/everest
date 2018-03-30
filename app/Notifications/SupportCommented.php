<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SupportCommented extends Notification
{
    use Queueable;

    protected $post;
    protected $request;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($post,$request)
    {
        $this->post = $post;
        $this->request = $request;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Комментарий на форуме поддержки')
                    ->greeting('Здравствуйте!')
                    ->line('Ваша публикация на форуме поддержки системы Эверест была прокомментирована пользователем '.$this->request->user()->name.'.')
                    ->action('Перейти на форум поддержки', url('/support'))
                    ->line('Приятной работы!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
