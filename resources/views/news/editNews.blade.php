@extends('layouts/main')

@section('container')
<div class="d-flex justify-content-center flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-2">
    <h1 class="h2">Edit News Blog</h1>
</div>

<div id="loginContainer" class="container-fluid justify-content-center" style="height: 90%">
<div class="col-lg-8 mb-5" style="color: white; background-color: #191919; padding: 20px; border-radius: 20px;">
    <form method="post" action="/newsPosts/{{ $newsPost->slug }}" class="" enctype="multipart/form-data">
        @method('put')
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" required autofocus value="{{ old('title', $newsPost->title) }}">
            @error('title')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="slug" class="form-label">Auto Generate / Custom URL | http://gamersforgamers.test/newsPosts/URL Here</label>
            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" required value="{{ old('slug', $newsPost->slug) }}">
            @error('slug')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select class="form-select" name="category_id">
                @foreach ($categories as $category)
                    @if(old('category_id', $newsPost->category_id) == $category->id)
                        <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                    @else
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">News Blog Image</label>
            <input type="hidden" name="oldImage" value="{{ $newsPost->image }}">
            @if($newsPost->image)
                <img src="{{ asset('storage/' . $newsPost->image) }}" class="img-pnews img-fluid mb-3 col-sm-5 d-block">
            @else
                <img class="img-pnews img-fluid mb-3 col-sm-5">
            @endif
            <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image" onchange="pnewsImage()">
            @error('image')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="body" class="form-label">Body</label>
            <input id="body" type="hidden" name="body" value="{{ old('body', $newsPost->body) }}">
            <trix-editor input="body" style="background-color: white; color: black"></trix-editor>
            @error('body')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        
        <button type="submit" style="background-color: #8c52ff; color: #fffccf !important; text-decoration: none;" class="btn">Update News Blog</button>
    </form>
</div>

<script>
    const title = document.querySelector('#title');
    const slug = document.querySelector('#slug');

    title.addEventListener('change', function() {
        fetch('/newsPosts/checkSlug?title=' + title.value)
            .then(response => response.json())
            .then(data => slug.value = data.slug);
    });

    document.addEventListener('trix-file-accept', function(e) {
        e.preventDefault();
    })

    function pnewsImage() {
        const image = document.querySelector('#image');
        const imgPnews = document.querySelector('.img-pnews');

        imgPnews.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function(oFREvent) {
            imgPnews.src = oFREvent.target.result;
        }
    }
</script>
</div>
@endsection