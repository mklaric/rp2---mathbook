@extends('layouts.gui', ['name' => $page->name])
@section('content')

<div class="markdown staticPageContent" content="{{ Storage::disk('local')->get('pages/' . $page->id . '/static/' . $module->link) }}">
{{ Storage::disk('local')->get('pages/' . $page->id . '/static/' . $module->link) }}
</div>

<script>
    $(document).ready(function () {
        var formHTML = '{{ csrf_field() }}';
        var nameVal = "{{ old('name', $module->pageModule()->sidebarLink->name) }}";
        var linkVal = "{{ old('link', $module->link) }}";

        setupStatic(formHTML, nameVal, linkVal);
    });
</script>

@endsection
