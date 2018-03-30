<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TaskCompleted extends Notification
{
    use Queueable;

    protected $task, $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($task,$user)
    {
        $this->task = $task;
        $this->user = $user;
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
        $url = '/myemployees/'.$this->user->id.'#tasks';

        return (new MailMessage)
                    ->subject('Выполнение задачи')
                    ->greeting('Здравствуйте!')
                    ->line('Пользователь '.$this->user->name.' пометил задачу выполненной: \''.$this->task->title.'\'')
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
