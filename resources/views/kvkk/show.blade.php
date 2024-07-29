@extends('layouts.HomePost')

@section('title', 'KVKK')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-4">KVKK</h1>
    <div class="bg-white p-6 rounded-lg shadow-lg">
        {!! nl2br(e($kvkk['content'])) !!}
    </div>
</div>
@endsection
