@foreach (Core::per_page() as $value)
    <option @if(isset($selected) && $selected === $value) selected="selected" @endif value="{{ $value }}">{{ $value }} {{ $label }}</option>
@endforeach