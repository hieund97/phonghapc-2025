<div class="itemt" id="itemt{{$level}}">
    <div class="box-bor pad5 clearfix">
        <ul class="list-dot scoll2" rel="{{$level}}" id="list_cate{{$level}}">
            @foreach($categories as $row)
                <li rel="{{$row->id }}" class="ui-state-default ui-sortable-handle">
                    <a onclick="loadSubCate({{$row->id }},{{$level}});" href="javascript:">{{$row->title }}</a>
                    @can('product_categories.update')
                      <!--  <a class="blue" href="javascript:" onclick="showFormEdit('{{ route('product_categories.edit', ['product_category' => $row->id]) }}');"><i class="fas fa-edit"></i></a>-->
                    @endcan
                    
                </li>
            @endforeach
        </ul>
    </div>
    <p align="center">
        @can('product_categories.store')
          <!--  [<a id="add_{{$level}}" rel="0" href="javascript:" onclick="showFormAdd($(this).attr('rel'),1);">Thêm</a>] -->
        @endcan
        @can('product_categories.update')
            [<a href="javascript:" onclick="saveOrder({{$level}},'ordering')" >Save Order</a>]
        @endcan
    </p>
</div>
<script>
    $( document ).ready(function() {
        $("#list_cate{{$level}}").sortable({disable:true});
    });
</script>
