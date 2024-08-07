@extends('layouts.HomePost')

@section('title', $type == 'privacy_policy' ? 'Privacy Policy' : 'KVKK')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mt-6 mb-4">{{ $type == 'privacy_policy' ? 'Privacy Policy' : 'KVKK' }}</h1>
    <div class="prose text-gray-200">
        {!! $textContent !!}
    </div>
</div>
@endsection
