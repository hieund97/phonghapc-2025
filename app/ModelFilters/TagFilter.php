<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;
use App\ModelFilters\ProductFilter;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;
use DB;
class TagFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array|string $value
    * @return TagFilter
    */
    public $relations = [];

    public function productCategories($value): ProductFilter
    {
        if (is_string($value)) {
            $value = explode(',', $value);
        }

        $ids = [];
        $categories = ProductCategory::with('descendants')->whereIn('id', $value)->get([
            'id',
            '_lft',
            '_rgt',
            'parent_id',
        ]);

        foreach ($categories as $category) {
            $ids[] = $category->id;
            $ids = array_merge($ids, $category->descendants->pluck('id')->toArray());
        }

        return $this->where(function (Builder $query) use ($ids) {
            $query->whereIn('product_category_id', $ids);

            $query->orWhereHas('categories', function (Builder $query) use ($ids) {
                $query->whereIn('id', $ids);
            });
        });
    }

    public function name($value): TagFilter
    {
        return $this->where('name','like','%' . $value. '%');
    }

    public function type($value): TagFilter
    {
        return $this->where('type',$value);
    }


    public function productCategory($value): TagFilter
    {
        
       $getCategory = DB::table('taggables')
       ->where('taggable_type','app\models\category')
       ->whereIn('taggable_id', $value)->get();

        $tagIds = [];
        foreach ($getCategory as $category){
            $tagIds[] = $category->tag_id;
        }
            $this->whereIn('id', $tagIds);
        return $this;
    }
}
