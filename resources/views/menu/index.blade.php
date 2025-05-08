@extends('layouts.app')

@section('page-title', __('Menu'))

@section('content')
<div class="container-fluid">
    <!-- Info boxes -->
    <div class="row">
      <div class="col-md-12">
        {!! Menu::render() !!}
      </div>
      <!-- /.col -->
    </div>

  </div><!--/. container-fluid -->
@endsection

@push('scripts')
    {!! Menu::scripts() !!}
@endpush
