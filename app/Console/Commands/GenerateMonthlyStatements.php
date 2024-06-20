<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PmsProperty;
use App\Models\PmsTenant;
use App\Models\PmsUnit;
use App\Models\PmsStatement;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
        $vacants = PmsUnit::with('property')->where('status',0)->get();
        // Get the first day of the last month
        $firstDayLastMonth = Carbon::now()->subMonth()->startOfMonth();

        $overpaidtenants = PmsTenant::with('unit')
            ->where('status', 1)
            ->whereExists(function ($query) use ($firstDayLastMonth) {
                $query->select(DB::raw(1))
                      ->from('pms_statements')
                      ->whereColumn('pms_statements.pms_tenant_id', 'pms_tenants.id')
                      ->where('pms_statements.balance', '<', 0)
                      ->where('status',1)
                      ->where('created_at', '>=', $firstDayLastMonth) // Filter by the last month
                      ->orderBy('created_at', 'desc');
            })
            ->get();

        $paidtenants = PmsTenant::with('unit')
            ->where('status', 1)
            ->whereExists(function ($query) use ($firstDayLastMonth) {
                $query->select(DB::raw(1))
                      ->from('pms_statements')
                      ->whereColumn('pms_statements.pms_tenant_id', 'pms_tenants.id')
                      ->where('balance', '>=', 0)
                      ->where('status',1)
                      ->orderBy('created_at', 'desc');
            })
            ->get();    
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
                    $unitId = $tenant->pms_unit_id;
                    $orgDate = now();
                    $date = str_replace('-"', '/', $orgDate);
                    $newDate = date("YmdHis", strtotime($date));
                    $monthlyTotal = $tenant->unit->monthly_rent + $tenant->unit->garbage_fee + $tenant->unit->security_fee;
                    // $refno = "INV".$newDate." ".$tenant->unit->unit_number." Rent @".$monthlyTotal;
                    $refno = "INV" . $newDate . $tenant->id;

                    // $refno = "INV".$newDate;
                    PmsStatement::create([
                        'ref_no' => $refno,
                        'pms_property_id' => $tenant->pms_property_id,
                        'pms_tenant_id' => $tenant->id,
                        'pms_unit_id' => $unitId,
                        'unit_number' => $tenant->unit->unit_number,
                        'details' => "Rent-".$tenant->unit->unit_number."-".$formattedDate,
                        'status' => 0, // status for rented units
                        'total' => $monthlyTotal, // You can set the default total
                        'paid' => 0, // You can set the default paid amount
                        'balance' => 0, // You can set the default balance
                    ]);

                    $this->info('Statement generated for Property ' . $tenant->pms_property_id . ' and Tenant ' . $tenant->id);
                }

            }
            //generate overpaid tenant statements
            // foreach ($overpaidtenants as $tenant) {
            //     // Check if a statement already exists for this month and tenant
            //     $existingStatement = PmsStatement::where([
            //         'pms_property_id' => $tenant->pms_property_id,
            //         'pms_tenant_id' => $tenant->id,
            //         'created_at' => Carbon::now()->startOfMonth(),
            //     ])->first();

            //     // If no statement exists, create a new one
            //     if (!$existingStatement) {
            //         $startOfMonth = Carbon::now()->startOfMonth();
            //         $formattedDate = $startOfMonth->format('M Y');
            //         $tenantUnit = $tenant->unit_number;
            //         $orgDate = now();
            //         $date = str_replace('-"', '/', $orgDate);
            //         $newDate = date("YmdHis", strtotime($date));
            //         $refno = "INV".$newDate." ".$tenant->unit->unit_number." Rent @".$tenant->unit->monthly_rent;
            //         PmsStatement::create([
            //             'ref_no' => $refno,
            //             'pms_property_id' => $tenant->pms_property_id,
            //             'pms_tenant_id' => $tenant->id,
            //             'details' => "Rent-".$tenant->unit->unit_number."-".$formattedDate,
            //             'status' => 0, // You can set the default status
            //             'total' => $tenant->unit->monthly_rent, // You can set the default total
            //             'paid' => $tenant->balance+$tenant->unit->monthly_rent, // You can set the default paid amount
            //             'balance' => 0, // You can set the default balance
            //         ]);

            //         $this->info('Statement generated for Property ' . $tenant->pms_property_id . ' and Tenant ' . $tenant->id);
            //     }
            // }   
            //generate statement for vacant units
            foreach ($vacants as $vacant) {
                // Check if a statement already exists for this month and tenant
                $existingStatement = PmsStatement::where([
                    'pms_property_id' => $vacant->pms_property_id,
                    // 'pms_tenant_id' => 0,
                    'created_at' => Carbon::now()->startOfMonth(),
                ])->first();

                // If no statement exists, create a new one
                if (!$existingStatement) {
                    $startOfMonth = Carbon::now()->startOfMonth();
                    $formattedDate = $startOfMonth->format('M Y');
                    $vacantUnit = $vacant->unit_number;
                    $orgDate = now();
                    $date = str_replace('-"', '/', $orgDate);
                    $newDate = date("YmdHis", strtotime($date));
                    // $refno = "INV".$newDate." ".$vacant->unit_number." Rent @".$vacant->monthly_rent;
                    // $refno = "INV".$newDate;
                    $refno = "INV" . $newDate . $vacant->id;


                    PmsStatement::create([
                        'ref_no' => $refno,
                        'pms_property_id' => $vacant->pms_property_id,
                        'pms_unit_id' => $vacant->pms_unit_id,
                        'unit_number' => $vacant->unit_number,
                        'details' => "Rent-".$vacant->unit_number."-".$formattedDate,
                        'status' => 2, // status for vacant units
                        'total' => 0, // You can set the default total
                        'paid' => 0, // You can set the default paid amount
                        'balance' => 0, // You can set the default balance
                        'water_bill' => 0, // You can set the default balance
                    ]);

                    $this->info('Statement generated for Property ' . $vacant->pms_property_id . ' and Unit ' . $vacant->id);
                }
            }
        // }

        $this->info('Monthly statements generation complete.');
    }
}
