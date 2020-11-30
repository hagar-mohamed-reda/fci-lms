
<div class="material-switch pull-right w3-margin-top">
    <input type="hidden" name="student_id[]" value="{{ $student->id }}" >  
    <input 
        id="studentSwitch{{ $student->id }}" 
        {{ optional($course)->hasStudent($student->id)? 'checked' : '' }}
    value="{{ optional($course)->hasStudent($student->id)? '1' : '0' }}"
    name="assign[]"  
    onchange="this.checked? this.value = 1 : this.value = 0"
    type="checkbox"/>
    <label for="studentSwitch{{ $student->id }}" class="label-primary"></label>
</div>