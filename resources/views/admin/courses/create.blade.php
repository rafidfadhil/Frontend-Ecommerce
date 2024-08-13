@extends('admin.layouts.main')

@section('content')

<div class="w-full px-8 py-6 mx-auto">
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div
                class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                <div class="px-6 py-8">
                <form role="form" method="POST" action="/admin/courses" enctype='multipart/form-data'>
                  @csrf
                    <div class="mb-4 mt-4">
                      <label for="name" class="text-gray-700">Name</label>
                      <input type="text" @error('name') is-invalid @enderror name="name" id="name" placeholder="Name" required class="focus:shadow-primary-outline dark:bg-gray-950 dark:placeholder:text-white/80 dark:text-white/80 text-sm leading-5.6 ease block appearance-none w-full rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding p-3 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                      @error('name')
                      <div class="invalid-feedback">
                        <span class="text-red-500">{{ $message }}</span>
                      </div>
                      @enderror
                    </div>
                    <div class="mb-4 mt-4">
                      <label for="description" class="text-gray-700">Description</label>
                      <input type="text" @error('description') is-invalid @enderror name="description" id="description" placeholder="Description" class="focus:shadow-primary-outline dark:bg-gray-950 dark:placeholder:text-white/80 dark:text-white/80 text-sm leading-5.6 ease block appearance-none w-full rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding p-3 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                      @error('description')
                      <div class="invalid-feedback">
                        <span class="text-red-500">{{ $message }}</span>
                      </div>
                      @enderror
                    </div>
                    <div class="mb-4 mt-4">
                        <label for="thumbnail" class="text-gray-700">Thumbnail</label>
                        <img class="img-preview img-fluid mb-2 w-5/12">
                        <input type="file" @error('thumbnail') is-invalid @enderror name="thumbnail" id="thumbnail" onchange="previewImage()" class="focus:shadow-primary-outline dark:bg-gray-950 dark:placeholder:text-white/80 dark:text-white/80 text-sm leading-5.6 ease block appearance-none w-full rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding p-3 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none file:bg-blue-500 file:rounded-lg" />
                        @error('thumbnail')
                        <div class="invalid-feedback">
                          <span class="text-red-500">{{ $message }}</span>
                        </div>
                        @enderror
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
    function previewImage() {
        const thumbnail = document.querySelector('#thumbnail');
        const imgPreview = document.querySelector('.img-preview');  

        imgPreview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(thumbnail.files[0]);

        oFReader.onload = function (oFREvent) {
            imgPreview.src = oFREvent.target.result;
        }
    }
</script>

@endsection