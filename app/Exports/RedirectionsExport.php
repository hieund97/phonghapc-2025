<?php

namespace App\Exports;

use App\Models\Redirection;
use App\Models\TextLink;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RedirectionsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public $columns = [];
    public static $availableColumns = [
        'id' => '#',
        'link_from' => 'Link From',
        'link_to' => 'Đường dẫn',
        'type' => 'Loại',
        'created_at' => 'Ngày tạo',
    ];

    public function __construct()
    {
        $this->columns = static::$availableColumns;
    }

    public function headings(): array
    {
        return array_values($this->columns);
    }

    public function collection()
    {
        $redirections = Redirection::search(request()->get('q'))
            ->orderBy('id', 'DESC')
            ->get([
                'id',
                'link_from',
                'link_to',
                'type',
                'created_at'
            ])
            ->map(function ($redirection) {
                $redirection['created_ats'] = formatDateTimeShow($redirection->created_at);
                unset($redirection['created_at']);
                return $redirection;
            });;
        return $redirections;
    }
}
