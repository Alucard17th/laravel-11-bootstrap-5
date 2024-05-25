<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Business;
use Illuminate\Http\Request;
use PDF;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        //
        dd($invoice);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }

    public function getDetails(Request $request)
    {
        try {
            $accessToken = filter_var($request->input('api_key'), FILTER_SANITIZE_STRING);
            // $stripe = new \Stripe\StripeClient(env('STRIPE_RESTRICTED_KEY'));
            $stripe = new \Stripe\StripeClient($accessToken);
            $account = $stripe->accounts->retrieve();
            $accountId = $account->id;
            $businessName = $account->settings->dashboard->display_name;
            $businessLogo = $account->settings->branding->logo;
            $businessEmail = $account->email;

            try{
                $businessLogoUrl = $stripe->fileLinks->create(['file' => $businessLogo]);
            }catch(\Exception $e){
                $businessLogoUrl = null;
            }

            $business = Business::where('account_id', $accountId)->first();

            if (!$business) {
                $business = new Business();
                $business->account_id = $accountId;
                $business->name = $businessName;
                $business->email = $businessEmail;
                $business->logo = $businessLogoUrl;
                $business->access_token = $accessToken;
                $business->user_id = auth()->user()->id;

                $business->save();
            }else{
                return response()->json(['error' => 'Business already exists'], 500);
            }

            return response()->json([
                'business' => $business
            ]);
        } catch (\Stripe\Exception\StripeException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function streamInvoice($id){
        ini_set('max_execution_time', 120); // Set maximum execution time to 2 minutes

        $invoice = Invoice::with('services')->where('id', $id)->get();
        view()->share('invoice', $invoice[0]);
       
        $invoiceHtml = view('templates.pdf.invoice', [])->render();
        
        $arabic = new Arabic();
        $p = $arabic->arIdentify($invoiceHtml);

        for ($i = count($p)-1; $i >= 0; $i-=2) {
            $utf8ar = $arabic->utf8Glyphs(substr($invoiceHtml, $p[$i-1], $p[$i] - $p[$i-1]));
            $invoiceHtml = substr_replace($invoiceHtml, $utf8ar, $p[$i-1], $p[$i] - $p[$i-1]);
        }

        $pdf = PDF::loadHTML($invoiceHtml);
        $pdfName = 'invoice-'.$id.'.pdf';
        return $pdf->stream($pdfName);
    }
}