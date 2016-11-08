<?php use \Spatie\Permission\Models\Role; ?>


@extends('layouts.gui', ['name' => $page->name])

@section('content')
        @include('pages.settings.staticPages')
        @include('pages.settings.admins')
        @include('pages.settings.subscribers')
        @include('pages.settings.testsPage')
@endsection
