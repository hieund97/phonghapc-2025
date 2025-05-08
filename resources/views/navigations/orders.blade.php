<div class="itemt" id="itemt">
    <div class="box-bor pad5 clearfix">
        <ul class="list-dot scoll2" rel="" id="list_cate">
            @foreach($navigations as $row)
                <li rel="{{$row->id }}" class="ui-state-default ui-sortable-handle">
                    <a onclick="loadSubCate({{$row->id }},);" href="javascript:">{{$row->name }}</a>
                    @can('navigations.update')
                        <a class="blue" href="javascript:" onclick="showFormEdit('{{ route('navigations.edit', ['navigations' => $row->id]) }}');"><i class="fas fa-edit"></i></a>
                    @endcan
                </li>
            @endforeach
        </ul>
    </div>
    <p align="center">
        @can('navigations.store')
            [<a id="add_" rel="0" href="javascript:" onclick="showFormAdd($(this).attr('rel'),1);">Thêm</a>]
        @endcan
        @can('navigations.update')
            [<a href="javascript:" onclick="saveOrder(,'ordering')" >Save Order</a>]
        @endcan
    </p>
</div>
<script>
    $( document ).ready(function() {
        $("#list_cate{{$level}}").sortable({disable:true});
    });
</script>
