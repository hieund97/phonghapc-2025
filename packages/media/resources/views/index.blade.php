@extends('layouts.app')
@section('page-title', __('Media'))
@section('content')
    {!! RvMedia::renderHeader() !!}
    {!! RvMedia::renderContent() !!}
    {!! RvMedia::renderFooter() !!}
@endsection
