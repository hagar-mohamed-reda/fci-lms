@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">
        <section class="content container-fluid">
            <section class="content-header">
                <h1>@lang('site.doctors')</h1>
                <ol class="breadcrumb">
                    <li><a href=" {{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                    <li> <a href=" {{route('dashboard.doctors.index')}}">@lang('site.doctors')</a></li>
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
                        <form action="{{route('dashboard.doctors.update', $doctor->id)}}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('put') }}

                            <div class="form-group">
                                <label>@lang('site.name') *</label>
                                <input type="text" name="name" class="form-control" value="{{$doctor->name}}">
                            </div>

                            <div class="form-group">
                                <label>@lang('site.username')*</label>
                                <input type="text" name="username" class="form-control" value="{{$doctor->username}}">
                            </div>


                            <div class="form-group">
                                <label>@lang('site.email') *</label>
                                <input type="text" name="email" class="form-control" value="{{$doctor->email}}">
                            </div>


                            <div class="form-group">
                                <label>@lang('site.phone') *</label>
                                <input type="text" name="phone" class="form-control" value="{{$doctor->phone}}">
                            </div>


                            {{-- <div class="form-group">
                                <label>@lang('site.active')*</label>
                                <select name="active" class="form-control">
                                    <option value="1" {{$doctor->active == 1? 'selected': '' }}>@lang('site.is_active')</option>
                                    <option value="0" {{$doctor->active == 0? 'selected': '' }}>@lang('site.not_active')</option>
                                </select>
                            </div> --}}

                            <input type="hidden" name="active" value="0">

                            <div class="form-group">
                                <label>@lang('site.active')*</label>
                                <div class="custom-control custom-switch material-switch">
                                        <input type="checkbox" name="active" class="custom-control-input" id="doctorSwitch{{$doctor->id}}"
                                        onchange="this.checked? this.value = 1 : this.value = 0" {{ $doctor->active == 1? 'checked' : ''}} >
                                        <label class="custom-control-label" for="doctorSwitch{{$doctor->id}}"></label>
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
