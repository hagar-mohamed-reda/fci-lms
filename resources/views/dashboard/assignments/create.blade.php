@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">
        <section class="content container-fluid">
            <section class="content-header">
                <h1>@lang('site.assignments')</h1>
                <ol class="breadcrumb">
                    <li><a href=" {{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                    <li> <a href=" {{route('dashboard.assignments.index')}}">@lang('site.assignments')</a></li>
                    <li class="active">@lang('site.add')</li>

                </ol>
            </section>
            <section class="content">

                <div class="box box-primary">

                    <div class="box-header">
                        <h3 class="box-title">@lang('site.add')</h3>
                    </div>

                    <div class="box-body">
                        @include('partials._errors')
                        <form action="{{route('dashboard.assignments.store')}}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('post') }}

                            <div class="form-group">
                                <label>@lang('site.name')*</label>
                                <input type="text" name="name" class="form-control" value="{{old('name')}}">
                            </div>

                            <div class="form-group">
                                <label><i class="fa fa-paperclip fa-lg" aria-hidden="true"></i> @lang('site.pdf_quest')*</label>
                                <input type="file" name="pdf_quest" class="form-control" value="{{old('pdf_quest')}}">
                                <!--input type="submit" value="upload"-->
                            </div>

                            <div class="form-group" style="position: relative">
                                <label>@lang('site.start_date')*</label>
                                <input type="date" name="start_date" class="form-control" value="<?php
                                                                                                    //$dt = date("Y-m-d");
                                                                                                    //echo date( "Y-m-d", strtotime( "$dt +7 day" ) )
                                                                                                    echo date('Y-m-d'); ?>">
                            </div>

                            <div class="form-group" style="position: relative">
                                <label>@lang('site.end_date')*</label>
                                <input type="date" name="end_date" class="form-control" value="<?php
                                                                                                $dt = date("Y-m-d");
                                                                                                echo date( "Y-m-d", strtotime( "$dt +7 day" ) )
                                                                                                //echo date('Y-m-d'); ?>">
                            </div>

                            {{--<div class="form-group">
                                <label>@lang('site.ass_less')</label>
                                <input type="text" name="lesson_id"  class="form-control" value="{{$request->lesson_id}}" readonly>
                            </div>--}}

                            {{--
                            <div class="form-group">
                                <label>@lang('site.ass_less')*</label>
                                <select name="lesson_id" class="form-control">
                                    <option value="">@lang('site.lessons')</option>
                                    @foreach ($lessons as $lesson)
                                        <option value="{{$lesson->id}}" {{old('lesson_id') == $lesson->id ? 'selected' : ''}}>{{$lesson->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            --}}

                            <input type="hidden" name="lesson_id" value={{$_GET['lesson_id']}}>
                            <input type="hidden" name="sbj_id" value={{$_GET['sbj_id']}}>
                            <input type="hidden" name="doc_id" value={{auth()->user()->fid}}>




                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</button>
                            </div>
                        </form>
                    </div><!--end of box-body-->

                </div>

            </section>
        </section>


    </div>

@endsection
