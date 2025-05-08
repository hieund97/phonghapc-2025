<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class BuildPcExport implements FromView
{
    protected $dataProduct;
    public function __construct($dataProduct)
    {
        $this->dataProduct = $dataProduct;
    }

    public function view(): View
    {
        return view('front_end.build_pc.pdf', [
            'data' => $this->dataProduct
        ]);
    }
}
