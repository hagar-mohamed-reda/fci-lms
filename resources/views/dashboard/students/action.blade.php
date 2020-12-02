@if ($type == 'active')
<div class="form-group">
    <div class="custom-control custom-switch material-switch">
        <input
        type="checkbox"
         class="custom-control-input checkinp"
        id="studentSwitch{{$student->id}}" {{ $student->active == 1? 'checked' : ''}} value="{{ $student->active == 1? '1' : '0'}}" name="active"
        onchange="this.checked? this.value = 1 : this.value = 0" sid="{{$student->id}}">
         <label class="custom-control-label" for="studentSwitch{{$student->id}}"></label>
         {{-- onclick="changeActive({{$student->id}},this.value)" --}}
    </div>
</div>

@elseif ($type == 'account_confirm')

    @if ($student->account_confirm == 0)
        @lang('site.no')
    @else
        @lang('site.yes')
    @endif

@elseif ($type == 'action')

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

@endif
