<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
            'id' => '1',
            'code' => '001',
            'name' => 'Create Invoice',
        ]);

        Permission::create([
            'id' => '2',
            'code' => '002',
            'name' => 'Alter Invoice',
        ]);

        Permission::create([
            'id' => '3',
            'code' => '003',
            'name' => 'Delete Invoice',
        ]);

        Permission::create([
            'id' => '4',
            'code' => '004',
            'name' => 'Invoice Tenant',
        ]);
        
        Permission::create([
            'id' => '5',
            'code' => '005',
            'name' => 'Settle Invoice',
        ]);

        //tenants 
        
        Permission::create([
            'id' => '6',
            'code' => '006',
            'name' => 'Create Tenant',
        ]);

        Permission::create([
            'id' => '7',
            'code' => '007',
            'name' => 'Alter Tenant',
        ]);

        Permission::create([
            'id' => '8',
            'code' => '008',
            'name' => 'Delete Tenant',
        ]);

        Permission::create([
            'id' => '9',
            'code' => '009',
            'name' => 'Vacate Tenant',
        ]);

        //landlords
        Permission::create([
            'id' => '10',
            'code' => '010',
            'name' => 'Create Landlord',
        ]);

        Permission::create([
            'id' => '11',
            'code' => '011',
            'name' => 'Alter Landlord',
        ]);

        Permission::create([
            'id' => '12',
            'code' => '012',
            'name' => 'Delete Landlord',
        ]);

        //expenses
        Permission::create([
            'id' => '13',
            'code' => '013',
            'name' => 'Create Expense',
        ]);

        Permission::create([
            'id' => '14',
            'code' => '014',
            'name' => 'Alter Expense',
        ]);

        Permission::create([
            'id' => '15',
            'code' => '015',
            'name' => 'Delete Expense',
        ]);

        //properties
        Permission::create([
            'id' => '16',
            'code' => '016',
            'name' => 'Create Property',
        ]);

        Permission::create([
            'id' => '17',
            'code' => '017',
            'name' => 'Alter Property',
        ]);

        Permission::create([
            'id' => '18',
            'code' => '018',
            'name' => 'Delete Property',
        ]);

        //units
        Permission::create([
            'id' => '19',
            'code' => '019',
            'name' => 'Create Unit',
        ]);

        Permission::create([
            'id' => '20',
            'code' => '020',
            'name' => 'Alter Unit',
        ]);

        Permission::create([
            'id' => '21',
            'code' => '021',
            'name' => 'Delete Unit',
        ]);

    }
}
