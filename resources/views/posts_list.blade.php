@extends('layouts.master_home')

@section('title')
@if(isset($title))
{{$title}}
@else
Tin tức - Sự kiện- Home Lab
@endif
@endsection

@section('css')
<!-- Blog Style CSS -->
<link rel="stylesheet" type="text/css" href="{{asset('/home/css/blog-styles.css')}}" media="all" />
@endsection

@section('home')
@if(isset($posts))
<div class="em-wrapper-main">
    <div class="container container-main">
        <div class="em-inner-main">
            <div class="em-wrapper-area02"></div>
            <div class="em-main-container em-col2-left-layout">
                <div class="row">
                    <div class="col-sm-18 em-col-main">
                        <div class="em_post-items">
                            @if(isset($posts))
                            @foreach($posts as $post)
                            <div class="em_post-item">
                                <div class="post-title">
                                    <h1 style="margin-top : 10px; font-size: 20px; font-weight:600 !important; text-transform: capitalize !important;">
                                        <a href="{{ url('/ban-tin-suc-khoe/'.$post->slug) }}">
                                            {{$post->title}}
                                        </a>
                                    </h1>
                                </div>
                                <div class="post-header">
                                    <p class="post-by">
                                        <span class="post-user">
                                            <span>{{$post->admin_name}}</span>
                                        </span>
                                    </p>
                                    <span class="post-time">
                                        <small class="time-stamp">
                                            {{Carbon\Carbon::parse($post->created_at)->toDateString()}}
                                        </small>
                                    </span>
                                    <span>
                                        <small>
                                            <i class="fa fa-eye"></i> {{$post->view_count}}
                                        </small>
                                    </span>

                                </div>
                                <div class="post-image col-sm-8">
                                    <a href="{{ url('/ban-tin-suc-khoe/'.$post->slug) }}">
                                        <img class="img-responsive" alt="{{$post->title}}" src="{{asset('/images/'.$post->thumbnail)}}" />
                                    </a>
                                </div>
                                <div class="post-content col-sm-15">
                                    <div class="std" style="text-align : justify;">
                                        <p>
                                            <span>
                                                {!! subStr($post->description, 0, 600) !!}...
                                            </span>
                                        </p>
                                    </div>
                                    <div style="text-align:right;">
                                        <a href="{{ url('/ban-tin-suc-khoe/'.$post->slug) }}">
                                            <p>Xem thêm</p>
                                        </a>
                                    </div>
                                </div>
                            </div><!-- /.em_post-item -->
                            @endforeach
                            @endif
                        </div><!-- /.em_post-items -->

                        <div>
                            {!! $posts->links('vendor.pagination.default'); !!}
                        </div>
                    </div><!-- /.em-col-main -->

                    <div class="col-sm-6 em-sidebar">
                        @if(isset($recent_posts))
                        <div class="block em_block-recent-post em-line-01">
                            <div class="block-title" style="text-align:center;"> <strong style="color:#fff !important;"><span>Bài viết gần đây</span></strong>
                            </div>
                            <div class="block-content">
                                <ul class="em-recent-post">
                                    @foreach($recent_posts as $post)
                                    <li class="item">
                                        <a href="{{ url('/ban-tin-suc-khoe/'.$post->slug) }}">
                                            <img src="{{asset('/images/'.$post->thumbnail)}}" />
                                        </a>
                                        <a class="post-title em-blog-title" href="{{ url('/ban-tin-suc-khoe/'.$post->slug) }}" style="text-transform: capitalize !important;">
                                            {{$post->title}}
                                        </a>
                                        <p class="intro">
                                            <p style="text-align : justify;">
                                                <span>
                                                    {!! subStr($post->description, 0, 60) !!}...
                                                </span>
                                            </p>
                                        </p>
                                        <div class="post-header">
                                            <p class="post-by">
                                                <span class="post-user">
                                                    <span>
                                                        {{$post->admin_name}}
                                                    </span>
                                                </span>
                                            </p>
                                            <span class="post-time">
                                                <small class="time-stamp">
                                                    {{Carbon\Carbon::parse($post->created_at)->toDateString()}}
                                                </small>
                                            </span>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div><!-- /.block -->
                        @endif

                        <div class="block em_block-tag-cloud em-line-01">
                            <div class="block-title" style="text-align:center;"> <strong style="color:#fff !important;"><span>Từ khóa phổ biến</span></strong>
                            </div>
                            <div class="block-content">
                                <ul>
                                    @if(isset($tags))
                                    @foreach($tags as $tag)
                                    <li class="item">
                                        <a href="{{ url('/tag/'.$tag->slug) }}" style="font-size:122px; color: #3E6807;">{{$tag->name}}</a>
                                    </li>
                                    @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div><!-- /.block -->
                    </div><!-- /. em-sidebar -->
                </div>
            </div><!-- /.em-main-container -->
        </div>
    </div>
</div>
@endif
@endsection