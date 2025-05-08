<?php

namespace App\Exports;

use App\Models\Post;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Http\Request;

class PostsExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize
{
    public $columns = [];


    public static $availableColumns = [
        'id' => '#',
        'title' => 'Tiêu đề',
        'excerpt' => 'Mô tả ngắn',
        'content' => 'Mô tả',
        'thumbnail' => 'Ảnh',
        'banner' => 'Banner',
        'slug' => 'Đường dẫn',
        'author' => 'Tác giả',
        'status' => 'Trạng thái',
        'is_featured' => 'Nổi bật',
        'is_video' => 'Tin video',
        'is_home_featured' => 'Show hôm',
        'is_experience' => 'Kinh nghiệm',
        'is_event' => 'Sự kiện',
        'category_1' => 'Danh mục 1',
        'category_2' => 'Danh mục 2',
        'category_3' => 'Danh mục 3',
        'category_4' => 'Danh mục 4',
        'created_at' => 'Ngày tạo',
        'updated_at' => 'Ngày cập nhật',
    ];

    public function __construct()
    {
        $this->columns = static::$availableColumns;
    }

    public function collection()
    {
        $posts = Post::
        filter(request()->all())
        ->withoutGlobalScope('published')
        ->with('categories')
        ->orderByDesc('id')->get();

        $posts->each->setAppends([]);

        return $posts;
    }

    public function headings(): array
    {
        return array_values($this->columns);
    }

    /**
     * @param Post $row
     *
     * @return array
     */
    public function map($row): array
    {
        // Get categories.
        $index=0;
        foreach($row->categories as $category){
            $index++;
            $row["category_$index"] = $category->title;
        }

        // Array properties.
        foreach ($row->getAttributes() as $key => $value) {
            if (is_array($value)) {
                $row->{$key} = implode(', ', $value);
            }

            if (is_array($val = json_decode($value, true))) {
                $row->{$key} = implode(', ', $val);
            }
        }

    
        // Slug.
        $row->slug = route('fe.post',["slug"=>$row->slug,"id"=>$row->id]);
        // Get other properties.
        $row->status = __(Post::STATUS[$row->status]);


        return $row->only(array_keys($this->columns));
    }
}
