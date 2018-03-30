@extends('layouts.app')

@section('content')

    <h1 class="h1-responsive">@lang('messages.SupportForum')</h1>

    <div class='text-xs-right mb-2'>
        <a href='/support/post' class="btn btn-danger btn-rounded"><i class="fa fa-pencil"></i> &nbsp; &nbsp; @lang('messages.AddPost')</a>
    </div>

    <div style="position:fixed; bottom:45px; right:24px;">
        <a href='/support/post' class="btn-floating btn-large red" title='@lang('messages.AddPost')'>
            <i class="fa fa-pencil"></i>
        </a>
    </div>

    @foreach($posts as $post)
        
        <section class="mb-2 grey lighten-4 support_post">
            <div class="row sticky">
                <!--Avatar-->
                <div class="col-xs-12 col-sm-1">
                    <img src="{{ $post->user->avatar }}" class="img-fluid rounded-circle z-depth-2">
                </div>

                <!--Author Data-->
                <div class=" col-xs-12 col-sm-11">
                    <p style='margin-bottom:0;'><strong>{{ $post->user->name }}</strong></p>
                    <div class="personal-sm">
                        <small style='font-size:15px; color:#777;'><i class='fa fa-clock-o'></i> {{ date('d.m.Y H:i',strtotime($post->created_at)) }}</small>
                    </div>
                    <p class='lead'>{!! nl2br($post->body) !!}</p>
                </div>
            </div>
        </section>
        
        @if (count($post->comments))
        <section class='support_comments'>
            <div class='row'>
                <div class='col-sm-11 offset-sm-1'>
                    <h3 class='ml-1'>@lang('messages.Comments') <span class="tag info-color">{{ count($post->comments) }}</span></h3>
                </div>
            </div>

            @foreach($post->comments as $comment)

                <div class="row">

                    <!--Image column-->
                    <div class="col-sm-2 offset-sm-1 col-xs-12">
                        <img src="{{ $comment->user->avatar }}" class="img-fluid rounded-circle z-depth-2 ml-1 avatar">
                    </div>
                    <!--/.Image column-->

                    <!--Content column-->
                    <div class="col-sm-9 col-xs-12">
                        <h4 class="user-name">{{ $comment->user->name }}</h4>
                        <div class="card-data">
                            <ul>
                                <li class="comment-date"><i class="fa fa-clock-o"></i> {{ date('d.m.Y H:i', strtotime($comment->created_at)) }}</li>
                            </ul>
                        </div>

                        <p class="comment-text">{!! nl2br($comment->body) !!}</p>
                    </div>
                    <!--/.Content column-->

                </div>

            @endforeach

        </section>
        @endif

        <section class='support-reply-form'>

            <div class='row'>
                <div class='col-sm-11 offset-sm-1'>

                    <!--Leave a reply form-->
                    <div class="reply-form ml-1">
                        <h3 class="section-heading">@lang('messages.LeaveComment')</h3>

                        <!--Third row-->
                        <div class="row">
                            <!--Image column-->
                            <div class="col-sm-2 col-xs-12">
                                <img src="{{ Auth::user()->avatar }}">
                            </div>
                            <!--/.Image column-->

                            <!--Content column-->
                            {{Form::open(['route' => ['support.comment',$post->id], 'method'=>'put', 'files'=>false])}}
                            <div class="col-sm-10 col-xs-12">
                                <div class="md-form">
                                    <textarea type="text" name='body' id="form8" class="md-textarea"></textarea>
                                    <label for="form8">@lang('messages.YourMessage')</label>
                                </div>
                                @if ($errors->has('body'))
                                    <p class="text-danger form-error-msg">{{ $errors->first('body') }}</p>
                                @endif

                            </div>

                            <div class="text-xs-center">
                                <button class="btn btn-primary">@lang('messages.Submit')</button>
                            </div>
                            <!--/.Content column-->
                            {{Form::close()}}

                        </div>
                        <!--/.Third row-->
                    </div>
                    <!--/.Leave a reply form-->
                </div>
            </div>

        </section>
        <!--/Section: Leave a reply (Logged In User)-->

    @endforeach

    {!! $posts->links() !!}

@endsection