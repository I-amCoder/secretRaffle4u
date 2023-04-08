@php
	$captcha = loadCustomCaptcha();
@endphp
@if($captcha)
    <div class="form-group">
        @php echo $captcha @endphp
    </div>
    <div class="form-group">
        <input type="text" name="captcha" placeholder="@lang('Enter Code')" class="form--control">
    </div>
@endif
