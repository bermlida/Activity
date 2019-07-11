@extends('layouts.main')

@section('style')

    <!-- Bootstrap Social CSS -->
    <link href="{{ asset('components/bootstrap-social/bootstrap-social.css') }}" rel="stylesheet">

@endsection

@section('content')

<div class="container">
    
    <!-- Page Heading -->
    <div class="row">
        <div class="col-xs-12">
            @include('partials.alert-message')

            <h1 class="page-header">註冊</h1>
        </div>
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
            <a class="btn btn-block btn-social btn-{{ $social_provider }}" href="{{ route('social-auth::register::ask', ['social_provider' => $social_provider, 'role' => 'organizer']) }}" role="button">
                <i class="fa fa-{{ $social_provider }}" aria-hidden="true"></i>
                註冊為主辦單位
            </a>

            <div class="visible-xs-block">
                <hr>
            </div>

            <div class="hidden-xs">
                <br>
            </div>

            <a class="btn btn-block btn-social btn-{{ $social_provider }}" href="{{ route('social-auth::register::ask', ['social_provider' => $social_provider, 'role' => 'user']) }}" role="button">
                <i class="fa fa-{{ $social_provider }}" aria-hidden="true"></i>
                註冊為會員
            </a>
        </div>
    </div>

    <hr>

    <!-- Footer -->
    <footer>
        <div class="row">
            @include('partials.copyright-notice')
        </div>
    </footer>
</div>

@endsection
