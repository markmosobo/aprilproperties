<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WhatsappReceipt;
use App\Models\EmailReceipt;

class ReceiptController extends Controller
{
    public function whatsappReceipts(Request $request, $id)
    {
        $whatsappreceipts = WhatsappReceipt::where('statement_id',$id)->get();

        return response()->json([
            'status' => true,
            'message' => "success",
            'whatsappreceipts' => $whatsappreceipts
        ], 200);
    }

    public function emailReceipts(Request $request, $id)
    {
        $emailreceipts = EmailReceipt::where('statement_id',$id)->get();

        return response()->json([
            'status' => true,
            'message' => "success",
            'emailreceipts' => $emailreceipts
        ], 200);
    }

    public function deleteWhatsappReceipt(Request $request, $id)
    {
        $receipt = WhatsappReceipt::findOrFail($id);
        if($receipt){
        $receipt->delete();

        return response()->json([
            'status' => true,
            'message' => "Receipt Deleted successfully!",
        ], 200);
        }
    }

    public function deleteEmailReceipt(Request $request, $id)
    {
        $receipt = EmailReceipt::findOrFail($id);
        if($receipt){
        $receipt->delete();

        return response()->json([
            'status' => true,
            'message' => "Receipt Deleted successfully!",
        ], 200);
        }
    }
}
