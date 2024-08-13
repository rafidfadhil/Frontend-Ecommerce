@extends('admin.layouts.main')

@section('content')
    <div class="w-full px-8 py-6 mx-auto">

        <div class="flex flex-wrap -mx-3">
            <div class="flex-none w-full max-w-full px-3">
                <div
                    class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                    <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                        <p class="font-bold">Kategori: {{ $article->topic->name}}</p>
                    </div>
                    <div class="px-6 py-8">
                        <div class="container mx-auto">
                            <p>Judul: {{ $article->title}}</p>
                            <div id="articleContent" class="mb-4 mt-4">
                                {!! $article->body !!}
                            </div>
                        </div>
                        
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll( 'oembed[url]' ).forEach( element => {
            // Create the <a href="..." class="embedly-card"></a> element that Embedly uses
            // to discover the media.
            const anchor = document.createElement( 'a' );
    
            anchor.setAttribute( 'href', element.getAttribute( 'url' ) );
            anchor.className = 'embedly-card';
    
            element.appendChild( anchor );
        } );
    </script>
    
@endsection



