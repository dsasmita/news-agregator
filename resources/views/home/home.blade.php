@extends('layouts.layout-master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-7">
            @foreach($newsList as $news)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="title-list">
                        <a href="{{route('news.detail', [$news->id, str_slug($news->title)])}}">
                            {{$news->title}}
                        </a>
                    </h2>
                </div>

                <div class="panel-body">
                    <div class="list-info">
                        <a href="#" class="btn btn-default btn-xs hidden">
                            <span class="glyphicon glyphicon-share" aria-hidden="true"></span>
                            share
                        </a>

                        @if($news->portal()->first())
                            <a href="#" class="btn btn-default btn-xs">
                                <span class="glyphicon glyphicon-magnet" aria-hidden="true" title="date pusblish"></span>
                                &nbsp;{{$news->portal()->first()->title}}
                            </a>
                        @endif

                        &nbsp;
                        <a href="#" class="btn btn-default btn-xs">
                            <span class="glyphicon glyphicon-th-large" aria-hidden="true" title="date pusblish"></span>
                            &nbsp;{{$news->kanal_index}}
                        </a>

                        &nbsp;
                        <a href="#" class="btn btn-default btn-xs">
                            <span class="glyphicon glyphicon-calendar" aria-hidden="true" title="date pusblish"></span>
                            &nbsp;{{date('dM Y, H:i',strtotime($news->date_publish))}} WIB
                        </a>
                    </div>
                </div>
            </div>
            @endforeach

            <div class="text-center">
                {{ $newsList->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
