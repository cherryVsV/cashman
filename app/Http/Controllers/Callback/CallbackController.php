<?php

namespace App\Http\Controllers\Callback;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CallbackController extends Controller
{
    public function sendTextMessage(Request $request)
    {
        $this->validate($request, [
            'phone' => ['required', 'string'],
            'name' => ['required', 'string'],
            'message' => ['required', 'string', 'max:255']
        ]);
    }

    public function sendVoiceMessage(Request $request)
    {
        $files = $request->file('files');
        if ($request->hasFile('files')) {
            foreach ($files as $file) {
                $name = "record-" . time() . ".mp3";
                $file->storeAs("/public/uploads/", $name);
            }
        }
        return "success";
    }
}
