@extends('admin.layouts.main')

@section('content')
    <div class="w-full px-8 py-6 mx-auto">

        <div class="flex flex-wrap -mx-3">
            <div class="flex-none w-full max-w-full px-3">
                <div
                    class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                    <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                        <p class="font-bold">Course Details</p>
                    </div>
                    <div class="px-6 py-8">
                        <div class="container mx-auto">
                            <p class="mb-2 font-bold">Name</p>
                            <p class="mb-2">{{ $course->name}}</p>
                            <p class="mb-2 font-bold">Description</p>
                            <p class="mb-2">{{ $course->description}}</p>
                            <p class="mb-2 font-bold">Thumbnail</p>
                            @if ($course->thumbnail != null)
                                <img src="{{ asset('storage/' . $course->thumbnail) }}" class="img-preview img-fluid mb-2 w-5/12 block">
                            @else
                                <p class="mb-2">No thumbnail</p>
                            @endif
                            
                            <p class="mb-2 font-bold">Lessons</p>
                            @if ($course->lessons->isEmpty())
                                <p class="mb-2">This course has no lessons yet.</p>
                            @else
                                @foreach ($course->lessons as $lesson)
                                    <div class="mt-4 mb-4">
                                        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl rounded-2xl bg-clip-border w-1/2 mb-4 hover:border-blue-500">
                                            <div class="flex-auto p-4">
                                                <div class="flex flex-wrap -mx-3">
                                                    <div class="max-w-full px-3 lg:w-1/2 lg:flex-none">
                                                        <div class="flex flex-col h-full">
                                                            <h6 class="">{{ $lesson->title }}</h6>
                                                            <a class="mt-auto mb-0 font-semibold leading-normal text-sm group text-slate-500" href="/admin/lessons/{{ $lesson->id }}">
                                                                View Lesson
                                                                <i class="fas fa-arrow-right ease-bounce text-sm group-hover:translate-x-1.25 ml-1 leading-normal transition-all duration-200"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="max-w-full px-3 mt-12 ml-auto text-center lg:mt-0 lg:w-5/12 lg:flex-none">
                                                        <div class="h-full bg-gradient-to-tl from-blue-500 to-violet-500 rounded-xl">
                                                            <img src="{{ $lesson->thumbnail_url }}" class="absolute top-0 hidden w-1/2 h-full lg:block" alt="waves" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            <a href="/admin/courses" class="inline-block px-6 py-3 mr-3 font-bold text-center text-white uppercase align-middle transition-all bg-blue-500 rounded-lg cursor-pointer leading-normal text-xs ease-in tracking-tight-rem shadow-xs bg-150 bg-x-25 hover:-translate-y-px active:opacity-85 hover:shadow-md mb-4 mt-2">Go back to courses</a>
                        
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection



