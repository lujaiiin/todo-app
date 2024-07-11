@extends('layouts.app')

@section('content')
<h2>Saved Screenshots</h2>
@foreach($screenshots as $screenshot)
    <div class="screenshot-item">
        <img src="{{ asset('images/screenshots/'.$screenshot->filename) }}" alt="Screenshot">
    </div>
@endforeach
@endsection
