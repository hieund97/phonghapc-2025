@php
$categories = \App\Models\Category::where('status',1)->where('parent_id',null)->with('childs')->get();
@endphp
<ul>
    @foreach ($categories as $item)
        <li>
            <input @if (!empty($selected) && in_array($item->id, Arr::wrap($selected))) checked @endif type="checkbox" value="{{ $item->id }}" name="categories[]">
            {{ $item->title }}
            @include('partials.forms.category_sub',['categories' => $item->childs,'selected'=>$selected])
        </li>
    @endforeach
</ul>
