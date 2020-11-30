@if ($problem->status == 'default')
<div style="width: 220px" style="form-group form-inline" >
    <select class="form-control problem-{{ $problem->id }}"  >
        <option value="" >{{ __('site.change_status') }}</option>
        <option value="success" >{{ __('site.success') }}</option>
        <option value="warning" >{{ __('site.warning') }}</option>
        <option value="error" >{{ __('site.error') }}</option>
    </select>
    <br>
    <textarea class="form-control problem-comment-{{ $problem->id }}" placeholder="{{ __('site.write_comment') }}" ></textarea>
    <button class="btn btn-success" onclick="updateStatus('{{ $problem->id }}', $('.problem-{{ $problem->id }}').val(), $('.problem-comment-{{ $problem->id }}').val(), this)" >
        <i class="fa fa-check" ></i>
    </button>
</div>
@endif
