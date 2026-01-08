@extends('layouts.app')
@sections('header')
@endsection

@section('content')
@if (session('success'))
<div class="alert-alert-success">
    {{ session('success') }}
</div>
@endif

@if (session('error'))
<div class="alert-alert-success">
    {{ session('error') }}
</div>
@endif





@endif
@endsection