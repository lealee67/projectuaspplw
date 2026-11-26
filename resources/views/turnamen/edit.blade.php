@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-3">Edit Turnamen</h3>

    <form action="{{ route('turnamen.update', $turnamen) }}" method="POST">
        @csrf
        @method('PUT')
        @include('turnamen.form')
    </form>
</div>
@endsection
