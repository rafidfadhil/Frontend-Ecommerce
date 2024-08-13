@extends('admin.layouts.main')

@section('content')

<div class="w-full px-8 py-6 mx-auto">
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div
                class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                <div class="px-6 py-8">
                <form role="form" method="POST" action="/admin/lessons/{{ $lesson->id }}">
                  @method('put')
                  @csrf
                    <div class="mb-4 mt-4">
                      <label for="title" class="text-gray-700">Title</label>
                      <input type="text" @error('title') is-invalid @enderror name="title" id="title" placeholder="Title" value="{{ old('title', $lesson->title) }}" required class="focus:shadow-primary-outline dark:bg-gray-950 dark:placeholder:text-white/80 dark:text-white/80 text-sm leading-5.6 ease block appearance-none w-full rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding p-3 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                      @error('title')
                      <div class="invalid-feedback">
                        <span class="text-red-500">{{ $message }}</span>
                      </div>
                      @enderror
                    </div>
                    <div class="mb-4 mt-4">
                        <label for="course" class="text-gray-700">Course</label>
                        <select name="course_id" value="{{ old('course_id', $article->course->name) }}" class="block w-full bg-white border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring placeholder:text-gray-500 focus:border-fuchsia-300">
                            @foreach ($courses as $course)
                              @if(old('course_id', $lesson->course_id) == $course->id)
                                <option value="{{ $course->id }}" selected>{{ $course->name }}</option>
                              @else
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                              @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4 mt-4">
                      <label for="url" class="text-gray-700">Video Link</label>
                      <input type="text" @error('url') is-invalid @enderror name="url" id="url" placeholder="Link" value="{{ old('url', $lesson->url) }}" class="focus:shadow-primary-outline dark:bg-gray-950 dark:placeholder:text-white/80 dark:text-white/80 text-sm leading-5.6 ease block appearance-none w-full rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding p-3 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                      @error('url')
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

@endsection