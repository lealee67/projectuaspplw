@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-3">Tambah Turnamen</h3>

    <form action="{{ route('turnamen.store') }}" method="POST">
        @csrf
        @include('turnamen.form')
    </form>
</div>
@endsection
