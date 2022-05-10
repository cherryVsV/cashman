<?php

namespace App\Http\Controllers\Callback;

use App\Http\Controllers\Controller;
use App\Notifications\TelegramNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class CallbackController extends Controller
{
    public function sendTextMessage(Request $request)
    {
        $this->validate($request, [
            'phone' => ['required', 'string'],
            'name' => ['required', 'string'],
            'message' => ['required', 'string', 'max:255']
        ]);
        $text = "*Имя:* \n"
            . "$request->name\n"
            . "*Телефон:* \n"
            . "$request->phone\n"
            . "*Сообщение:* \n"
            . "$request->message\n";
        try {
            Notification::route('telegram', '5335867947:AAF6FCBiLh3NJ9Ya3rHua7dTCT1vnWgD0iw')
                ->notify(new TelegramNotification($text, null));
            return response()->json(['status'=>'success']);
        }catch(\Exception $exception){
            return response()->json(['status'=>'error']);
        }
    }

    public function sendVoiceMessage(Request $request)
    {
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            foreach ($files as $key => $file) {
                $filename = time().'-record' .'.mp3';
                Storage::disk('public')->put($filename, File::get($file));
                try {
                    logger(Storage::url($filename));
                    Notification::route('telegram', '5335867947:AAF6FCBiLh3NJ9Ya3rHua7dTCT1vnWgD0iw')
                        ->notify(new TelegramNotification(null, Storage::url($filename)));
                    return response()->json(['status'=>'success']);
                }catch(\Exception $exception){
                    logger($exception);
                    return response()->json(['status'=>'error']);
                }
            }
        }
        return response()->json(['status'=>'success']);
    }
}
