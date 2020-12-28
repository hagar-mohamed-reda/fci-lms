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
                                    <select name="course_id" id="subjects" class="form-control select2-js course_id">
                                        <option value="">@lang('site.subjects')</option>
                                        @foreach ($subjects as $subject)
                                            @if ($subject->docSubjs()->where('doctor_id', auth()->user()->fid)->exists() == auth()->user()->fid && auth()->user()->hasRole('doctor') || auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin'))
                                            <option value="{{$subject->id}}" {{request()->course_id == $subject->id ? 'selected' : ''}}>{{$subject->name}}</option>
                                            @endif
                                            {{-- @if (auth()->user()->hasRole('student'))
                                                @foreach ($stdSbs as $stdSb)
                                                @if($stdSb->subject_id == $subject->id && $stdSb->student_id == auth()->user()->fid)
                                                <option value="{{$subject->id}}" {{request()->sbj_id == $subject->id ? 'selected' : ''}}>{{$subject->name}}</option>
                                                @endif
                                                @endforeach
                                            @endif --}}
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <button type="button" onclick="reloadData($('.course_id').val())" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>
                                    <a id="showAll" class="btn btn-primary">show all</a>

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
                        @if (isset($_GET['course_id']))
                        <input type="hidden" id="getCoursID" name="getCoursID" value="{{$_GET['course_id']}}">
                        @endif
                        <div class="table-responsive">
                            <table class="table table-hover" id="stdSbjTable">
                                <thead>
                                    <tr>
                                        <th>@lang('site.std_name')</th>
                                        <th>@lang('site.sbj_name')</th>
                                        <th>@lang('site.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
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
    var studentRegisterDatatable = null;

    function reloadData(course) {
        $('#courseStudent').val(course);
        //
        var url = "{{ route('dashboard.studentRegisterDatatable') }}?course_id=" + course;
        studentRegisterDatatable.ajax.url(url).load();
    }
    /*$(function(){
        reloadData($_GET['course_id']);
    });*/

    function setStudentRegisterDataTable() {
        var url = "{{ route('dashboard.studentRegisterDatatable') }}?course_id=";
        studentRegisterDatatable = $('#stdSbjTable').DataTable({
        "processing": true,
                "serverSide": true,
                "pageLength": 20,
                dom: 'Bfrtip',
                buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5',
                        'pdfHtml5'
                ],
                "sorting": [0, 'DESC'],
                "ajax": url,
                "columns":[
                { "data": "student" },
                { "data": "course" },
                { "data": "action" }
                ]
        });
        }

    setStudentRegisterDataTable();

    var course_id= $('#getCoursID').val();

    if(course_id > 0){
        reloadData(course_id);
    }

    $('#showAll').on('click', function(){
        $('#stdSbjTable').DataTable().destroy();
        $('#stdSbjTable').DataTable({
            //"pagingType": "full_numbers",
            "lengthMenu": [[10, 25, 50, -1],[10, 25, 50, "All"]],
            paging: false,
            //aLengthMenu: [[25, 50, 100, 200, -1],[25, 50, 100, 200, "All"]],
            //iDisplayLength: -1
            /*"processing": true,
            "serverSide": true,
            */"pageLength": 20,
            dom: 'Bfrtip',
            buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
            ],
            "sorting": [0, 'DESC'],
            'iDisplayLength': 100
        });
        //table.pag.len(-1).Draw();
    });
</script>
@endsection
