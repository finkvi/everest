@extends('layouts.app')

@section('content')

    <h1 class="h1-responsive">@lang('messages.AddingSupportPost')</h1>

    {{Form::open(['route' => ['support.post'], 'method'=>'post', 'files'=>false])}}

        <!--Section: Leave a reply (Logged In User)-->
        <section>

            <!--Leave a reply form-->
            <div class="reply-form">
                <!--Third row-->
                <div class="row">

                    <!--Content column-->
                    <div class="col-sm-12 col-xs-12">
                        <div class="md-form">
                            <textarea name='body' type="text" id="form8" class="md-textarea" style="height:100px;"></textarea>
                            <label for="form8">@lang('messages.YourMessage')</label>
                        </div>
                        
                        @if ($errors->has('body'))
                            <p class="text-danger form-error-msg">{{ $errors->first('body') }}</p>
                        @endif

                    </div>

                    <div class="text-xs-left">
                        <button class="btn btn-primary">@lang('messages.Submit')</button>
                    </div>
                    <!--/.Content column-->

                </div>
                <!--/.Third row-->
            </div>
            <!--/.Leave a reply form-->

        </section>
        <!--/Section: Leave a reply (Logged In User)-->




    {{Form::close()}}


@endsection