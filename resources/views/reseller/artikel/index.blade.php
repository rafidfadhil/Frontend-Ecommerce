@extends('layouts.reseller')

@section('style')
@endsection

@section('content')
<div class="px-5 mt-3">
@foreach($data as $topic)
    <h3 class="mt-3">{{$topic->name}}</h3>
    @foreach($topic->articles as $article)
        <div class="container">
            <a  data-bs-toggle="collapse" href="#collapse{{$article->id}}" role="button" aria-expanded="false" aria-controls="collapse{{$article->id}}">
                <div class="row justify-content-between bg-gray rounded">
                    <div class="m-2 col-auto fs-5">
                        {{$article->title}}
                    </div>
                    <div class="m-2 pt-1 col-auto">
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                </div>
            </a>
        </div>
        <div class="collapse mt-2" id="collapse{{$article->id}}">
            <div class="card card-body">
                {!!$article->body!!}
            </div>
        </div>
    @endforeach
@endforeach
</div>

<style>
    .bg-gray{
        background-color: rgb(226, 226, 226);
    }
</style>
@endsection

@section('script')
@endsection
