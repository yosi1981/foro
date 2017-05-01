<select title="{{ $setting->display_name }}" class="form-control" name="{{ $setting->name }}" id="{{ $setting->name }}">
    @foreach ($setting->selectOptions as $option)
        <option @if($option == $setting->value) selected="selected" @endif value="{{ $option }}">{{ $option }}</option>
    @endforeach
</select>