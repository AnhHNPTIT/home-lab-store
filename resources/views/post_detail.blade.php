@extends('layouts.master_home')

@section('title')
@if(isset($post))
{{$post->title}}
@endif
@endsection

@section('css')
<!-- Blog Style CSS -->
<link rel="stylesheet" type="text/css" href="{{asset('/home/css/blog-styles.css')}}" media="all" />
@endsection

@section('home')
@if(isset($post))
<div class="em-wrapper-main">
    <div class="container container-main">
        <div class="em-inner-main">
            <div class="em-wrapper-area02"></div>
            <div class="em-main-container em-col2-left-layout">
                <div class="row">
                    <div class="col-sm-18 em-col-main">
                        <div class="em_post-item">
                            <div class="post-title" style="text-align:center !important;">
                                <h1 style="margin-top : 10px; font-size: 28px; font-weight:600 !important; text-transform: capitalize !important;">{{$post->title}}</h1>
                            </div>
                            <div class="post-footer">
                                <span class="post-by">Đăng bởi: <span>{{$post->admin_name}}</span></span>
                                <span class="post-time"><small class="time-stamp">{{Carbon\Carbon::parse($post->created_at)->toDateString()}}</small></span>
                                <span>
                                    <small>
                                        <i class="fa fa-eye"></i> {{$post->view_count}}
                                    </small>
                                </span>
                            </div>
                            <div class="" style="text-align : justify; font-weight: bold; font-style: italic;">
                                <p>
                                    {!!$post->description!!}
                                </p>
                            </div>
                            <div class="" style="text-align : justify;">
                                <p>
                                    {!!$post->content!!}
                                </p>
                            </div>

                            <div class="em_post-action">
                                <div class="tags">
                                    <ul class="tags-post">
                                        @if(isset($post_tags))
                                        @foreach($post_tags as $value)
                                        <li class="tag-post">
                                            <a href="{{ url('/tag/'.$value->slug) }}">{{$value->name}}</a>
                                        </li>
                                        @endforeach
                                        @endif
                                    </ul>

                                    <style>
                                        .tags-post {
                                            list-style: none;
                                            margin: 0;
                                            overflow: hidden;
                                            padding: 0;
                                        }

                                        .tags-post li {
                                            float: left;
                                        }

                                        .tag-post {
                                            background: #eee;
                                            border-radius: 3px 0 0 3px;
                                            color: #999;
                                            display: inline-block;
                                            height: 26px;
                                            line-height: 26px;
                                            padding: 0 20px 0 23px;
                                            position: relative;
                                            margin: 0 10px 10px 0;
                                            font-size: 13px;
                                            text-decoration: none;
                                            cursor: pointer;
                                            -webkit-transition: color 0.2s;
                                        }

                                        .tag-post::before {
                                            background: #fff;
                                            border-radius: 10px;
                                            box-shadow: inset 0 1px rgba(0, 0, 0, 0.25);
                                            content: '';
                                            height: 6px;
                                            left: 10px;
                                            position: absolute;
                                            width: 6px;
                                            top: 10px;
                                        }

                                        .tag-post::after {
                                            background: #fff;
                                            border-bottom: 13px solid transparent;
                                            border-left: 10px solid #eee;
                                            border-top: 13px solid transparent;
                                            content: '';
                                            position: absolute;
                                            right: 0;
                                            top: 0;
                                        }

                                        .tag-post a:hover {
                                            color: white;
                                        }

                                        .tag-post:hover {
                                            background-color: crimson;
                                            color: white;
                                        }

                                        .tag-post:hover::after {
                                            border-left-color: crimson;
                                        }
                                    </style>
                                </div>

                            </div>

                        </div>
                    </div><!-- /.em-col-main -->

                    <div class="col-sm-6 em-sidebar">
                        @if(isset($recent_posts))
                        <div class="block em_block-recent-post em-line-01">
                            <div class="block-title" style="text-align:center;"> <strong><span style="color:#fff !important;">Bài viết gần đây</span></strong>
                            </div>
                            <div class="block-content">
                                <ul class="em-recent-post">
                                    @foreach($recent_posts as $post)
                                    <li class="item">
                                        <a href="{{ url('/tin-tuc-su-kien/'.$post->slug) }}">
                                            <img alt="{{ url('/tin-tuc-su-kien/'.$post->slug) }}" src="{{asset('/images/posts/'.$post->thumbnail)}}" />
                                        </a>
                                        <a class="post-title em-blog-title" href="{{ url('/tin-tuc-su-kien/'.$post->slug) }}" style="text-transform: capitalize !important;">
                                            {{$post->title}}
                                        </a>
                                        <p class="intro">
                                            <p style="text-align : justify;">
                                                <span>
                                                    {{subStr($post->description, 0, 60)}}...
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
                                    <li class="item"><a href="{{ url('/tag/'.$tag->slug) }}" style="font-size:122px; color: #3E6807;">{{$tag->name}}</a>
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