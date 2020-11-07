@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">
        <section class="content container-fluid">
            <section class="content-header">
                <h1>@lang('site.departments')</h1>
                <ol class="breadcrumb">
                    <li><a href=" {{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                    <li> <a href=" {{route('dashboard.departments.index')}}">@lang('site.departments')</a></li>
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
                        <form action="{{route('dashboard.departments.store')}}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('post') }}

                            <div class="form-group">
                                <label>@lang('site.name')*</label>
                                <input type="text" name="name" class="form-control" value="{{old('name')}}">
                            </div>



                            <div class="form-group">
                                <label>@lang('site.level')*</label>
                                <select name="level_id" class="form-control  select2-js">
                                    <option value="">@lang('site.level')</option>
                                    @foreach ($levels as $level)
                                        <option value="{{$level->id}}" {{old('level_id') == $level->id ? 'selected' : ''}}>{{$level->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>@lang('site.notes')</label>
                                <input type="text" name="notes" class="form-control" value="{{old('notes')}}">
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

@endsection
