@extends('layouts.supplier')

@section('content')
    <header class="page-header page-header-dark overlay overlay-10" style="background-color: rgb(129, 62, 62)">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fa-solid fa-rectangle-list me-3 text-white"></i></div>
                            Artikel
                        </h1>
                        <div class="page-header-subtitle mt-3 text-white">
                            Selamat datang di halaman artikel kami, di mana Anda dapat menemukan berbagai artikel informatif dan terbaru yang disusun berdasarkan topik tertentu. Klik pada judul artikel
                            untuk membaca lebih lanjut.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <br><br><br><br><br><br>
    <div class="container-xl px-4 mt-n10">
        @if (!empty($data) && (is_array($data) || $data instanceof \Countable))
            @foreach ($data as $topic)
                <h1 class="mt-3">{{ $topic->name }}</h1>
                @foreach ($topic->articles as $article)
                    <div class="container">
                        <a data-bs-toggle="collapse" href="#collapse{{ $article->id }}" role="button" aria-expanded="false" aria-controls="collapse{{ $article->id }}">
                            <div class="row justify-content-between bg-dark rounded">
                                <div class="m-2 col-auto fs-5 text-center ">
                                    <span class="text-white">{{ $article->title }}</span>
                                </div>
                                <div class="m-2 pt-1 col-auto">
                                    <i class="fa-solid fa-chevron-down text-white"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="collapse mt-2" id="collapse{{ $article->id }}">
                        <div class="card card-body">
                            {!! $article->body !!}
                        </div>
                    </div>
                    <br>
                @endforeach
            @endforeach
        @else
            <div class="alert alert-warning" role="alert">
                Tidak ada artikel yang tersedia saat ini.
            </div>
        @endif
    </div>
@endsection
