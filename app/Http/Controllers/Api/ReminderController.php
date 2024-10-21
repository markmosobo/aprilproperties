<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WhatsappReminder;
use App\Models\EmailReminder;

class ReminderController extends Controller
{
    public function whatsappReminders(Request $request, $id)
    {
        $whatsappreminders = WhatsappReminder::where('statement_id',$id)->get();

        return response()->json([
            'status' => true,
            'message' => "success",
            'whatsappreminders' => $whatsappreminders
        ], 200);
    }

    public function emailReminders(Request $request, $id)
    {
        $emailreminders = EmailReminder::where('statement_id',$id)->get();

        return response()->json([
            'status' => true,
            'message' => "success",
            'emailreminders' => $emailreminders
        ], 200);
    }

    public function deleteWhatsappReminder(Request $request, $id)
    {
        $reminder = WhatsappReminder::findOrFail($id);
        if($reminder){
        $reminder->delete();

        return response()->json([
            'status' => true,
            'message' => "Reminder Deleted successfully!",
        ], 200);
        }
    }

    public function deleteEmailReminder(Request $request, $id)
    {
        $reminder = EmailReminder::findOrFail($id);
        if($reminder){
        $reminder->delete();

        return response()->json([
            'status' => true,
            'message' => "Reminder Deleted successfully!",
        ], 200);
        }
    }
}
