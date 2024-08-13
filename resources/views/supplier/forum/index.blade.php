@extends('layouts.supplier')

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .chat-box {
            max-height: 500px;
            overflow-y: scroll;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .chat-message {
            margin-bottom: 20px;
            display: flex;
        }

        .chat-message .avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 15px;
        }

        .chat-message .message-content {
            background-color: #ffffff;
            padding: 10px 15px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .chat-message .message-author {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .chat-message .message-time {
            font-size: 0.85em;
            color: gray;
        }

        .chat-message .message-text {
            margin-top: 5px;
        }

        .card-footer {
            background-color: #f9f9f9;
            border-top: 1px solid #ddd;
        }
    </style>
@endsection

@section('content')
    <header class="page-header page-header-dark pb-10 overlay overlay-10" style="background-color: rgb(148, 99, 34)">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fa-solid fa-file-invoice me-3 text-white"></i></div>
                            Forum Member
                        </h1>
                        <div class="page-header-subtitle mt-3 text-white">Dashboard ini menampilkan informasi terkini mengenai diskusi antaranggota. Semua informasi yang diperlukan dari pemasok tersedia
                            di
                            sini. Selain itu, halaman ini juga menyediakan update terbaru dan fitur interaktif untuk memudahkan anggota berkomunikasi dan berbagi pengetahuan.</div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container-xl px-4 mt-n10">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center py-3 bg-light">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('supplier.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Forum Member</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body chat-box p-4" style="max-height: 500px; overflow-y: auto;" id="chat-box">
                @foreach ($forums as $item)
                    @if ($item->forum_user_id != Auth::user()->id)
                        <div class="chat-message mb-3">
                            <div class="d-flex">
                                <img src="{{ asset('images/' . $item->user_avatar) }}" alt="Avatar" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                <div class="message-content bg-light p-3 shadow-sm" style="border-radius: 15px;">
                                    <div class="message-author fw-bold text-primary"><span class="text-muted small">{{ $item->created_at }}</span> {{ $item->user_name }}</div>
                                    <div class="message-text mt-2">{{ $item->forum_message }}</div>
                                    @if ($item->forum_attachment)
                                        @if (in_array(pathinfo($item->forum_attachment, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                            <div class="mt-2">
                                                <img src="{{ asset('attachment/' . $item->forum_attachment) }}" alt="forum_attachment" class="img-fluid"
                                                    style="max-width: 100%; max-height: 200px; object-fit: cover; border-radius: 10px;">
                                            </div>
                                        @else
                                            <div class="mt-2">
                                                <a href="{{ asset('attachment/' . $item->forum_attachment) }}" class="btn btn-primary btn-sm" download>Download Attachment</a>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="chat-message mb-3 text-end">
                            <div class="d-flex flex-row-reverse">
                                <img src="{{ asset('images/' . $item->user_avatar) }}" alt="Avatar" class="rounded-circle ms-3" style="width: 50px; height: 50px; object-fit: cover;">
                                <div class="message-content bg-light p-3 shadow-sm" style="border-radius: 15px;">
                                    <div class="message-author fw-bold text-primary"><span class="text-muted small">{{ $item->created_at }}</span> {{ $item->user_name }}</div>
                                    <div class="message-text mt-2">{{ $item->forum_message }}</div>
                                    @if ($item->forum_attachment)
                                        @if (in_array(pathinfo($item->forum_attachment, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                            <div class="mt-2">
                                                <img src="{{ asset('attachment/' . $item->forum_attachment) }}" alt="forum_attachment" class="img-fluid"
                                                    style="max-width: 100%; max-height: 200px; object-fit: cover; border-radius: 10px;">
                                            </div>
                                        @else
                                            <div class="mt-2">
                                                <a href="{{ asset('attachment/' . $item->forum_attachment) }}" class="btn btn-primary btn-sm" download="{{ basename($item->forum_attachment) }}">Download
                                                    Attachment</a>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="card-footer">
                <form action="/supplier/forum/store" method="POST" id="chat-form" enctype="multipart/form-data">
                    @csrf
                    <div class="input-group">
                        <input type="hidden" name="forum_supplier_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="forum_user_id" value="{{ Auth::user()->id }}">
                        <input type="text" class="form-control" name="forum_message" placeholder="Ketik pesan Anda di sini...">
                        <input type="file" class="form-control" name="forum_attachment">
                        <button class="btn btn-primary" type="submit">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var chatBox = document.getElementById('chat-box');
            chatBox.scrollTop = chatBox.scrollHeight;
        });
    </script>
@endsection
