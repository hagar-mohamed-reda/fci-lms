@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">
            <section class="content-header">
                <h1>@lang('site.student_assignments')</h1>
                <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                    <li class="active"> @lang('site.student_assignments')</li>
                </ol>
            </section>
            <section class="content">

                <div class="box box-primary">

                    <div class="box-header with-border">
                        <h3 class="box-title" style="margin-bottom: 15px">@lang('site.student_assignments') {{--<small>{{$subjects->total()}}</small>--}}</h3>
                        <form action="{{ route('dashboard.student_assignments.index')}}" method="GET">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{ request()->search}}">
                                </div>
                                @if(auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin'))
                                <div class="col-md-4">
                                    <select name="doc_id" id="doctors" class="form-control select2-js">
                                        <option value="">@lang('site.doctors')</option>
                                        @foreach ($doctors as $doctor)
                                            <option value="{{$doctor->id}}" {{request()->doc_id == $doctor->id ? 'selected' : ''}}>{{$doctor->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif

                                <div class="col-md-4">
                                    <select name="sbj_id" id="subjects" class="form-control select2-js">
                                        <option value="">@lang('site.subjects')</option>
                                        @foreach ($subjects as $subject)
                                            @if ($subject->docSubjs()->where('doctor_id', auth()->user()->fid)->exists() == auth()->user()->fid && auth()->user()->hasRole('doctor') || auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin'))
                                            <option value="{{$subject->id}}" {{request()->sbj_id == $subject->id ? 'selected' : ''}}>{{$subject->name}}</option>
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
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-4">
                                    <select name="lesson_id" id="lessons" class="form-control select2-js">
                                        <option value="">@lang('site.lessons')</option>
                                        @foreach ($lessons as $lesson)
                                            @if ($lesson->doc_id == auth()->user()->fid && auth()->user()->hasRole('doctor') || auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin'))
                                            <option value="{{$lesson->id}}" {{request()->lesson_id == $lesson->id ? 'selected' : ''}}>{{$lesson->name}}</option>
                                            @endif

                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <select name="assign_id" id="assigns" class="form-control select2-js">
                                        <option value="">@lang('site.assignments')</option>
                                        @foreach ($assignments as $assignment)
                                        @if ($assignment->doc_id == auth()->user()->fid || auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin') || auth()->user()->hasRole('student'))
                                            <option value="{{$assignment->id}}" {{request()->assign_id == $assignment->id ? 'selected' : ''}}>{{$assignment->name}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>

                                    {{--@if (auth()->user()->hasPermission('create_stdassign'))
                                        <a href=" {{route('dashboard.student_assignments.create')}}" class="btn btn-success"><i class="fa fa-plus"></i> @lang('site.add')</a>
                                    @endif--}}


                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="box-body">
                        @if ($stdAssignments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover" id="stdassigntable">
                                <thead>
                                    <tr>
                                        {{-- <th>#</th> --}}
                                        <th>@lang('site.std_name')</th>
                                        <th>@lang('site.assign_name')</th>
                                        <th>@lang('site.sbj_name')</th>
                                        <th>@lang('site.pdf_anss')</th>
                                        <th>@lang('site.date')</th>
                                        <th>@lang('site.grade')</th>
                                        <th>
                                            @if (auth()->user()->type == 'doctor')
                                                @lang('site.action')
                                            @endif
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stdAssignments as $index=>$stdAssignment)
                                    @if ($stdAssignment->doc_id == auth()->user()->fid && auth()->user()->type == 'doctor' || auth()->user()->type == 'super_admin' || auth()->user()->type == 'admin')
                                    <tr>
                                        {{-- <td>{{ $stdAssignment->id}}</td> --}}
                                        <td>{{ $stdAssignment->students['name']}}</td>
                                        <td>{{ $stdAssignment->assignments['name']}}</td>
                                        <td>{{ $stdAssignment->subjects['name']}}</td>

                                        <td class="fileAnss">
                                            {{--<a href="student_assignments/pdffiles/{{$stdAssignment->id}}" class="btn btn-primary btn-sm"><i class="fa fa-show"></i> @lang('site.show')</a>--}}
                                            <a href="#" class="btn btn-primary btn-sm showFileOnline" data-open='off' data-src="{{'http://lms.seyouf.sphinxws.com/public/uploads/anssers/'.$stdAssignment->pdf_anss}}" {{--onclick="viewFile(this)"--}}><i class="fa fa-show"></i> @lang('site.show')</a>
                                            <a href="student_assignments/pdffile/download/{{$stdAssignment->pdf_anss}}" class="btn btn-info btn-sm"><i class="fa fa-download"></i> @lang('site.download')</a>
                                        </td>
                                        {{--<td>
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#sbjTable">@lang('site.show_subj_table')</button>
                                            {{--<a href="{{ asset('dashboard/files/myposProject.pdf') }}">@lang('site.show_subj_table')</a>}}
                                        </td>--}}
                                        @if ($stdAssignment->assignments['end_date'] > $stdAssignment->created_at)
                                            <td style="color: green">{{ $stdAssignment->created_at}}</td>
                                        @else
                                            <td style="color: red">{{ $stdAssignment->created_at}} @lang('site.after_date')</td>
                                        @endif
                                        <td>
                                            @if ($stdAssignment->grade > 0)
                                                {{$stdAssignment->grade}}
                                            @endif
                                        </td>
                                        <td>
                                            {{--@if (auth()->user()->hasPermission('update_stdassign'))
                                                <a href=" {{ route('dashboard.student_assignments.edit', $stdSubject->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                            @endif--}}
                                            @if (auth()->user()->type == 'doctor')
                                                @if ($stdAssignment->grade > 0)
                                                <button class="btn btn-success btn-sm editGradBtn" data-toggle="modal" data-target="#modalGrade" anssID="{{$stdAssignment->id}}" anssGrade="{{$stdAssignment->grade}}">@lang('site.edit_grade')</button>
                                                @else
                                                <button class="btn btn-primary btn-sm addGradBtn" data-toggle="modal" data-target="#modalGrade" anssID="{{$stdAssignment->id}}">@lang('site.add_grade')</button>
                                                @endif
                                            @endif

                                            @if (auth()->user()->hasPermission('delete_stdassign'))
                                                <form action="{{route('dashboard.student_assignments.destroy', $stdAssignment->id)}}" method="POST" style="display: inline-block">
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
                            {{-- {{$stdAssignments->appends(request()->query())->links()}} --}}
                        @else
                            <h2>@lang('site.no_data_found')</h2>
                        @endif
                    </div>

                </div>

            </section>

    </div>

    <!-- Modal -->
<div class="modal fade" id="modalGrade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title text-center">@lang('site.add_grade')</h4>
        </div>
        <div class="modal-body">
            <span id="form_result"></span>
            <h1 style="text-align: center; display: none">@lang("site.please_open_the_file")</h1>
            <form action="" method="POST" id="grade_form">
                @csrf
                {{-- {{method_field('')}} --}}

                {{-- <input type="hidden" name="action" id="action" value="Add"> --}}
                <input type="hidden" name="hidden_id" id="hidden_id">
                <div class="form-group">
                    <label for="grade">@lang('site.grade')</label>
                    <input name="grade" type="number" class="form-control" id="grade">
                </div>


                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="action_button" name="action_button">@lang('site.save')</button>
                </div>
            </form>
        </div>

      </div>
    </div>
</div>


@endsection

@section('scripts')
<script>
    $(function(){

        //function to oben the answer in new tab
        $(document).on("click",".showFileOnline",function() {
            console.log($(this));
            var src = $(this).data('src');
            $(this).attr('data-open', 'on');
            return window.open("https://docs.google.com/viewerng/viewer?url="+src, '_blank');
        });


        $("#doctors").change(function(){
            $.ajax({
                url: "{{ route('subjects.get_by_doctor') }}?doc_id=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('#subjects').html(data.html);
                }
            });
        });
        $("#subjects").change(function(){
            $.ajax({
                url: "{{ route('lessons.get_by_subject') }}?sbj_id=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('#lessons').html(data.html);
                }
            });
        });
        $("#lessons").change(function(){
            $.ajax({
                url: "{{ route('assigns.get_by_lesson') }}?lesson_id=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('#assigns').html(data.html);
                }
            });
        });
        $('#stdassigntable').DataTable({
         "pageLength": 10,
         "dom" : 'lBfrtip',
         "buttons" : [
            'copy', 'csv', 'excel', 'pdf','print',
            ]
        });

        //add grade btn on click
        $(document).on("click", ".addGradBtn", function(){
            var opened = $(this).parent().parent().find('.fileAnss').find('.showFileOnline').attr('data-open');
            if(opened == 'off'){
                $('#modalGrade').modal('hide');
                $('.modal-backdrop').hide();
                //$(this).parent().parent().find('.fileAnss').find('.showFileOnline').data('dismiss', 'modal');
                $('#modalGrade .modal-body h1').css('display', 'block');
                $('#modalGrade .modal-body #grade_form').css('display', 'none');
                /*iziToast.error({
                    timeout: 6000,
                    title: 'Error', message: '@lang("site.please_open_the_file")',
                    position:'topCenter',
                });*/
            }else{
                //$('#modalGrade .modal-body').html($('#grade_form'));
                $('#modalGrade .modal-body h1').css('display', 'none');
                $('#modalGrade .modal-body #grade_form').css('display', 'block');
                $('#modalGrade').modal('show');
                var anssID = $(this).attr('anssID');
                $('#hidden_id').val(anssID);
                $('.modal-title').text('@lang("site.add_grade")');
                $('#grade').val('');
            }

        });


        //add grade btn on click
        $('.editGradBtn').on('click', function(){
            $('#modalGrade .modal-body h1').css('display', 'none');
            $('#modalGrade .modal-body #grade_form').css('display', 'block');
            var anssID = $(this).attr('anssID');
            var anssGrade = $(this).attr('anssGrade');

            $('#hidden_id').val(anssID);
            $('.modal-title').text('@lang("site.edit_grade")');
            $('#grade').val(anssGrade);
        });

        //grade form on submit
        $('#grade_form').on('submit', function(){
            var id = $('#hidden_id').val();
            var token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                //header:{'X-CSRF-TOKEN': token},
                url : "{{ url('stdAssign/addGrade').'/'}}" + id,
                type : 'post',
                data: $(this).serialize(),
                dataType : 'json',
                success : function(data){
                        if(data.errors){
                            //alert('Data errorsss');
                            iziToast.error({
                                timeout: 6000,
                                title: 'Error', message: data.errors,
                                position:'topCenter',
                            });
                            //$('#chphoneform')[0].reset();
                        };
                        if(data.success){
                            iziToast.success({
                                timeout: 6000, icon: 'fa fa-check-circle',
                                title: 'Success', message: 'Data updated Successfully',
                                position: 'topCenter',
                            });
                            //alert(data);
                            //console.log(data);
                            //$('#chphoneform')[0].reset();
                        }
                },
                error : function(){
                        //alert('Error Data');
                        iziToast.error({
                                timeout: 6000,
                                title: 'Error', message: 'Error Data',
                                position:'topCenter',
                            });
                            //$('#chphoneform')[0].reset();
                }
            });
        });
    });

</script>
@endsection
