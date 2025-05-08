<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize
{
    public $columns = [];

    public static $defaultColumns = [
        'id',
        'category_1',
        'category_2',
        'category_3',
        'category_4',
        'brand_name',
        'name',
        'status',
        'price',
        'sale_price',
        'sale_from',
        'sale_to',
        'warranty',
        'source',
        'note',
        'created_at',
        'updated_at',
    ];

    public static $availableColumns = [
        'id'                      => '#',
        'category_1'              => 'Danh mục cấp 1',
        'category_2'              => 'Danh mục cấp 2',
        'category_3'              => 'Danh mục cấp 3',
        'category_4'              => 'Danh mục cấp 4',
        'brand_name'              => 'Thương hiệu',
        'name'                    => 'Sản phẩm',
        'images'                  => 'Ảnh sản phẩm',
        'status'                  => 'Trạng thái',
        'status_note'             => 'Ghi chú cho trạng thái',
        'price'                   => 'Giá',
        'inbox_price'             => 'Giá Inbox',
        'hide_price_label'        => 'Hiện giá là',
        'sale_price'              => 'Giá khuyến mại',
        'sale_from'               => 'Bắt đầu khuyến mại',
        'sale_to'                 => 'Kết thúc khuyến mại',
        'serial'                  => 'Serial',
        'warranty'                => 'Bảo hành',
        'source'                  => 'Nguồn gốc',
        'note'                    => 'Ghi chú',
        'technical_specification' => 'Thông số kỹ thuật',
        'description'             => 'Mô tả',
        'include_in_box'          => 'Trong hộp có gì',
        'slug'                    => 'Đường dẫn',
        'url_old'                 => 'Đường dẫn cũ',
        'created_at'              => 'Ngày tạo',
        'updated_at'              => 'Ngày cập nhật',
    ];

    public function __construct()
    {
        if (request()->has('columns')) {
            $this->columns = collect(static::$availableColumns)->only(request('columns'))->toArray();
        } else {
            $this->columns = static::$availableColumns;
        }
    }

    public function collection()
    {
        $products = Product::ignoreGlobalEagerLoading()
                           ->with([
                               'productCategory:id,title,slug,parent_id,_lft,_rgt',
                               'productCategory.ancestors:id,title,parent_id,_lft,_rgt',
                               'brand',
                               'productMedias:model,model_id,url',
                           ])
                           ->orderByDesc('created_at')
                           ->get()
        ;

        $products->each->setAppends([]);

        return $products;
    }

    public function headings(): array
    {
        return array_values($this->columns);
    }

    /**
     * @param Product $row
     *
     * @return array
     */
    public function map($row): array
    {
        // Get categories.
        $nodes = $row->productCategory->ancestors->push($row->productCategory)->toTree();

        $traverse = function ($categories, $level = 1) use (&$traverse, &$row) {
            foreach ($categories as $category) {
                $row["category_$level"] = $category->title;

                $traverse($category->children, $level + 1);
            }
        };

        $traverse($nodes);

        // Array properties.
        foreach ($row->getAttributes() as $key => $value) {
            if (is_array($value)) {
                $row->{$key} = implode(', ', $value);
            }

            if (is_array($val = json_decode($value, true))) {
                $row->{$key} = implode(', ', $val);
            }
        }

        // Images.
        if ($row->productMedias->isNotEmpty()) {
            $row->images = $row->productMedias->pluck('url')->implode('|');
        }

        // Slug.
        $row->slug = route('fe.product', ["slug" => $row->slug]);

        // Get other properties.
        $row->status     = __($row->labelStatus());
        $row->brand_name = $row->brand->title ?? null;

        return $row->only(array_keys($this->columns));
    }
}
