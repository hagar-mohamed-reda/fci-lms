@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">
            <section class="content-header">
                <h1>@lang('site.students')</h1>
                <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                    <li class="active"> @lang('site.students')</li>
                </ol>
            </section>
            <section class="content">

                <div class="box box-primary">

                    <div class="box-header with-border">
                        <h3 class="box-title" style="margin-bottom: 15px">@lang('site.students') {{--<small>{{$students->total()}}</small>--}}</h3>
                        <form action="{{ route('dashboard.students.index')}}" method="GET">
                            <div class="row">
                                {{-- <div class="col-md-4">
                                    <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{ request()->search}}">
                                </div> --}}
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>

                                    @if (auth()->user()->hasPermission('create_students'))
                                        <a href=" {{route('dashboard.students.create')}}" class="btn btn-success"><i class="fa fa-plus"></i> @lang('site.add')</a>
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
                        <div class="table-responsive">
                            <table class="table table-hover" id="studenttable">
                                <thead>
                                    <tr>
                                        <th>@lang('site.name')</th>
                                        <th>@lang('site.username')</th>
                                        <th>@lang('site.set_number')</th>
                                        <th>@lang('site.national_id')</th>
                                        <th>@lang('site.code')</th>
                                        <th>@lang('site.email')</th>
                                        <th>@lang('site.level')</th>
                                        <th>@lang('site.department')</th>
                                        <th>@lang('site.phone')</th>
                                        <th>@lang('site.active')</th>
                                        <th>@lang('site.account_confirm')</th>
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
        <form action="{{ route('dashboard.students.import') }}" method="post" data-toggle="validator" enctype="multipart/form-data">
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
                        <a href="{{ route('dashboard.students.export') }}" class="btn btn-success">Export</a>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>
            </div>

            @if (auth()->user()->hasPermission('create_students'))
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

@endsection
@section('scripts')
<script>
    var studentRegisterDatatable = null;
    function setStudentRegisterDataTable() {
        var url = "{{ route('dashboard.students.studentDatatable') }}";
        studentRegisterDatatable = $('#studenttable').DataTable({
                "processing": true,
                "serverSide": true,
                "pageLength": 5,
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
                { "data": "name" },
                { "data": "username" },
                { "data": "set_number" },
                { "data": "national_id" },
                { "data": "code" },
                { "data": "email" },
                { "data": "level_id" },
                { "data": "department_id" },
                { "data": "phone" },
                { "data": "active" },
                { "data": "account_confirm" },
                { "data": "action" }
                ]
        });
    }

    $(function(){
        setStudentRegisterDataTable();


            $('.checkinp').on('change', function (){
            //e.preventDefault();

            var sid = $(this).attr('sid');
            var val = $(this).val();
            var token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                header:{'X-CSRF-TOKEN': token},
                url : "{{ url('std/changeActive').'/'}}" + sid,
                type : 'post',
                //data : val,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "active": val
                },
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
        });//end function



        var table = $('#studenttable').DataTable();
            table.on( 'draw', function(){
                $('.checkinp').on('change', function (){
                    //e.preventDefault();

                    var sid = $(this).attr('sid');
                    var val = $(this).val();
                    var token = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        header:{'X-CSRF-TOKEN': token},
                        url : "{{ url('std/changeActive').'/'}}" + sid,
                        type : 'post',
                        //data : val,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "active": val
                        },
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
                });//end functio
            });

        //end of on draw
        /*
        function changeActive($id){
            $.ajax({
                url : "{{ url('std/changeActive').'/'}}" + $id,
                type : 'post',
                data : $(this).val(),
                dataType : 'json',
                success : function(data){
                        if(data.errors){
                            //alert('Data errorsss');
                            iziToast.error({
                                timeout: 6000,
                                title: 'Error', message: data.errors,
                                position:'topCenter',
                            });
                            $('#chphoneform')[0].reset();
                        }
                        if(data.success){
                            iziToast.success({
                                timeout: 6000, icon: 'fa fa-check-circle',
                                title: 'Success', message: 'Data updated Successfully',
                                position: 'topCenter',
                            });
                            $('#chphoneform')[0].reset();
                        }
                },
                error : function(){
                        //alert('Error Data');
                        iziToast.error({
                                timeout: 6000,
                                title: 'Error', message: 'Error Data',
                                position:'topCenter',
                            });
                            $('#chphoneform')[0].reset();
                }
            });
        }*/
    });

</script>
@endsection
