@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="m-12 rounded-lg p-12" style="background-color:#242424;color:#ffffff;width:60%;">
            @yield('error_content')
        </div>
    </div>
@endsection