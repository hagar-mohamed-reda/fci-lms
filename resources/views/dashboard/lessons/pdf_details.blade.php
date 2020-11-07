@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">
        <section class="content container-fluid">
            <section class="content-header">
                <h1>@lang('site.lessons')</h1>
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
                        {{--<embed src="{{url('uploads/lessons/'.$data->pdf_file)}}" width="100%" height="500px" type="application/pdf">
                        <object data="{{url('uploads/lessons/'.$data->pdf_file)}}" type="application/pdf">
                            <iframe src="https://docs.google.com/viewer?url={{url('uploads/lessons/'.$data->pdf_file)}}&embedded=true" type="application/pdf"
                                    style="width: 700px; height:500px"></iframe>
                        </object>
                        <a href="{{url('/uploads/web/viewer.html?file='.$data->pdf_file)}}">view</a>
                        <embed src="https://docs.google.com/viewer?url={{url('uploads/lessons/'.$data->pdf_file)}}&embedded=true" width="100%" height="500px" type="application/pdf">

                        <embed src="https://mozilla.github.io/pdf.js/web/viewer.html?file={{url('uploads/lessons/'.$data->pdf_file)}}"
                            width="100%" height="500px" type="application/pdf">

                        <embed src="/web/viewer.html?file=%2F{{('/uploads/lessons/'.$data->pdf_file)}}" width="100%" height="500px" type="application/pdf">

                        <embed src="{{url('/uploads/web/viewer.html?file='.$data->pdf_file)}}" width="100%" height="500px" type="application/pdf">
                        --}}
                        <embed src="https://docs.google.com/viewerng/viewer?url={{url('uploads/lessons/'.$data->pdf_file)}}&embedded=true" width="100%" height="500px" type="application/pdf">


                    </div>
                </div>

            </section>
        </section>


    </div>

@endsection
