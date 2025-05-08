<?php

use Illuminate\Database\Seeder;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;
//use Excel;

class ProductsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $file = public_path('product.xls');
        $data =  Excel::import(new ProductsImport,$file);
    }
}