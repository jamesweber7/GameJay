
<form action="{{ route('upload_game') }}" enctype="multipart/form-data" method="post">
    @csrf
    <div class="mb-4">
        Name:
        <label for="name" class="sr-only"></label>
        <input type="text" name="name" id="name" placeholder="Your Game's Name" class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('name') border-red-500 @enderror" value="{{ old('name') }}">

        @error('name')
        <div class="text-red-500 mt-2 text-sm">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="mb-4">
        Simple Description:
        <label for="simple_description" class="sr-only"></label>
        <input type="text" name="simple_description" id="simple_description" placeholder="Simple Description" class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('simple_description') border-red-500 @enderror" value="{{ old('simple_description') }}">

        @error('simple_description')
        <div class="text-red-500 mt-2 text-sm">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="mb-4">
        Detailed Description:
        <label for="detailed_description" class="sr-only"></label>
        <textarea name="detailed_description" id="detailed_description" cols="30" rows="4" class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('detailed_description') border-red-500 @enderror" placeholder="Detailed Description">{{ old('detailed_description') }}</textarea>

        @error('detailed_description')
            <div class="text-red-500 mt text-sm">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="mb-4">
        Zip File:
        <label for="game" class="sr-only">File</label>
        <input type="file" name="game" id="game" value="{{ old('game') }}">

        @error('game')
            <div class="text-red-500 mt text-sm">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="mb-4">

        Canvas Width & Height (pixels)
        <br>
        <label for="width" class="sr-only"></label>
        <input type="number" name="width" id="width" placeholder="width-px" class="bg-gray-100 border-2 w-60 p-4 rounded-lg @error('width') border-red-500 @enderror" value="{{ old('width') }}">

        <label for="height" class="sr-only"></label>
        <input type="number" name="height" id="height" placeholder="height-px" class="bg-gray-100 border-2 w-60 p-4 rounded-lg @error('height') border-red-500 @enderror" value="{{ old('height') }}">

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
        <label for="fullscreen" class="container">Allow Full Screen?
            <input type="checkbox" name="fullscreen" id="fullscreen" {{ old('fullscreen') == 'on' ? 'checked' : '' }}>
            <span class="checkmark"></span>
        </label>
    </div>

    <div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-full">Submit Game</button>
    </div>
</form>