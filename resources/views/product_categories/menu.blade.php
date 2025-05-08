@extends('layouts.app')

@section('page-title', __('Menu Manager ('.$type.')'))

@section('content')
<div class="container-fluid">
    <!-- Danh sach sach danh muc-->
    <div class="card card-default">
      @include('product_categories.tab_menu')
      <!-- /.card-header -->
      <div class="card-body">
        <div>
          <ol id="list_cate1" class="nested_with_switch vertical">
              @foreach($menus as $row)
                <li rel="{{$row->id }}">
                    <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                    {{$row->title }}
                    @include('product_categories.menu_childs',['menus' => $row->$childs,'childs'=>$childs])
                </li>
              @endforeach
          </ol>
        </div>
        <!-- /.row -->
      </div>
      <!-- /.card-body -->
      <div class="card-footer">
        <button type="button" id="category_submit" class="btn btn-primary btn-sm" onclick="saveOrder(1,'{{$type}}')">
            {{ __('Save') }}
        </button>
      </div>
    </div>
    <!-- /.card -->
  </div><!-- /.container-fluid -->
  
@endsection
@include('product_categories.js')




