@extends('layouts.layout-master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-7">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="title-list">
                        {{$news->title}}
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
                        <a href="#" class="btn btn-default btn-xs hidden-sm">
                            <span class="glyphicon glyphicon-th-large" aria-hidden="true" title="date pusblish"></span>
                            &nbsp;{{$news->kanal_index}}
                        </a>

                        &nbsp;
                        <a href="#" class="btn btn-default btn-xs">
                            <span class="glyphicon glyphicon-calendar" aria-hidden="true" title="date pusblish"></span>
                            &nbsp;{{date('dM Y, H:i',strtotime($news->date_publish))}} WIB
                        </a>
                    </div>

                    

                    <div class="detail-redirect">
                        @if($news->image_link != '')
                            <img src="{{$news->image_link}}" alt="{{$news->image_link_alt}}" class="img-responsive">
                            <hr>
                        @endif
                        {!!$news->content!!}
                    </div>

                    <div class="detail-redirect text-center">
                        <p> 
                            @if(!$news->scrap_status)
                                will be redirect to source in 5seconds ...<br>
                                klik <a href="{{$news->link_news}}??source=newsfeed.website&utm_source=newsfeed.website&utm_medium=jobs-posting&utm_campaign=jobs-posting">here</a> if not
                            @else
                                Source link:<br>
                                klik <a href="{{$news->link_news}}??source=newsfeed.website&utm_source=newsfeed.website&utm_medium=jobs-posting&utm_campaign=jobs-posting">here</a>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('extrascripts')
@if(!$news->scrap_status)
    <script type="text/javascript">
        $( document ).ready(function() {
            setTimeout(function(){
                window.location = '{{$news->link_news}}?UTM_MEDIUM=newsfeed.website';
            }, 5000);
        });
    </script>
@endif
@endsection