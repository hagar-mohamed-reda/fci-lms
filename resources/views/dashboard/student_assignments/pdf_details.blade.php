@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">
        <section class="content container-fluid">
            <section class="content-header">
                <h1>@lang('site.student_assignments')</h1>
                <ol class="breadcrumb">
                    <li><a href=" {{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                    {{--<li> <a href=" {{route('dashboard.lessons.pdf_details')}}">@lang('site.lessons')</a></li>--}}
                    <li class="active">@lang('site.details')</li>

                </ol>
            </section>
            <section class="content">

                <div class="box box-primary">

                    <div class="box-header">
                        <h3 class="box-title">@lang('site.details')</h3>
                    </div>

                    <div class="box-body">

                        {{--<p style="text-align: center">
                            <iframe src="{{url('uploads/anssers/'.$data->pdf_anss)}}"
                                    style="width: 700px; height:500px"></iframe>
                        </p>--}}

                        <embed src="https://docs.google.com/viewerng/viewer?url={{url('uploads/anssers/'.$data->pdf_anss)}}&embedded=true" width="100%" height="500px" type="application/pdf">

                    </div>
                </div>

            </section>
        </section>


    </div>

@endsection
