@extends('errors::minimal_with_extra_info')

@section('title', __('Account disabled'))
@section('code', '423')
@section('message', __('Your Account is disabled.'))
@section('info', __('Delete your cookies to get access to the homepage.'))
