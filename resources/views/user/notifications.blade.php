<?php use \Spatie\Permission\Models\Role; ?>


@extends('layouts.gui', ['name' => 'Notifications'])

@section('content')
    @include('notifications.index')
@endsection
