<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramFile;
use NotificationChannels\Telegram\TelegramMessage;
use NotificationChannels\Telegram\TelegramUpdates;

class TelegramNotification extends Notification
{
    use Queueable;

    private $text;
    private $audio;
    private $chatId;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($text, $audio)
    {
        $this->text = $text;
        $this->audio = $audio;
        $updates = TelegramUpdates::create()
            ->limit(2)

            ->options([
                'timeout' => 0,
            ])
            ->get();

        if($updates['ok']) {
            $this->chatId = $updates['result'][0]['channel_post']['sender_chat']['id'];
        }
    }

    public function via($notifiable)
    {
        return ["telegram"];
    }

    public function toTelegram()
    {
        if(!is_null($this->audio)) {
            return TelegramFile::create()
                ->to($this->chatId)
                ->file($this->audio, 'audio');
        }else{
            return TelegramMessage::create()
                ->to($this->chatId)
                ->content($this->text);
        }

    }
}
