@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">
            <section class="content-header">
                <h1>@lang('site.student_regist_subjects')</h1>
                <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                    <li class="active"> @lang('site.student_regist_subjects')</li>
                </ol>
            </section>
            <section class="content">

                <div class="box box-primary">

                    <div class="box-header with-border">
                        <h3 class="box-title" style="margin-bottom: 15px">@lang('site.student_regist_subjects') {{--<small>{{$subjects->total()}}</small>--}}</h3>
                        <form action="{{ route('dashboard.student_subjects.index')}}" method="GET">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{ request()->search}}">
                                </div>

                                <div class="col-md-4">
                                    <select name="sbj_id" class="form-control select2-js">
                                        <option value="">@lang('site.subjects')</option>
                                        @foreach ($subjects as $subject)
                                        @if ($subject->doc_id == auth()->user()->fid && auth()->user()->hasRole('doctor')  || auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin'))
                                            <option value="{{$subject->id}}" {{request()->sbj_id == $subject->id ? 'selected' : ''}}>{{$subject->name}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>

                                    {{--@if (auth()->user()->hasPermission('create_regist'))
                                        <a href=" {{route('dashboard.student_subjects.create')}}" class="btn btn-success"><i class="fa fa-plus"></i> @lang('site.add')</a>
                                    @endif--}}
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
                        @if ($stdSubjects->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover" id="stdSbjTable">
                                <thead>
                                    <tr>
                                        {{-- <th>#</th> --}}
                                        <th>@lang('site.std_name')</th>
                                        <th>@lang('site.sbj_name')</th>
                                        @if(auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin'))
                                        <th>@lang('site.action')</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stdSubjects as $index=>$stdSubject)
                                        @foreach ($subjects as $subject)
                                            @if ($stdSubject->subject_id == $subject->id && auth()->user()->type == 'doctor' && $subject->doc_id == auth()->user()->fid)
                                            <tr>
                                                {{-- <td>{{ $index + 1}}</td> --}}
                                                <td>{{ $stdSubject->students['name']}}</td>
                                                <td>{{ $stdSubject->subjects['name']}}</td>
                                                {{--<td>
                                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#sbjTable">@lang('site.show_subj_table')</button>
                                                    {{--<a href="{{ asset('dashboard/files/myposProject.pdf') }}">@lang('site.show_subj_table')</a>}}
                                                </td>--}}
                                                @if(auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin'))
                                                <td>
                                                    {{--@if (auth()->user()->hasPermission('update_regist'))
                                                        <a href=" {{ route('dashboard.student_subjects.edit', $stdSubject->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                                    @endif--}}
                                                    @if (auth()->user()->hasPermission('delete_regist'))
                                                        <form action="{{route('dashboard.student_subjects.destroy', $stdSubject->id)}}" method="POST" style="display: inline-block">
                                                            {{ csrf_field() }}
                                                            {{ method_field('delete')}}
                                                            <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                                        </form>
                                                    @endif

                                                </td>
                                                @endif
                                            </tr>
                                            @endif
                                        @endforeach
                                        @if (auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin'))
                                        <tr>
                                            {{-- <td>{{ $index + 1}}</td> --}}
                                            <td>{{ $stdSubject->students['name']}}</td>
                                            <td>{{ $stdSubject->subjects['name']}}</td>
                                            {{--<td>
                                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#sbjTable">@lang('site.show_subj_table')</button>
                                                {{--<a href="{{ asset('dashboard/files/myposProject.pdf') }}">@lang('site.show_subj_table')</a>}}
                                            </td>--}}
                                            <td>
                                                {{--@if (auth()->user()->hasPermission('update_regist'))
                                                    <a href=" {{ route('dashboard.student_subjects.edit', $stdSubject->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                                @endif--}}
                                                @if (auth()->user()->hasPermission('delete_regist'))
                                                    <form action="{{route('dashboard.student_subjects.destroy', $stdSubject->id)}}" method="POST" style="display: inline-block">
                                                        {{ csrf_field() }}
                                                        {{ method_field('delete')}}
                                                        <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                                    </form>
                                                @endif

                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                            {{-- {{$stdSubjects->appends(request()->query())->links()}} --}}
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
        <form action="{{ route('dashboard.student_subjects.import') }}" method="post" data-toggle="validator" enctype="multipart/form-data">
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
                        <a href="{{ route('dashboard.student_subjects.export') }}" class="btn btn-success">Export</a>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>
            </div>

            @if (auth()->user()->hasPermission('create_regist'))
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


@endsection

@section('scripts')
<script>
    $(function(){
        $('#stdSbjTable').DataTable({
            'order': [[ 1, 'desc' ]],
            "dom" : 'lBfrtip',
         "buttons" : [
            'copy', 'csv', 'excel', 'pdf','print',
            ]
        });
    });

</script>
@endsection
