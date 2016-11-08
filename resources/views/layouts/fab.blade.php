@if (isset($fab))
<table class="fab_container">
    @foreach ($fab->buttons as $button)
    <tr>
        <td class="fab_label_wrapper">
            <label class="fab_label">{{ $button->label }}</label>                
        </td>
        <td class="fab_button_wrapper">
            <a href="{{ $button->link }}" id="{{ $button->id }}" class="fab_button {{ $button->color }}"><i class="fa fa-btn {{ $button->icon }} fab_icon"></i></a>
        </td>
    </tr>
    @endforeach
    <tr class="fab_main">
        <td class="fab_label_wrapper">
            <label class="fab_label">{{ $fab->main->label }}</label>
        </td>
        <td class="fab_main_button_wrapper">
            <a href="{{ $fab->main->link }}" id="{{ $fab->main->id }}" class="fab_main_button blue"><span><span class="rotate"></span></span></a>
        </td>
    </tr>
</table>
@endif
