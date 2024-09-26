<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\PmsTenant;
use App\Models\PmsProperty;
use App\Models\PmsStatement;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\LandlordInvoiceMail;
use App\Mail\TenantInvoiceMail;

class PmsInvoiceController extends Controller
{
    public function tenantInvoices(Request $request, $id)
    {
        $tenant = PmsTenant::findOrFail($id);
        $pmstenantinvoices = PmsStatement::with('tenant','property','unit')->where('pms_tenant_id', $tenant->id)->whereMonth('created_at', Carbon::now()->month)->get();
        $pmslastmonthtenantinvoices = PmsStatement::with('tenant','property','unit')->where('pms_tenant_id', $tenant->id)->whereBetween('created_at',
        [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()])->get();
        $pmslastninetytenantinvoices = PmsStatement::with('tenant','property','unit')->where('pms_tenant_id', $tenant->id)->whereBetween('created_at',
        [Carbon::now()->subDays(89)->startOfDay(), Carbon::now()->endOfDay()])->get();
        $pmsquartertenantinvoices = PmsStatement::with('tenant','property','unit')->where('pms_tenant_id', $tenant->id)->whereBetween('created_at',
        [Carbon::now()->startOfQuarter(), Carbon::now()->endOfDay()])->get();
        $pmsyeartenantinvoices = PmsStatement::with('tenant','property','unit')->where('pms_tenant_id', $tenant->id)->whereBetween('created_at',
        [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->get();
        $pmslastyeartenantinvoices = PmsStatement::with('tenant','property','unit')->where('pms_tenant_id', $tenant->id)->whereBetween('created_at',
        [Carbon::now()->subYear()->startOfYear(), Carbon::now()->subYear()->endOfYear()])->get();
        $pmsalltenantinvoices = PmsStatement::with('tenant','property','unit')->where('pms_tenant_id', $tenant->id)->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmstenantinvoices' => $pmstenantinvoices,
            'pmslastmonthtenantinvoices' => $pmslastmonthtenantinvoices,
            'pmslastninetytenantinvoices' => $pmslastninetytenantinvoices,
            'pmsquartertenantinvoices' => $pmsquartertenantinvoices,
            'pmsyeartenantinvoices' => $pmsyeartenantinvoices,
            'pmslastyeartenantinvoices' => $pmslastyeartenantinvoices,
            'pmsalltenantinvoices' => $pmsalltenantinvoices,
        ], 200);
    }

    public function propAwaitingInvoicing(Request $request, $id)
    {
        $property = PmsProperty::findOrFail($id);
        $propertyawaitinginvoicing = PmsStatement::latest()->where('water_bill', null)->where('status',0)->with('tenant','property','unit')->where('pms_property_id', $property->id)->whereMonth('created_at', Carbon::now()->month)->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'propertyawaitinginvoicing' => $propertyawaitinginvoicing
        ], 200);
    }

    public function propInvoicestoSettle(Request $request, $id)
    {
        $property = PmsProperty::findOrFail($id);
        $propertyinvoicestosettle = PmsStatement::latest()->whereNotNull('water_bill')->where('status',0)->with('tenant','property','unit')->where('pms_property_id', $property->id)->whereMonth('created_at', Carbon::now()->month)->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'propertyinvoicestosettle' => $propertyinvoicestosettle
        ], 200);
    }

    //settled invoices

    public function propSettledInvoices(Request $request, $id)
    {
        $property = PmsProperty::findOrFail($id);
        // Assuming $month is like 'September 2024'
        $month = Carbon::now()->format('F Y');
        //only settled invoices for month
        $propertymonthsettledinvoices = PmsStatement::latest()->whereNotNull('water_bill')->where('status',1)->with('tenant','property','unit')->where('pms_property_id', $property->id)->where('rent_month',$month)->get();
        //includes vacant and unsettled
        $propertymonthinvoices = PmsStatement::latest()->whereNotNull('water_bill')->with('tenant','property','unit')->where('pms_property_id', $property->id)->where('rent_month',$month)->get();
        $commercialpropertymonthinvoices = $propertymonthinvoices->filter(function ($invoice) {
            return $invoice['unit']['type'] === 'Commercial';
        })->sum('paid');
        $residentialpropertymonthinvoices = $propertymonthinvoices->filter(function ($invoice) {
            return $invoice['unit']['type'] === 'Residential';
        })->sum('paid');

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'propertymonthsettledinvoices' => $propertymonthsettledinvoices,
            'propertymonthinvoices' => $propertymonthinvoices,
            'commercialpropertymonthinvoices' => $commercialpropertymonthinvoices,
            'residentialpropertymonthinvoices' => $residentialpropertymonthinvoices
        ], 200);
    }

    public function propLastMonthSettledInvoices(Request $request, $id)
    {
        $property = PmsProperty::findOrFail($id);
        $lastMonth = Carbon::now()->subMonth()->format('F Y'); // Last month, e.g., 'August 2024'

        $propertylastmonthsettledinvoices = PmsStatement::latest()->whereNotNull('water_bill')->where('status',1)->with('tenant','property','unit')->where('pms_property_id', $property->id)->where('rent_month',$lastMonth)->get();
        $propertylastmonthinvoices = PmsStatement::latest()->whereNotNull('water_bill')->with('tenant','property','unit')->where('pms_property_id', $property->id)->where('rent_month',$lastMonth)->get();
        $commercialpropertylastmonthinvoices = $propertylastmonthinvoices->filter(function ($invoice) {
            return $invoice['unit']['type'] === 'Commercial';
        })->sum('paid');
        $residentialpropertylastmonthinvoices = $propertylastmonthinvoices->filter(function ($invoice) {
            return $invoice['unit']['type'] === 'Residential';
        })->sum('paid');

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'propertylastmonthsettledinvoices' => $propertylastmonthsettledinvoices,
            'propertylastmonthinvoices' => $propertylastmonthinvoices,
            'commercialpropertylastmonthinvoices' => $commercialpropertylastmonthinvoices,
            'residentialpropertylastmonthinvoices' => $residentialpropertylastmonthinvoices
        ], 200);
    }

    public function propLastNinetySettledInvoices(Request $request, $id)
    {
       $property = PmsProperty::findOrFail($id);
        $propertylastninetysettledinvoices = PmsStatement::latest()->whereNotNull('water_bill')->where('status',1)->with('tenant','property','unit')->where('pms_property_id', $property->id)->whereBetween('created_at',
        [Carbon::now()->subDays(89)->startOfDay(), Carbon::now()->endOfDay()])->get();
        $propertylastninetyinvoices = PmsStatement::latest()->whereNotNull('water_bill')->with('tenant','property','unit')->where('pms_property_id', $property->id)->whereBetween('created_at',
        [Carbon::now()->subDays(89)->startOfDay(), Carbon::now()->endOfDay()])->get();
        $commercialpropertylastninetyinvoices = $propertylastninetyinvoices->filter(function ($invoice) {
            return $invoice['unit']['type'] === 'Commercial';
        })->sum('paid');
        $residentialpropertylastninetyinvoices = $propertylastninetyinvoices->filter(function ($invoice) {
            return $invoice['unit']['type'] === 'Residential';
        })->sum('paid');

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'propertylastninetysettledinvoices' => $propertylastninetysettledinvoices,
            'propertylastninetyinvoices' => $propertylastninetyinvoices,
            'commercialpropertylastninetyinvoices' => $commercialpropertylastninetyinvoices,
            'residentialpropertylastninetyinvoices' => $residentialpropertylastninetyinvoices
        ], 200);
    } 

    public function propYearSettledInvoices(Request $request, $id)
    {
       $property = PmsProperty::findOrFail($id);
        $propertyyearsettledinvoices = PmsStatement::latest()->whereNotNull('water_bill')->where('status',1)->with('tenant','property','unit')->whereBetween('created_at',
        [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->get();
        $propertyyearinvoices = PmsStatement::latest()->whereNotNull('water_bill')->with('tenant','property','unit')->where('pms_property_id', $property->id)->whereBetween('created_at',
        [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'propertyyearsettledinvoices' => $propertyyearsettledinvoices,
            'propertyyearinvoices' => $propertyyearinvoices
        ], 200);
    } 

    public function propQuarterSettledInvoices(Request $request, $id)
    {
       $property = PmsProperty::findOrFail($id);
        $propertyquartersettledinvoices = PmsStatement::latest()->whereNotNull('water_bill')->where('status',1)->with('tenant','property','unit')->whereBetween('created_at',
        [Carbon::now()->startOfQuarter(), Carbon::now()->endOfDay()])->get();
        $propertyquarterinvoices = PmsStatement::latest()->whereNotNull('water_bill')->with('tenant','property','unit')->where('pms_property_id', $property->id)->whereBetween('created_at',
        [Carbon::now()->startOfQuarter(), Carbon::now()->endOfDay()])->get();
        $commercialpropertyquarterinvoices = $propertyquarterinvoices->filter(function ($invoice) {
            return $invoice['unit']['type'] === 'Commercial';
        })->sum('paid');
        $residentialpropertyquarterinvoices = $propertyquarterinvoices->filter(function ($invoice) {
            return $invoice['unit']['type'] === 'Residential';
        })->sum('paid');

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'propertyquartersettledinvoices' => $propertyquartersettledinvoices,
            'propertyquarterinvoices' => $propertyquarterinvoices,
            'commercialpropertyquarterinvoices' => $commercialpropertyquarterinvoices,
            'residentialpropertyquarterinvoices' => $residentialpropertyquarterinvoices
        ], 200);
    }

    public function propLastYearSettledInvoices(Request $request, $id)
    {
       $property = PmsProperty::findOrFail($id);
        $propertylastyearsettledinvoices = PmsStatement::latest()->whereNotNull('water_bill')->where('status',1)->with('tenant','property','unit')->whereBetween('created_at',
        [Carbon::now()->subYear()->startOfYear(), Carbon::now()->subYear()->endOfYear()])->get();
        $propertylastyearinvoices = PmsStatement::latest()->whereNotNull('water_bill')->with('tenant','property','unit')->where('pms_property_id', $property->id)->whereBetween('created_at',
        [Carbon::now()->subYear()->startOfYear(), Carbon::now()->subYear()->endOfYear()])->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'propertylastyearsettledinvoices' => $propertylastyearsettledinvoices,
            'propertylastyearinvoices' => $propertylastyearinvoices
        ], 200);
    }  

    public function propAllSettledInvoices(Request $request, $id)
    {
       $property = PmsProperty::findOrFail($id);
        $propertyallsettledinvoices = PmsStatement::latest()->whereNotNull('water_bill')->where('status',1)->with('tenant','property','unit')->get();
        $propertyallinvoices = PmsStatement::latest()->whereNotNull('water_bill')->with('tenant','property','unit')->where('pms_property_id', $property->id)->get();
        $commercialpropertyallinvoices = $propertyallinvoices->filter(function ($invoice) {
            return $invoice['unit']['type'] === 'Commercial';
        })->sum('paid');
        $residentialpropertyallinvoices = $propertyallinvoices->filter(function ($invoice) {
            return $invoice['unit']['type'] === 'Residential';
        })->sum('paid');

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'propertyallsettledinvoices' => $propertyallsettledinvoices,
            'propertyallinvoices' => $propertyallinvoices,
            'commercialpropertyallinvoices' => $commercialpropertyallinvoices,
            'residentialpropertyallinvoices' => $residentialpropertyallinvoices
        ], 200);
    } 

    public function sendLandlordInvoice(Request $request)
    {
        // Validate the input and the files
        $request->validate([
            'email' => 'required|email',
            'subject' => 'required|string',
            'message' => 'required|string',
            'invoice' => 'required|file|mimes:html',
            'pdfFile' => 'required|file|mimes:pdf|max:10000' // Max 10MB
        ]);

        // Retrieve the email details
        $email = $request->input('email');
        $subject = $request->input('subject');
        $message = $request->input('message');

        // Store the uploaded files temporarily
        $invoicePath = $request->file('invoice')->store('invoices', 'public');
        $pdfPath = $request->file('pdfFile')->store('pdfs', 'public');

        // Send the email with attachments
        Mail::to($email)->send(new LandlordInvoiceMail($subject, $message, $invoicePath, $pdfPath));

        return response()->json(['message' => 'Email sent successfully']);
    }

    public function sendTenantInvoice(Request $request)
    {
        // Validate the input and the files
        $request->validate([
            'email' => 'required|email',
            'subject' => 'required|string',
            'message' => 'required|string',
            // 'invoice' => 'required|file|mimes:html',
            // 'pdfFile' => 'required|file|mimes:pdf|max:10000' // Max 10MB
        ]);

        // Retrieve the email details
        $email = $request->input('email');
        $subject = $request->input('subject');
        $message = $request->input('message');

        // Store the uploaded files temporarily
        // $invoicePath = $request->file('invoice')->store('invoices', 'public');
        // $pdfPath = $request->file('pdfFile')->store('pdfs', 'public');

        // Send the email with attachments
        // Mail::to($email)->send(new TenantInvoiceMail($subject, $message, $invoicePath, $pdfPath));
        Mail::to($email)->send(new TenantInvoiceMail($subject, $message));

        return response()->json(['message' => 'Email sent successfully']);
    }
}
