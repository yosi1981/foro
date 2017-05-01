<select title="{{ $setting->display_name }}" class="form-control" name="{{ $setting->name }}" id="{{ $setting->name }}">
    <option @if($setting->value) selected="selected" @endif value="1">{{ trans('site.yes') }}</option>
    <option @if(!$setting->value) selected="selected" @endif value="0">{{ trans('site.no') }}</option>
</select>