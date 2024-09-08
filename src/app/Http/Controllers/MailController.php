<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\AnnounceMail;
use App\Models\User;

class MailController extends Controller
{
    public function email_writing()
    {
        return view('admin.email_writing');
    }


    public function send_all(Request $request)
    {
        $subject = $request->subject;
        $content = $request->content;
        $users = User::all();
        foreach ($users as $user) {
            Mail::to($user)->send(new AnnounceMail($content, $subject));
        }
        return redirect('admin/email')->with('message', '送信されました');
    }

}
