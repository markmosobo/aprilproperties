<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PmsProperty;
use App\Models\PmsTenant;
use App\Models\PmsUnit;
use App\Models\PmsStatement;
use Carbon\Carbon;

class GenerateMonthlyStatements extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:monthly-statements';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate monthly statements for all properties and tenants';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Generating monthly statements...');

        // Get all properties and tenants
        $properties = PmsProperty::all();
        $tenants = PmsTenant::with('unit')->where('status',1)->get();

        // Loop through properties and tenants to generate statements
        // foreach ($properties as $property) {
            foreach ($tenants as $tenant) {
                // Check if a statement already exists for this month and tenant
                $existingStatement = PmsStatement::where([
                    'pms_property_id' => $tenant->pms_property_id,
                    'pms_tenant_id' => $tenant->id,
                    'created_at' => Carbon::now()->startOfMonth(),
                ])->first();

                // If no statement exists, create a new one
                if (!$existingStatement) {
                    $startOfMonth = Carbon::now()->startOfMonth();
                    $formattedDate = $startOfMonth->format('M Y');
                    $tenantUnit = $tenant->unit_number;
                    $orgDate = now();
                    $date = str_replace('-"', '/', $orgDate);
                    $newDate = date("YmdHis", strtotime($date));
                    $refno = "INV".$newDate." ".$tenant->unit->unit_number." Rent @".$tenant->unit->monthly_rent;
                    PmsStatement::create([
                        'ref_no' => $refno,
                        'pms_property_id' => $tenant->pms_property_id,
                        'pms_tenant_id' => $tenant->id,
                        'details' => "Rent-".$tenant->unit->unit_number."-".$formattedDate,
                        'status' => 0, // You can set the default status
                        'total' => $tenant->unit->monthly_rent, // You can set the default total
                        'paid' => 0, // You can set the default paid amount
                        'balance' => 0, // You can set the default balance
                    ]);

                    $this->info('Statement generated for Property ' . $tenant->pms_property_id . ' and Tenant ' . $tenant->id);
                }
            }
        // }

        $this->info('Monthly statements generation complete.');
    }
}
