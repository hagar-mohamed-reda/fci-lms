@if(auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin'))
@if (auth()->user()->hasPermission('delete_regist'))
    <form action="{{route('dashboard.student_subjects.destroy', $stdSubject->id)}}" method="POST" style="display: inline-block">
    {{ csrf_field() }}
    {{ method_field('delete')}}
    <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i> @lang('site.delete')</button>
    </form>
@endif

@endif
