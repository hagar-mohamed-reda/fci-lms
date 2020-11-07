@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">
        <section class="content container-fluid">
            <section class="content-header">
                <h1>@lang('site.student_assignments')</h1>
                <ol class="breadcrumb">
                    <li><a href=" {{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                    <li> <a href=" {{route('dashboard.student_assignments.index')}}">@lang('site.student_assignments')</a></li>
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
                        <form action="{{route('dashboard.student_assignments.store')}}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('post') }}

                            {{--
                            <div class="form-group">
                                <label>@lang('site.assignments')*</label>
                                <select name="assign_id" class="form-control">
                                    <option value="">@lang('site.assignments')</option>
                                    {{--$n = Assignment::orderBy('id','desc')->first()->id--}
                                    @foreach ($assignments as $assignment)
                                        <option value="{{$assignment->id}}" {{old('assign_id') == $assignment->id ? 'selected' : ''}}>{{$assignment->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            --}}
                            {{--
                            <div class="form-group">
                                <label>@lang('site.students')*</label>
                                <select name="student_id" class="form-control">
                                    <option value="">@lang('site.students')</option>
                                    @foreach ($students as $student)
                                        <option value="{{$student->id}}" {{auth()->user()->id == $student->id ? 'selected' : ''}}>{{$student->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            --}}

                            <input type="hidden" name="assign_id" value={{$_GET['assign_id']}}>
                            <input type="hidden" name="lesson_id" value={{$_GET['lesson_id']}}>
                            <input type="hidden" name="sbj_id" value={{$_GET['sbj_id']}}>
                            <input type="hidden" name="doc_id" value={{$_GET['doc_id']}}>

                            <input type="hidden" name="student_id" value={{auth()->user()->fid}}>

                            <div class="form-group">
                                <label><i class="fa fa-paperclip fa-lg" aria-hidden="true"></i> @lang('site.pdf_anss')*</label>
                                <input type="file" name="pdf_anss" class="form-control" value="{{old('pdf_anss')}}">
                                <!--input type="submit" value="upload"-->
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
