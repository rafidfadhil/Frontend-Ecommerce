@extends('layouts.reseller')

@section('style')
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
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">
            <div class="page-meta">
                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/reseller">MITRA ID</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Member</li>
                    </ol>
                </nav>
            </div>
            <div class="row layout-top-spacing">
                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                    <div class="widget-content widget-content-area br-8">
                        <div class="card-body chat-box" id="chat-box">
                            @foreach ($forums as $item)
                                @if ($item->forum_user_id != Auth::user()->id)
                                    <div class="chat-message mb-3">
                                        <div class="d-flex">
                                            <img src="{{ asset('images') }}/{{ $item->user_avatar }}" alt="Avatar" class="rounded-circle me-3 img-fluid"
                                                style="width: 50px; height: 50px; object-fit: cover;">
                                            <div class="message-content">
                                                <div class="message-author fw-bold">{{ $item->user_name }} <span class="text-muted small fw-light">{{ $item->created_at }}</span></div>
                                                <div class="message-text">{{ $item->forum_message }}</div>
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
                                    <div class="chat-message mb-3 text-end" style="padding-left: 60%">
                                        <div class="d-flex flex-row-reverse">
                                            <img src="{{ asset('images') }}/{{ $item->user_avatar }}" alt="Avatar" class="rounded-circle ms-3 img-fluid"
                                                style="width: 50px; height: 50px; object-fit: cover;">
                                            <div class="message-content">
                                                <div class="message-author fw-bold text-blue"><span class="text-muted small">{{ $item->created_at }}</span> {{ $item->user_name }} </div>
                                                <div class="message-text">{{ $item->forum_message }}</div>
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
                                @endif
                            @endforeach
                        </div>

                        <div class="card-footer">
                            <form action="/reseller/forum/store" method="POST" id="chat-form" enctype="multipart/form-data">
                                @csrf
                                <div class="input-group">
                                    <input type="hidden" name="forum_supplier_id" value="{{ $supplier_id }}">
                                    <input type="hidden" name="forum_user_id" value="{{ Auth::user()->id }}">
                                    <input type="text" class="form-control" name="forum_message" placeholder="Ketik pesan Anda di sini...">
                                    <input type="file" class="form-control" name="forum_attachment">
                                    <button class="btn btn-primary" type="submit">Kirim</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var chatBox = document.getElementById('chat-box');
            chatBox.scrollTop = chatBox.scrollHeight;
        });
    </script>
@endsection
