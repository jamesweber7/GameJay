@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-8/12 bg-white p-6 rounded-lg">
            <div class="mb-4 p-3 m-6">
            Contact Us!
            <br>
            <x-contact_form/>
            </div>
        </div>
    </div>
@endsection