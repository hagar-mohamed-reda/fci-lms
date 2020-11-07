@extends('layouts.dashboard.app')

@section('content')

    @if ($_GET['udoc'] == 0)

    <div class="content-wrapper">
        <section class="content container-fluid">
            <section class="content-header">
                <h1>@lang('site.subjects')</h1>
                <ol class="breadcrumb">
                    <li><a href=" {{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                    <li> <a href=" {{route('dashboard.subjects.index')}}">@lang('site.subjects')</a></li>
                    <li class="active">@lang('site.edit')</li>

                </ol>
            </section>
            <section class="content">

                <div class="box box-primary">

                    <div class="box-header">
                        <h3 class="box-title">@lang('site.edit')</h3>
                    </div>

                    <div class="box-body">
                        @include('partials._errors')

                        <form action="{{route('dashboard.subjects.update', $subject->id)}}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('put') }}

                            <div class="form-group">
                                <label>@lang('site.name')*</label>
                                <input type="text" name="name" class="form-control" value="{{ $subject->name }}">
                            </div>

                            <div class="form-group">
                                <label>@lang('site.code')*</label>
                                <input type="text" name="code" class="form-control" value="{{ $subject->code }}">
                            </div>

                            <div class="form-group">
                                <label>@lang('site.hours')*</label>
                                <input type="number" name="hours" class="form-control" value="{{ $subject->hours }}">
                            </div>

                            <div class="form-group">
                                <label>@lang('site.description')</label>
                                <input type="text" name="description" class="form-control" value="{{$subject->description}}">
                            </div>

                            <div class="form-group">
                                <label>@lang('site.notes')</label>
                                <input type="text" name="notes" class="form-control" value="{{$subject->notes}}">
                            </div>



                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> @lang('site.edit')</button>
                            </div>
                        </form>
                    </div><!--end of box-body-->

                </div>

            </section>
        </section>


    </div>

    @else
    <div class="content-wrapper">
        <section class="content container-fluid">
            <section class="content-header">
                <h1>@lang('site.assign_doc')</h1>
                <ol class="breadcrumb">
                    <li><a href=" {{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                    <li> <a href=" {{route('dashboard.subjects.index')}}">@lang('site.subjects')</a></li>
                    <li class="active">@lang('site.assign_doc')</li>

                </ol>
            </section>
            <section class="content">

                <div class="box box-primary">

                    <div class="box-header">
                        <h3 class="box-title">@lang('site.assign_doc')</h3>
                    </div>

                    <div class="box-body">
                        @include('partials._errors')
                        <form action="{{route('dashboard.subjects.update', $subject->id)}}"  method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('put') }}


                            <div class="form-group">
                                <label>@lang('site.sbj_doc')*</label>
                                <select name="doc_id" class="form-control select2-js">
                                    <option value="">@lang('site.doctors')</option>
                                    @foreach ($doctors as $doctor)
                                        <option value="{{$doctor->id}}" {{old('doc_id') == $doctor->id ? 'selected' : ''}}>{{$doctor->name}}</option>
                                    @endforeach
                                </select>
                            </div>



                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</button>
                            </div>
                        </form>
                    </div><!--end of box-body-->

                </div>

            </section>
        </section>


    </div>
    @endif

@endsection
