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
                        @if ($students->count() > 0)
                            <table class="table table-hover" id="studenttable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('site.name')</th>
                                        <th>@lang('site.username')</th>
                                        <th>@lang('site.set_number')</th>
                                        <th>@lang('site.national_id')</th>
                                        <th>@lang('site.code')</th>
                                        <th>@lang('site.email')</th>
                                        <th>@lang('site.level')</th>
                                        <th>@lang('site.department')</th>
                                        {{--<th>@lang('site.add_orderRegist')</th>--}}
                                        <th>@lang('site.phone')</th>
                                        <th>@lang('site.active')</th>
                                        <th>@lang('site.account_confirm')</th>
                                        {{--<th>@lang('site.image')</th>--}}
                                        <th>@lang('site.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $index=>$student)
                                    <tr>
                                        <td>{{ $index + 1}}</td>
                                        <td>{{ $student->name}}</td>
                                        <td>{{ $student->username}}</td>
                                        <td>{{ $student->set_number}}</td>
                                        <td>{{ $student->national_id}}</td>
                                        <td>{{ $student->code}}</td>
                                        <td>{{ $student->email}}</td>
                                        <td>{{ $student->level['name']}}</td>
                                        <td>{{ $student->department['name']}}</td>
                                        {{--<td><a href="{{route('dashboard.student_subjects.create')}}" class="btn btn-primary">@lang('site.add_orderRegist')</a></td>--}}
                                        <td>{{ is_array($student->phone) ? implode($student->phone, '-') : $student->phone }}</td>
                                        <td>
                                            <div class="form-group">
                                                <div class="custom-control custom-switch material-switch">
                                                        <input type="checkbox" class="custom-control-input" id="studentSwitch{{$student->id}}" {{ $student->active == 1? 'checked' : ''}} value="{{ $student->active == 1? '1' : '0'}}" name="active" onclick="changeActive($student->id)"
                                                        onchange="this.checked? this.value = 1 : this.value = 0"
                                                        type="checkbox">
                                                        <label class="custom-control-label" for="studentSwitch{{$student->id}}"></label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($student->account_confirm == 0)
                                                @lang('site.no')
                                            @else
                                                @lang('site.yes')
                                            @endif

                                        </td>
                                        {{--<td><img src="{{ $student->image_path }}" style="width: 80px;" class="img-thumbnail" alt=""></td>--}}
                                        <td>
                                            @if (auth()->user()->hasPermission('update_students'))
                                                <a href=" {{ route('dashboard.students.edit', $student->id)}}" ><i class="fa fa-edit" style="color: orange"></i></a>
                                            @endif
                                            @if (auth()->user()->hasPermission('delete_students'))
                                                <form action="{{route('dashboard.students.destroy', $student->id)}}" method="POST" style="display: inline-block">
                                                    {{ csrf_field() }}
                                                    {{ method_field('delete')}}
                                                    <button type="submit" class="delete" style="background-color: white; border: none"><i class="fa fa-trash" style="color: red"></i></button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{-- {{ $students->appends(request()->query())->links() }} --}}
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
    $(function(){

        $('#studenttable').DataTable({
         "pageLength": 10,

        });

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
        }
    });

</script>
@endsection
