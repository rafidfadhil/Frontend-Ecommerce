@extends('layouts.supplier')

@section('content')
    <header class="page-header page-header-dark overlay overlay-10" style="background-color: rgb(129, 62, 62)">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fa-solid fa-rectangle-list me-3 text-white"></i></div>
                            Course
                        </h1>
                        <div class="page-header-subtitle mt-3 text-white">
                            Selamat datang di halaman Course kami, di mana Anda dapat menemukan berbagai materi pembelajaran informatif dan terbaru yang di susun berdasarkan topik tertentu. Klik pada
                            judul course untuk mempelajari lebih lanjut.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <br><br>
    <div class="container-xl px-4">
        @if (!empty($data) && (is_array($data) || $data instanceof \Countable))
            @foreach ($data as $topic)
                <div class="card p-4 mb-5">
                    <h2 class="mb-4">{{ $topic->name }}</h2>
                    <div class="row">
                        @foreach ($topic->lessons as $lesson)
                            <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-4">
                                <div class="card h-100 shadow-sm">
                                    <img src="{{ $lesson->thumbnail }}" class="card-img-top" alt="Thumbnail" style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $lesson->title }}</h5>
                                        <p class="card-text">{{ Str::limit(strip_tags($lesson->description), 100, '...') }}</p>
                                        <button type="button" class="btn btn-primary openVideoModal" data-url="{{ $lesson->url }}" data-bs-toggle="modal" data-bs-target="#videoModal">Buka</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @else
            <div class="alert alert-warning" role="alert">
                Tidak ada artikel yang tersedia saat ini.
            </div>
        @endif
    </div>

    <!-- Modal -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="videoModalLabel">Video Pelajaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="ratio ratio-16x9">
                        <iframe id="videoFrame" src="" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Event listener untuk tombol buka video
            var videoButtons = document.querySelectorAll('.openVideoModal');

            videoButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var url = button.getAttribute('data-url');
                    var videoFrame = document.getElementById('videoFrame');
                    videoFrame.src = url;
                });
            });

            // Reset video saat modal ditutup
            var videoModal = document.getElementById('videoModal');
            videoModal.addEventListener('hide.bs.modal', function() {
                var videoFrame = document.getElementById('videoFrame');
                videoFrame.src = '';
            });
        });
    </script>
@endsection

@section('script')
@endsection
