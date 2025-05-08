<ol>
    @foreach($menus as $row)
      <li rel="{{$row->id }}">
          <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
          {{$row->title }}
           @include('product_categories.menu_childs',['menus' => $row->$childs,'childs'=>$childs])
      </li>
    @endforeach
</ol>