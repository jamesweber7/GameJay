@extends('layouts.app')

@section('content')
    
    <div class="flex pb-12 w-full">

        <div class="flex w-1/12"></div>

        <div class="flex justify-center w-7/12">
            <div class="w-full p-6 rounded-lg" style="font-family:Verdana;background-color:var(--div-dark);color:var(--jay-blue);">
                <div class="m-4 p-4" style="font-size:20px;">
                    Upload Game
                </div>     

                <form id="cancel" action="{{ route('user', [auth()->user()->username]) }}" enctype="multipart/form-data" method="get">@csrf</form>
                <form id="form" action="{{ route('upload_game') }}" enctype="multipart/form-data" method="post" onkeydown="return event.key != 'Enter';">
                    @csrf

                    <div class="mb-4">
                        Name:
                        <button type="button" onmouseover="focus(this)" class="help-icon-small nice-input-1 mb-1">
                            <x-vaadin-question class="help-icon-1-mark"/>
                            <span class="help-tooltip-1">The name of your game (Max 60 characters)</span>
                        </button>
                        <br/>
                        <label for="name" class="sr-only"></label>
                        <input type="text" maxlength="60" id="name" onclick="selectText(this)" onfocusout="resetValue(this)" name="name" id="name" placeholder="Your Game's Name" class="nice-input-1 nice-edit-2" spellcheck="false" value="{{ old('name') }}">

                        @error('name')
                            <div class="text-red-500 mt-2 text-sm">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <div class="mb-4">
                        Simple Description:

                        <button type="button" onmouseover="focus(this)" class="help-icon-2 nice-input-1 mb-1">
                            <x-vaadin-question class="help-icon-1-mark"/>
                            <span class="help-tooltip-1">A simple description of your game that will help gamers decide to play it! Great hooks help games get played! (Max 150 characters)</span>
                        </button>

                        <label for="simple_description" class="sr-only"></label>
                        <input type="text" maxlength="150" name="simple_description" id="simple_description" onfocusout="resetValue(this)" onclick="selectText(this)" placeholder="Simple Description of your Game" class="nice-input-1 nice-edit-2" value="{{ old('simple_description') }}">

                        @error('simple_description')
                            <div class="text-red-500 mt-2 text-sm">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <div class="mb-4">
                        Detailed Description:

                        <button type="button" onmouseover="focus(this)" class="help-icon-2 nice-input-1 mb-1">
                            <x-vaadin-question class="help-icon-1-mark"/>
                            <span class="help-tooltip-1">A detailed description of your game to help communicate anything you want gamers to know about it. You can add directions, lore, and much, much more!</span>
                        </button>

                        <label for="detailed_description" class="sr-only"></label>
                        <textarea name="detailed_description" class="nice-input-1 nice-edit-2" onfocusout="resetValue(this)" onclick="selectText(this)" style="text-align:left" id="detailed_description" cols="30" rows="4" placeholder="More Detailed Description of your Game" value="{{ old('detailed_description') }}"></textarea>

                        @error('detailed_description')
                            <div class="text-red-500 mt-2 text-sm">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        Zip File:
                        <button type="button" class="nice-input-1 reset-file-button" cool-tooltip-1="Original File" id="reset-file-button" onclick="resetGameFile()"><x-iconic-undo /></button>
                        <label for="game" class="sr-only">File</label>
                        <input type="file" name="game" id="game" onchange="changeGameFile()" hidden="hidden" value="{{ old('game') }}">
                        <button type="button" class="nice-input-1" style="margin-top:10px;padding:10px;padding-right:16px;padding-left:16px;border-radius:5px;width:auto;display:inline;"name="game_button" onclick="clickFileButton()" original-zip="Upload a zip file" id="game_button">Upload a zip file</button>

                        <button type="button" onmouseover="focus(this)" class="help-icon-small nice-input-1" style="min-height:50px;margin-left:5px;margin-top:20px;">
                            <x-vaadin-question class="help-icon-1-mark"/>
                            <span class="help-tooltip-1">Upload a zip file of your game which includes a file named 'index.html'<br>(Max size: 1GB)</span>
                        </button>

                        @error('game')
                            <div class="text-red-500 mt-2 text-sm">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        Canvas Width & Height (pixels)
                        <button type="button" onmouseover="focus(this)" class="help-icon-small nice-input-1">
                            <x-vaadin-question class="help-icon-1-mark"/>
                            <span class="help-tooltip-1">The default width & height of your game in pixels (max 4096x4096)</span>
                        </button>
                        <br>
                        <label for="width" class="sr-only"></label>
                        <input type="number" min="0" max="4096" name="width" id="width" placeholder="width-px" class="nice-input-1 nice-edit-2" style="width:49.6%;" value="{{ old('width') }}">

                        <label for="height" class="sr-only"></label>
                        <input type="number" min="0" max="4096" name="height" id="height" placeholder="height-px" class="nice-input-1 nice-edit-2" style="width:49.6%;" value="{{ old('height') }}">

                        @error('width')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                        @enderror

                        @error('height')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>
                    
                    <div>
                        <label for="fullscreen" class="cool-checkbox-container" style="width:250px">Allow Full Screen?
                            <input type="checkbox" onfocus="this.style='background-color:#5D686F;'" name="fullscreen" id="fullscreen" {{ old('fullscreen') }}>
                            <span class="checkmark"></span>
                        </label>
                    </div>


                    Tags:
                    <button type="button" onmouseover="focus(this)" class="help-icon-2 nice-input-1 mb-1" style="max-height:80px;">
                        <x-vaadin-question class="help-icon-1-mark"/>
                        <span class="help-tooltip-1">Add up to 10 tags to help your game appear in search results!</span>
                    </button>

                    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Varela+Round" />
                    <label for="cool_tag_container" class="sr-only"></label>
                    <div class="cool-tag-container" name="cool_tag_container" data-name="cool_tag_container" style="min-height:72px;width:100%;"></div>

                    Visibility:
                    <button type="button" onmouseover="focus(this)" class="help-icon-2 nice-input-1 mb-1">
                        <x-vaadin-question class="help-icon-1-mark"/>
                        <span class="help-tooltip-1">Public games can be played by anybody on GameJay; <br>Private games can be played by you and people you share the link with<span>
                    </button>

                    <div style="margin-bottom: 10px;">
                        <label for="public" class="cool-checkbox-container" style="display:inline;padding-right:30px">Public
                            <input type="radio" name="visibility" id="public" {{ true ? 'checked' : '' }}>
                            <span class="checkmark"></span>
                        </label>
                        <label class="cool-checkbox-container" style="display:inline;">Private
                            <input type="radio" name="visibility" {{ true ? '' : 'checked' }}>
                            <span class="checkmark"></span>
                        </label>
                    </div>

                </form>
                <div>
                    <button type="submit" form="form" class="form-action-button form-submit-button">Save Changes</button>
                    <button type="cancel" form="cancel" class="form-action-button form-cancel-button" style="width:100%">Cancel</button>
                </div>
            </div>

        </div> 

        <div class="flex w-4/12">
            <div class="p-6 ml-12 mr-12 rounded-lg" style="font-family:Verdana;background-color:var(--div-dark);color:var(--jay-blue);width:100%">
                <div class="m-4 p-4" style="font-size:20px;">
                    Edit Media 
                </div>
                <div class="mb-4">
                    Images/Gifs:
                    <button type="button" onmouseover="focus(this)" class="help-icon-small nice-input-1" style="margin-left:5px;margin-top:20px;">
                        <x-vaadin-question class="help-icon-1-mark"/>
                        <span class="help-tooltip-1">Upload up to 5 images or gifs<br>Supported files: .png .jpg .jpeg .gif</span>
                    </button>
                    <br>


                    <div id="media_port">

                        <label for="input_image_1" class="sr-only">image1</label>
                        <input type="file" form="form" name="input_image_1" id="input_image_1" hidden>
                        <label for="input_image_2" class="sr-only">image2</label>
                        <input type="file" form="form" name="input_image_2" id="input_image_2" hidden>
                        <label for="input_image_3" class="sr-only">image3</label>
                        <input type="file" form="form" name="input_image_3" id="input_image_3" hidden>
                        <label for="input_image_4" class="sr-only">image4</label>
                        <input type="file" form="form" name="input_image_4" id="input_image_4" hidden>
                        <label for="input_image_5" class="sr-only">image5</label>
                        <input type="file" form="form" name="input_image_5" id="input_image_5" hidden>

                        <label for="selected_image" class="sr-only">selected_image</label>
                        <input type="text" form="form" name="selected_image" id="selected_image" hidden>
                        
                    </div>
                    <label for="media" class="sr-only">Media</label>
                    <button class="media-card drag-area" onclick="browseMedia()">
                        <div class="icon"><i class="fas fa-cloud-upload-alt"></i></div>
                        <header style="white-space:pre-line;">Drag & Drop an Image<br>or Click to Browse</header>
                    </button>

                </div>

                <div class="mb-4">
                    YouTube Video:

                    <button type="button" onmouseover="focus(this)" class="help-icon-small nice-input-1" style="margin-left:5px;margin-top:20px;">
                        <x-vaadin-question class="help-icon-1-mark"/>
                        <span class="help-tooltip-1">You can paste a link to a YouTube video for your game</span>
                    </button>
                    
                    <div class="youtube-port media-card-2">
                        <input type="text" id="youtube-input" class="invisible-input jay-input-colors tag-text-input" style="padding:10px;width:100%" placeholder="Paste a YouTube Link">
                        <label for="youtube_link" form="form" class="sr-only">Youtube iFrame</label>
                        <input type="text" form="form" hidden id="youtube_link" name="youtube_link">
                        <div id="youtube-case" hidden="true">
                            <iframe 
                                class="youtube-iframe"
                                id="youtube_iframe"
                                src=""
                                title="YouTube video player" 
                                frameborder="0" 
                                width="100%"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen>
                            </iframe>
                        </div>
                        <div id='youtube-link-not-found' class="media-card-3 hidden" style="padding: 10px;width:100%;height:190px;">
                            Having trouble finding your video...
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <script src="{{ asset('js/game_form.js')}}"></script>


@endsection