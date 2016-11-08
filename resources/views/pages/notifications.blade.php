<?php use \Spatie\Permission\Models\Role; ?>


@extends('layouts.gui', ['name' => $page->name])

@section('content')
    @if (Auth::check() && Auth::user()->hasAnyRole(['admin', $page->id . '.admin']))
        @include('notifications.create')
    @endif
    @include('notifications.index')
@endsection
