@extends('layouts.reseller')

@section('style')
@endsection

@section('content')
    <div class="px-4 mt-3">
        <ul class="nav bg-gray rounded">
            @foreach ($data as $course)
                <li class="nav-item">
                    <a class="nav-link active collapseToggle" aria-current="page" data-bs-toggle="collapse" href="#collapse{{ $course->id }}" role="button" aria-expanded="false"
                        aria-controls="collapse{{ $course->id }}">{{ $course->name }}</a>
                </li>
            @endforeach
        </ul>

        @foreach ($data as $i => $course)
            <div class="collapse mt-2" id="collapse{{ $course->id }}">
                <div class="card card-body">
                    <div class="row">
                        @foreach ($course->lessons as $lesson)
                            <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-4 col-sm-6 mb-4">
                                <img src="{{ $lesson->thumbnail }}" class="card-img-top" style="width: 100%; height: 200px; overflow: hidden;">
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-12 mb-4">
                                            <b>{{ $lesson->title }}</b>
                                        </div>
                                        <div class="col-12 text-end">
                                            <a href="{{ route('reseller.course.lesson', $lesson->id) }}">
                                                <button type="button" class="btn btn-primary">Buka</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <style>
        .bg-gray {
            background-color: rgb(226, 226, 226);
        }
    </style>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var toggleButtons = document.querySelectorAll('.collapseToggle');

            toggleButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var targetSelector = button.getAttribute('href');
                    var targetElement = document.querySelector(targetSelector);

                    var targetCollapse = new bootstrap.Collapse(targetElement, {
                        toggle: false
                    });

                    var allCollapses = document.querySelectorAll('.collapse');
                    allCollapses.forEach(function(collapse) {
                        if (collapse !== targetElement && collapse.classList.contains('show')) {
                            var bsCollapse = bootstrap.Collapse.getInstance(collapse);
                            if (bsCollapse) {
                                bsCollapse.hide();
                            }
                        }
                    });
                });
            });
        });
    </script>
@endsection
