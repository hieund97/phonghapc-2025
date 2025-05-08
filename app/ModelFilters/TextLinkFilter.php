<?php

namespace App\ModelFilters;

use EloquentFilter\Filterable;
use App\Models\PostCategory;
use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;

class TextLinkFilter extends ModelFilter
{

    public function model($value)
    {
        return $this->where('model',$value);
    }
    public function modelId($value)
    {
        return $this->where('model_id',$value);
    }

    public function type($value)
    {
        return $this->where('status',$value);
    }

    public function text($value)
    {
        return $this->whereLike('text',$value);
    }
    
    public function link($value)
    {
        return $this->whereLike('link',$value);
    }

    public function createdAt($value)
    {
        return $this->whereBetween('created_at', dateRangePicker($value));
    }
}
