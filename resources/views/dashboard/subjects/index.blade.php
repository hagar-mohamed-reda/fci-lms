@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">
            <section class="content-header">
                <h1>@lang('site.subjects')</h1>
                <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                    <li class="active"> @lang('site.subjects')</li>
                </ol>
            </section>
            <section class="content">

                <div class="box box-primary">

                    <div class="box-header with-border">
                        <h3 class="box-title" style="margin-bottom: 15px">@lang('site.subjects') {{--<small>{{$subjects->total()}}</small>--}}</h3>
                        <form action="{{ route('dashboard.subjects.index')}}" method="GET">
                            <div class="row">


                                @if (auth()->user()->hasRole('super_admin'))
                                <div class="col-md-4">
                                    <select name="doc_id" class="form-control select2-js">
                                        <option value="">@lang('site.doctors')</option>
                                        @foreach ($doctors as $doctor)
                                            <option value="{{$doctor->id}}" {{request()->doc_id == $doctor->id ? 'selected' : ''}}>{{$doctor->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif


                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>

                                    @if (auth()->user()->hasPermission('create_subjects'))
                                        <a href=" {{route('dashboard.subjects.create')}}" class="btn btn-success"><i class="fa fa-plus"></i> @lang('site.add')</a>
                                    @endif
                                    @if(auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin'))
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#model-exim">
                                        Import/Export
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </form>

                    </div>

                    <div class="box-body">
                        @if ($subjects->count() > 0)
                            <table class="table table-hover" id="subjecttable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('site.name')</th>
                                        <th>@lang('site.code')</th>
                                        <th>@lang('site.sbj_doc')</th>
                                        <th>@lang('site.lessons') </th>

                                        @if(auth()->user()->type == 'doctor'  || auth()->user()->type == 'super_admin' || auth()->user()->type == 'admin' )
                                        <th>@lang('site.registed_students') </th>
                                        <th>@lang('site.hours')</th>
                                        <th>@lang('site.notes')</th>
                                        @endif

                                        @if(auth()->user()->hasRole('doctor')  || auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin'))
                                        <th>@lang('site.action')</th>
                                        @endif

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subjects as $index=>$subject)
                                    {{--dd($subject->doc_id)--}}

                                    @if ($subject->doc_id == auth()->user()->fid && auth()->user()->type == 'doctor'  || auth()->user()->type == 'super_admin' || auth()->user()->type == 'admin' )
                                    <tr>
                                        <td>{{ $subject->id}}</td>
                                        <td>{{ $subject->name}}</td>
                                        <td>{{ $subject->code}}</td>
                                        <td>{{ $subject->doctor['name']}}</td>
                                        <td>{{ $subject->lessons->count()}} <a href="{{route('dashboard.lessons.index', [ 'doc_id' => $subject->doc_id, 'sbj_id' => $subject->id ])}}" class="btn btn-info btn-sm">@lang('site.go')</a> </td>

                                        @if(auth()->user()->type == 'doctor'  || auth()->user()->type == 'super_admin' || auth()->user()->type == 'admin' )
                                        <td>{{ $subject->stdSbjs->count()}} <a href="{{route('dashboard.student_subjects.index', ['sbj_id' => $subject->id ])}}" class="btn btn-info btn-sm">@lang('site.show')</a> </td>
                                        <td>{{ $subject->hours}}</td>
                                        <td>{{ $subject->notes}}</td>
                                        @endif


                                        @if(auth()->user()->hasRole('doctor')  || auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin'))

                                        <td>
                                            @if (auth()->user()->hasPermission('update_subjects'))
                                                <a href=" {{ route('dashboard.subjects.edit', [$subject->id, 'udoc'=>0])}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                            @endif
                                            @if (auth()->user()->hasPermission('delete_subjects'))
                                                <form action="{{route('dashboard.subjects.destroy', $subject->id)}}" method="POST" style="display: inline-block">
                                                    {{ csrf_field() }}
                                                    {{ method_field('delete')}}
                                                    <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                                </form>
                                                <br>
                                            @endif

                                            @if (auth()->user()->hasPermission('create_regist'))
                                            <a href="{{route('dashboard.student_subjects.create',['sbj_id' => $subject->id])}}" class="btn btn-warning btn-sm mt-2"><i class="fa fa-edit"></i> @lang('site.add_std_to_sbj')</a>
                                            @endif

                                            @if (auth()->user()->hasPermission('update_subjects'))
                                                <a href=" {{ route('dashboard.subjects.edit', [$subject->id, 'udoc'=>1])}}" class="btn btn-primary btn-sm mt-2"><i class="fa fa-edit"></i> @lang('site.assign_doc')</a>
                                            @endif

                                            @if (auth()->user()->hasPermission('create_lessons'))
                                            <a href="{{route('dashboard.lessons.create',['sbj_id' => $subject->id ])}}" class="btn btn-success btn-sm">@lang('site.add_lesson')</a>
                                            @endif

                                        </td>
                                        @endif
                                    </tr>
                                    @endif

                                    {{--dd($subject->stdSbjs('id'))--}}

                                    @if (auth()->user()->type == 'student')

                                    @foreach ($stdSbs as $stdSb)
                                    @if($stdSb->subject_id == $subject->id && $stdSb->student_id == auth()->user()->fid)
                                    <tr>
                                        <td>{{ $subject->id}}</td>
                                        <td>{{ $subject->name}}</td>
                                        <td>{{ $subject->code}}</td>
                                        <td>{{ $subject->doctor['name']}}</td>
                                        <td>{{ $subject->lessons->count()}} <a href="{{route('dashboard.lessons.index', [ 'doc_id' => $subject->doc_id, 'sbj_id' => $subject->id ])}}" class="btn btn-info btn-sm">@lang('site.go')</a> </td>


                                    </tr>
                                    @endif
                                    @endforeach

                                    @endif

                                    @endforeach
                                </tbody>
                            </table>
                            {{-- {{$subjects->appends(request()->query())->links()}} --}}
                        @else
                            <h2>@lang('site.no_data_found')</h2>
                        @endif
                    </div>

                </div>

            </section>

    </div>

    {{--model dailog--}}

      <!-- Modal -->
  <div class="modal fade" id="model-exim" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="{{ route('dashboard.subjects.import') }}" method="post" data-toggle="validator" enctype="multipart/form-data">
            {{ csrf_field() }}

        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Import/Export</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

            <div class="row">
                <div class="form-group">
                    <label for="export" class="col-md-3 control-label">Export</label>
                    <div class="col-md-6">
                        <a href="{{ route('dashboard.subjects.export') }}" class="btn btn-success">Export</a>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>
            </div>

            @if (auth()->user()->hasPermission('create_subjects'))
            <div class="row">
                <div class="form-group">
                    <label for="file" class="col-md-3 control-label">Import</label>
                    <div class="col-md-6">
                        <input type="file" name="file" id="file" class="form-control" autofocus required>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>
            </div>
            @endif

        </div>
        <div class="modal-footer">
            <button class="btn btn-success">Import</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>

       </form>

      </div><!--end of content-->
    </div>
  </div>

    <!-- Modal -->
    <div class="modal fade" id="sbjTable" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title text-center">@lang('site.sbj_table')</h4>
            </div>
            <div class="modal-body">
                <div class="pdfobject-container">
                    <div id="viewpdf"></div>
                </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

@endsection

@section('scripts')
<script>
    $(function(){
        $('#subjecttable').DataTable({
            'order': [[ 1, 'desc' ]],
        });
    });

</script>
@endsection
