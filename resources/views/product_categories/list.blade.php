@extends('layouts.app')

@section('page-title', __('Category Product Manager'))

@section('content')
<div class="container-fluid">
    <!-- Danh sach sach danh muc-->
    <div class="card card-default">
      @include('product_categories.tab_menu')
      <!-- /.card-header -->
      <div class="card-body">
        <div class="row">
          <table cellpadding="0" cellspacing="0" border="0" class="table_pages" width="100%">
              <tr>
                  <td>
                      <div id="list_cate">
                        @include('product_categories.sub_category',[$categories,$level])
                      </div>
                  </td>
              </tr>
          </table>
        </div>
        <!-- /.row -->
      </div>
      <!-- /.card-body -->
      <div class="card-footer">
      </div>
    </div>
    <!-- /.card -->

  </div><!-- /.container-fluid -->
@endsection



@include('product_categories.js')
