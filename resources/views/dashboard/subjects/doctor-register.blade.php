
<form method="post" class="form" action="{{ route('dashboard.assignDoctorToCourse', $course->id) }}" >
    @csrf
    <ul class="w3-ul" style="overflow: auto;height: 400px" >
        <li class="w3-center w3-large" >
            @lang('register course to doctors')  - [{{ $course->name }}]
        </li>
        <li style="margin-bottom: 5px;padding: 0px" >
            <div class="shadow-1 w3-block w3-padding w3-display-container" style="border-radius: 2px;" >
                <input class="w3-input w3-block" onkeyup="searchDoctor(this.value)" placeholder="{{ __('search about doctor') }}" >
            </div>
        </li>
        @foreach(App\Doctor::all() as $item)
        <li class="w3-display-container doctor-list-item"  >
            <button type="button" class="btn w3-large w3-circle {{ randColor() }}" style="width: 50px;height: 50px" >
                <i class="fa fa-user-circle" ></i>
            </button>
            <b style="margin: 5px" >{{ $item->name }}</b>
            <input type="hidden" name="doctor_id[]" value="{{ $item->id }}" >

            <div class="w3-display-topleft w3-padding" >
                <div class="material-switch pull-right w3-margin-top">
                    <input
                        id="doctorSwitch{{ $item->id }}"
                        {{ $course->hasDoctor($item->id)? 'checked' : '' }}
                    value="{{ $course->hasDoctor($item->id)? '1' : '0' }}"
                    name="assign[]"
                    onchange="this.checked? this.value = 1 : this.value = 0"
                    type="checkbox"/>
                    <label for="doctorSwitch{{ $item->id }}" class="label-primary"></label>
                </div>

            </div>
        </li>
        @endforeach

    </ul>
    <ul class="w3-ul"  >
        <li>
            <button class="btn btn-primary w3-block" >{{ __('save') }}</button>
        </li>
    </ul>

</form>

<script>
    formAjax(true);
</script>
