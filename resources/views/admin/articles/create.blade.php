@extends('admin.layouts.main')

@section('content')

<div class="w-full px-8 py-6 mx-auto">
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div
                class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                <div class="px-6 py-8">
                <form role="form" method="POST" action="/admin/articles">
                  @csrf
                    <div class="mb-4 mt-4">
                      <label for="title" class="text-gray-700">Title</label>
                      <input type="text" @error('title') is-invalid @enderror name="title" id="title" placeholder="Title" value="{{ old('title') }}" required class="focus:shadow-primary-outline dark:bg-gray-950 dark:placeholder:text-white/80 dark:text-white/80 text-sm leading-5.6 ease block appearance-none w-full rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding p-3 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                      @error('title')
                      <div class="invalid-feedback">
                        <span class="text-red-500">{{ $message }}</span>
                      </div>
                      @enderror
                    </div>
                    <div class="mb-4 mt-4">
                      <label for="slug" class="text-gray-700">Slug</label>
                      <input type="text" @error('slug') is-invalid @enderror name="slug" id="slug" placeholder="Slug" value="{{ old('slug') }}" class="focus:shadow-primary-outline dark:bg-gray-950 dark:placeholder:text-white/80 dark:text-white/80 text-sm leading-5.6 ease block appearance-none w-full rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding p-3 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                      @error('slug')
                      <div class="invalid-feedback">
                        <span class="text-red-500">{{ $message }}</span>
                      </div>
                      @enderror
                    </div>
                    <div class="mb-4 mt-4">
                        <label for="topic" class="text-gray-700">Topic</label>
                        <select name="topic_id" class="block w-full bg-white border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring placeholder:text-gray-500 focus:border-fuchsia-300">
                            @foreach ($topics as $topic)
                              @if(old('topic_id') == $topic->id)
                                <option value="{{ $topic->id }}" selected>{{ $topic->name }}</option>
                              @else
                                <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                              @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4 mt-4">
                        <label for="body" class="text-gray-700">Body</label>
                        <div class="invalid-feedback">
                          @error('body')
                            <span class="text-red-500">{{ $message }}</span>
                          @enderror
                        </div>
                        <textarea name="body" id="editor" value="{{ old('body') }}"></textarea>
                    </div>
                    </div>
                    <div class="text-center">
                      <button type="submit" class="inline-block min-w-min px-5 py-2.5 mt-6 mb-2 font-bold text-center text-white align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer active:opacity-85 hover:-translate-y-px hover:shadow-xs leading-normal text-sm ease-in tracking-tight-rem shadow-md bg-150 bg-x-25 bg-gradient-to-tl from-zinc-800 to-zinc-700 hover:border-slate-700 hover:bg-slate-700 hover:text-white">Save</button>
                    </div>
                  </form>
                </div>
            </div>
        </div>
    </div>
    
</div>

<script>
  const title = document.querySelector('#title');
  const slug = document.querySelector('#slug');

  title.addEventListener('change', function() {
    fetch('/admin/articles/checkSlug?title=' + title.value)
      .then(response => response.json())
      .then(data => slug.value = data.slug)
  });
</script>

<script>
	ClassicEditor
		.create( document.querySelector( '#editor' ),
        {
            ckfinder:
            {
                uploadUrl:"{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
            }
        })
		.catch( error => {
			console.error( error );
		} );
</script>
@endsection