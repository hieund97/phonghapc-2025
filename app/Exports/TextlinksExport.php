<?php

namespace App\Exports;

use App\Models\TextLink;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TextlinksExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public $columns = [];
    public static $availableColumns = [
        'id' => '#',
        'text' => 'Text',
        'link' => 'Đường dẫn',
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
        $textLinks = TextLink::filter(request()->all())
            ->with('productCategory')
            ->with('category')
            ->with('productTag')
            ->with('postTag')
            ->orderByDesc('id')
            ->get(['id', 'text', 'link', 'created_at'])
            ->map(function ($textLink) {
                $textLink['created_ats'] = formatDateTimeShow($textLink->created_at);
                unset($textLink['created_at']);
                return $textLink;
            });
        return $textLinks;
    }
}
