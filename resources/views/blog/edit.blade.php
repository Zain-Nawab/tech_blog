@extends("dashboard.dashboardlayout");

@push('create_css')
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
@endpush


@section("main")
 {{-- Form Start --}}
 <form  id='createForm' action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    {{-- Title --}}
    <div class="mb-3">
        <label for="title" class="form-label">Title:</label>
        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Content --}}
    <div class="mb-3">
        <label for="content" class="form-label">Content:</label>
        <textarea name="content" id="post_content" class="d-none form-control " rows="5">{{ old('content') }}</textarea>

        <div id="editor"  style="height: 300px" class="bg-white"></div>

        @error('content')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Create the editor container -->
   
    {{-- Image --}}
    <div class="mb-3">
        <label for="image" class="form-label">Image:</label>
        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
        @error('image')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Submit --}}
    <button type="submit" class="btn btn-primary">Submit Post</button>
</form>


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

<!-- Initialize Quill editor -->
<script>
    const quill = new Quill('#editor', {
      theme: 'snow'
    });

    document.querySelector("#createForm").addEventListener('submit', function(e) {
        e.preventDefault();

        const contentArea = document.querySelector("#post_content");

        const html = quill.getSemanticHTML();
        
        contentArea.value = html;

        document.querySclector("#createForm").submit();
    } );

  </script>

@endpush

@endsection