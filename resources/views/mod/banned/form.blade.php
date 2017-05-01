<form id="ban-user-form" method="POST" class="form-horizontal" action="{{ $member->isBanned() ? route('mod.banned.update', $member->info) : route('mod.banned.store', $member->info) }}">
    {{ csrf_field() }}
    @if ($member->isBanned())
        {{ method_field('PATCH') }}
    @endif
    <div class="form-group">
        <label class="col-sm-2 control-label" for="length">{{ trans('mod.banned.length') }}</label>
        <div class="col-md-4 col-sm-6">
            <select name="length" id="length" class="form-control">
                <optgroup label="Minutes">
                    <option value="5">5 Minutes</option>
                    <option value="10">10 Minutes</option>
                    <option value="30">30 Minutes</option>
                    <option value="45">45 Minutes</option>
                </optgroup>
                <optgroup label="Hours">
                    <option value="60">1 Hour</option>
                    <option value="120">2 Hours</option>
                    <option value="300">5 Hours</option>
                    <option value="240">4 Hours</option>
                    <option value="600">10 Hours</option>
                    <option value="1440">24 Hours</option>
                </optgroup>
                <optgroup label="Days">
                    <option value="2880">2 Days</option>
                    <option value="7200">5 Days</option>
                    <option value="14400">10 Days</option>
                    <option value="28800">20 Days</option>
                </optgroup>
                <optgroup label="Month">
                    <option value="43800">1 Month</option>
                    <option value="262800">6 Months</option>
                    <option value="525601">1 Year</option>
                    <option value="1051000">5 Years</option>
                </optgroup>
                <option value="0">Forever</option>
                <option {{ $member->isBanned()  ? 'selected' : ''}} value="custom">Custom</option>
            </select>
            <span class="help-block">{{ trans('mod.banned.expiry_desc') }}</span>
        </div>
    </div>
    <div @if (!$member->isBanned()) style="display:none" @endif id="custom-date">
        <div class="form-group">
            <label class="col-sm-2 control-label" for="custom">{{ trans('mod.banned.custom_date') }}</label>
            <div class="col-md-4 col-sm-6">
                <input value="{{ old('custom', $member->isBanned() ? $member->ban->getOriginal('expires_at') : '') }}" name="custom" id="custom" type="text" class="form-control"/>
                <span class="help-block">{{ trans('mod.banned.custom_date_desc') }}</span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="reason">{{ trans('mod.banned.reason') }}</label>
        <div class="col-md-4 col-sm-6">
            <textarea rows="3" name="reason" id="reason" placeholder="Reason" class="form-control">{{ old('reason', $member->isBanned() ? $member->ban->reason : '') }}</textarea>
            <br>
            <button type="submit" class="btn btn-default">
                @if ($member->isBanned())
                    <i class="fa fa-check"></i>
                    {{ trans('mod.banned.update') }}
                @else
                    <i class="fa fa-ban"></i>
                    {{ trans('mod.banned.ban') }} {{ $member->info }}
                @endif
            </button>
        </div>
    </div>
</form>
@if ($member->isBanned())
    <div class="text-right">
        @include('mod.banned.partials.delete_button', ['ban' => $member->ban])
    </div>
@endif
<script>banUser()</script>
