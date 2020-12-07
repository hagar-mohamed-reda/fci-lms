@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">
        <section class="content container-fluid">
            <section class="content-header">
                <h1>@lang('site.students')</h1>
                <ol class="breadcrumb">
                    <li><a href=" {{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                    <li> <a href=" {{route('dashboard.students.index')}}">@lang('site.students')</a></li>
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
                        <form action="{{route('dashboard.students.update', $student->id)}}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('put') }}

                            <div class="form-group">
                                <label>@lang('site.name') *</label>
                                <input type="text" name="name" class="form-control" value="{{$student->name}}">
                            </div>

                            <div class="form-group">
                                <label>@lang('site.username')*</label>
                                <input type="text" name="username" class="form-control" value="{{$student->username}}">
                            </div>

                            <div class="form-group">
                                <label>@lang('site.level')*</label>
                                <select name="level_id" class="form-control select2-js">
                                    <option value="">@lang('site.level')</option>
                                    @foreach ($levels as $level)
                                        <option value="{{$level->id}}" {{$student->level_id == $level->id ? 'selected' : ''}}>{{$level->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>@lang('site.department')*</label>
                                <select name="department_id" class="form-control select2-js">
                                    <option value="">@lang('site.department')</option>
                                    @foreach ($departments as $department)
                                        <option value="{{$department->id}}" {{$student->department_id == $department->id ? 'selected' : ''}}>{{$department->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>@lang('site.code') *</label>
                                <input type="text" name="code" class="form-control" value="{{$student->code}}">
                            </div>


                            <div class="form-group">
                                <label>@lang('site.email') *</label>
                                <input type="text" name="email" class="form-control" value="{{$student->email}}">
                            </div>


                            <div class="form-group">
                                <label>@lang('site.phone')*</label>
                                <input type="text" name="phone" class="form-control" value="{{$student->phone}}">
                            </div>


                            <div class="form-group">
                                <label>@lang('site.set_number')*</label>
                                <input type="text" name="set_number" class="form-control" value="{{$student->set_number}}">
                            </div>

                            <div class="form-group">
                                <label>@lang('site.national_id')*</label>
                                <input type="text" name="national_id" class="form-control" value="{{$student->national_id}}">
                            </div>

                            {{-- <div class="form-group">
                                <label>@lang('site.active')*</label>
                                <select name="active" class="form-control">
                                    <option value="1" {{$student->active == 1? 'selected' : ''}} >@lang('site.is_active')</option>
                                    <option value="0" {{$student->active == 0? 'selected' : ''}}>@lang('site.not_active')</option>
                                </select>
                            </div> --}}

                            <input type="hidden" name="active" value="0">

                            <div class="form-group">
                                <label>@lang('site.active')*</label>
                                <div class="custom-control custom-switch material-switch">
                                        <input type="checkbox" name="active" class="custom-control-input" id="studentSwitch{{$student->id}}"
                                        onchange="this.checked? this.value = 1 : this.value = 0" {{ $student->active == 1? 'checked' : ''}} >
                                        <label class="custom-control-label" for="studentSwitch{{$student->id}}"></label>
                                </div>
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

@endsection
