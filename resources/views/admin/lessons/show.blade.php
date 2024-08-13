@extends('admin.layouts.main')

@section('content')
    <div class="w-full px-8 py-6 mx-auto">

        <div class="flex flex-wrap -mx-3">
            <div class="flex-none w-full max-w-full px-3">
                <div
                    class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                    <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                        <p class="font-bold">Course: {{ $lesson->course->name}}</p>
                    </div>
                    <div class="px-6 py-8">
                        <div class="container mx-auto">
                            <p>Judul: {{ $lesson->title}}</p>
                            <div class="mt-4 mb-4">
                                <iframe width="800" height="450" src="{{ $lesson->url }}" frameborder="0" allowfullscreen></iframe>
                            </div>
                            <a href="/admin/lessons" class="inline-block px-6 py-3 mr-3 font-bold text-center text-white uppercase align-middle transition-all bg-blue-500 rounded-lg cursor-pointer leading-normal text-xs ease-in tracking-tight-rem shadow-xs bg-150 bg-x-25 hover:-translate-y-px active:opacity-85 hover:shadow-md mb-4">Go back to lessons</a>
                        </div>
                        
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection



