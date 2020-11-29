@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">
        <section class="content container-fluid">
            <section class="content-header">
                <h1>@lang('site.student_regist_subjects')</h1>
                <ol class="breadcrumb">
                    <li><a href=" {{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                    <li> <a href=" {{route('dashboard.student_subjects.index')}}">@lang('site.student_regist_subjects')</a></li>
                    <li class="active">@lang('site.add')</li>

                </ol>
            </section>
            <section class="content">

                <div class="box box-primary">

                    <div class="box-header">
                        <h3 class="box-title">
                            @foreach ($subjects as $index=>$subject)
                            @if ($subject->id == $_GET['sbj_id'])
                            {{$subject->name}} =>
                            @endif
                            @endforeach
                        </h3>
                        <h3 class="box-title">@lang('site.add_std_to_sbj')</h3>
                    </div>

                    <div class="box-body">
                        @include('partials._errors')
                        <form action="{{route('dashboard.student_subjects.store')}}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('post') }}

                            {{--
                            <div class="form-group">
                                <label>@lang('site.subjects')*</label>
                                <select name="course_id" class="form-control">
                                    <option value="">@lang('site.subjects')</option>
                                    @foreach ($subjects as $subject)
                                        <option value="{{$subject->id}}" {{old('course_id') == $subject->id ? 'selected' : ''}}>{{$subject->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            --}}

                            <input type="hidden" name="course_id" value={{$_GET['sbj_id']}}>

                            <div class="form-group">
                                <label>@lang('site.students')*</label>
                                <select name="student_id" class="form-control select2-js" {{--multiple=""--}}>
                                    <option value="">@lang('site.students')</option>
                                    @foreach ($students as $student)
                                        <option value="{{$student->id}}" {{old('student_id') == $student->id ? 'selected' : ''}}>{{$student->name}}</option>
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

@endsection
@section('scripts')

@endsection
