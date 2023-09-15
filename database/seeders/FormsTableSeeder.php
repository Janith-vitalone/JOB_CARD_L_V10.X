<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('forms')->insert([
            [
                'name' => 'User Form',
                'controller' => 'App\Http\Controllers\UserController'
            ],
            [
                'name' => 'Designation Form',
                'controller' => 'App\Http\Controllers\DesignationController'
            ],
            [
                'name' => 'User Role Form',
                'controller' => 'App\Http\Controllers\UserRoleController'
            ],
            [
                'name' => 'Assign User Role Form',
                'controller' => 'App\Http\Controllers\AssignRolesController'
            ],
            [
                'name' => 'Permission Form',
                'controller' => 'App\Http\Controllers\PermissionController'
            ],
            [
                'name' => 'Assign Permission Form',
                'controller' => 'App\Http\Controllers\AssignPermissionController'
            ],
            [
                'name' => 'Client Form',
                'controller' => 'App\Http\Controllers\ClientController'
            ],
            [
                'name' => 'Finishing Form',
                'controller' => 'App\Http\Controllers\FinishingController'
            ],
            [
                'name' => 'Format Form',
                'controller' => 'App\Http\Controllers\FormatController'
            ],
            [
                'name' => 'Dashboard Form',
                'controller' => 'App\Http\Controllers\HomeController'
            ],
            [
                'name' => 'Invoice Form',
                'controller' => 'App\Http\Controllers\InvoiceController'
            ],
            [
                'name' => 'Job Card Form',
                'controller' => 'App\Http\Controllers\JobCardController'
            ],
            [
                'name' => 'Lamination Form',
                'controller' => 'App\Http\Controllers\LaminationController'
            ],
            [
                'name' => 'Material Form',
                'controller' => 'App\Http\Controllers\MaterialController'
            ],
            [
                'name' => 'Printers Form',
                'controller' => 'App\Http\Controllers\PrinterController'
            ],
            // [
            //     'name' => 'Printer Materials Form',
            //     'controller' => 'App\Http\Controllers\PrinterMaterialController'
            // ],
            [
                'name' => 'Print Types Form',
                'controller' => 'App\Http\Controllers\PrintTypeController'
            ],
            [
                'name' => 'Products Form',
                'controller' => 'App\Http\Controllers\ProductController'
            ],
            [
                'name' => 'Quotation Form',
                'controller' => 'App\Http\Controllers\QuotationController'
            ],
            [
                'name' => 'Units(Meassure) Form',
                'controller' => 'App\Http\Controllers\UnitController'
            ],
            [
                'name' => 'Invoice Report',
                'controller' => 'App\Http\Controllers\ReportController'
            ],
            [
                'name' => 'Stock Approval Form',
                'controller' => 'App\Http\Controllers\StockApprovelController'
            ],
        ]);
    }
}
