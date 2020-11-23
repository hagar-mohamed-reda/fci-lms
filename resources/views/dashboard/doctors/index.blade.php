@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">
            <section class="content-header">
                <h1>@lang('site.doctors')</h1>
                <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                    <li class="active"> @lang('site.doctors')</li>
                </ol>
            </section>
            <section class="content">

                <div class="box box-primary">

                    <div class="box-header with-border">
                        <h3 class="box-title" style="margin-bottom: 15px">@lang('site.doctors') {{--<small>{{$doctors->total()}}</small>--}}</h3>
                        <form action="{{ route('dashboard.doctors.index')}}" method="GET">
                            <div class="row">
                                {{-- <div class="col-md-4">
                                    <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{ request()->search}}">
                                </div> --}}
                                <div class="col-md-4">
                                    {{-- <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button> --}}

                                    @if (auth()->user()->hasPermission('create_doctors'))
                                        <a href=" {{route('dashboard.doctors.create')}}" class="btn btn-success"><i class="fa fa-plus"></i> @lang('site.add')</a>
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
                        <!-- Default checked -->


                        @if ($doctors->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover" id="doctortable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('site.name')</th>
                                        <th>@lang('site.email')</th>
                                        <th>@lang('site.phone')</th>
                                        <th>@lang('site.subjects')</th>
                                        <th>@lang('site.active')</th>
                                        <th>@lang('site.account_confirm')</th>
                                        {{--<th>@lang('site.image')</th>--}}
                                        <th>@lang('site.action')</th>
                                    </tr>
                                </thead>
                                 {{-- <tbody>
                                    @foreach ($doctors as $index=>$doctor)
                                    <tr>
                                        <td>{{ $index + 1}}</td>
                                        <td>{{ $doctor->name}}</td>
                                        <td>{{ $doctor->email}}</td>
                                        <td>{{ $doctor->subjects->count()}} <a href="{{route('dashboard.subjects.index', ['doc_id' => $doctor->id])}}" class="btn btn-info btn-sm">@lang('site.go')</a> </td>
                                        <td>{{ is_array($doctor->phone) ? implode($doctor->phone, '-') : $doctor->phone }}</td>
                                        <td>
                                            <div class="form-group">
                                                <div class="custom-control custom-switch material-switch">
                                                    <input type="checkbox" class="custom-control-input" id="doctorSwitch{{$doctor->id}}" {{ $doctor->active == 1? 'checked' : ''}} value="{{ $doctor->active == 1? '1' : '0'}}" onclick="setTimeout(function(){$('.student-assign-course-form').submit()}, 1000)"
                                                    onchange="this.checked? this.value = 1 : this.value = 0"
                                                    type="checkbox">
                                                    <label class="custom-control-label" for="doctorSwitch{{$doctor->id}}"></label>
                                                </div>
                                            </div>


                                        </td>
                                        <td>
                                            @if ($doctor->account_confirm == 0)
                                                @lang('site.no')
                                            @else
                                                @lang('site.yes')
                                            @endif

                                        </td>
                                        <td>
                                            @if (auth()->user()->hasPermission('update_doctors'))
                                                <a href=" {{ route('dashboard.doctors.edit', $doctor->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                            @endif
                                            @if (auth()->user()->hasPermission('delete_doctors'))
                                                <form action="{{route('dashboard.doctors.destroy', $doctor->id)}}" method="POST" style="display: inline-block">
                                                    {{ csrf_field() }}
                                                    {{ method_field('delete')}}
                                                    <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody> --}}
                                <tbody>

                                </tbody>

                            </table>
                        </div>
                            {{-- {{ $doctors->appends(request()->query())->links() }} --}}
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
        <form action="{{ route('dashboard.doctors.import') }}" method="post" data-toggle="validator" enctype="multipart/form-data">
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
                        <a href="{{ route('dashboard.doctors.export') }}" class="btn btn-success">Export</a>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>
            </div>

            @if (auth()->user()->hasPermission('create_doctors'))
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
    // $('#doctortable').DataTable({
    //      "pageLength": 10,

    //     });
        $(function() {
            $('#doctortable').DataTable({
                "processing" : true,
                "serverSide ": true,
                "sorting": [0, 'DESC'],
                "ajax" : {
                    "url" : "{{ route('dashboard.doctors.data') }}",
                    "type": "POST",
                    data: {'_token':$('input[name=_token]').val()}
                },
                "columns" : [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone' },
                    { data: 'subjects', name: 'subjects' },
                    { data: 'active', name: 'active' },
                    { data: 'account_confirm', name: 'account_confirm' },
                    { data: 'action', name: 'action' },
                ],
                "dom" : 'lBfrtip',
                "buttons" : [
                    'copy', 'csv', 'excel', 'pdf','print',
                    ]
            });

            $.fn.dataTable.ext.errMode = 'throw';
        });
</script>
@endsection
