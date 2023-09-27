@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-8/12" style="font-family:Verdana;background-color:var(--div-dark);color:var(--jay-blue-lighter);border-radius:10px;">
            <div class='cool-card-1' style='position:relative;width:30%;float:right;background-color:var(--div-dark-darker);margin:20px;padding:20px;font-size:16px;'>
                Contents:
                <br>
                What is GameJay?
                <br>
                Our Mission
                <br>
                What's next
                <br>
                Help
            </div>
            <gj-h1>
                <button>
                    About GameJay
                </button>
            </gj-h1>

            <gj-h2>
                <button>
                    What is GameJay?
                </button>
            </gj-h2>
            <gj-h2>
                <button>
                    Our Mission
                </button>
            </gj-h2>
            <gj-h2>
                <button>
                    What's next for GameJay
                </button>
            </gj-h2>

            <ul class="flex items-center gj-h" style='justify-content:center;font-size:26px;margin:20px;'>
                <li>
                    <a href="" class="p-3">Help</a>
                </li>
                <li>
                    <a href="" class="p-3">Contact Us</a>
                </li>
                <li>
                    <a href="" class="p-3">Leave Feedback</a>
                </li>
            </ul>
        </div>
    </div>
@endsection