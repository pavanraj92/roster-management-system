@extends('frontend.layouts.master')

@section('title', 'Home')

@section('main_class', '')

@section('content')
<div class="container text-center py-5">
    <h1>Welcome to {{ config('app.name', 'Roster Management System') }}</h1>
    <p class="lead">This application has been converted from the original e-commerce template to a staff & roster management MVP. Navigate using the menu above.</p>
</div>
@endsection
