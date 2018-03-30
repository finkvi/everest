<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TaskAdded extends Notification
{
    use Queueable;

    protected $task, $creator;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($task,$creator)
    {
        $this->task = $task;
        $this->creator = $creator;
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
        $url = '/profile#tasks';

        return (new MailMessage)
                    ->subject('Добавлена задача')
                    ->greeting('Здравствуйте!')
                    ->line('Пользователь '.$this->creator->name.' создал Вам задачу: \''.$this->task->title.'\'')
                    ->action('Перейти к списку задач', url($url))
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
