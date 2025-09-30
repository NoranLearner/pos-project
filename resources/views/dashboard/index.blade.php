@extends('layouts.dashboard.app')

@section('title', 'Dashboard')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <ol class="breadcrumb !static !float-left rtl:!float-right !text-xl">
                <li class="active"><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
            </ol>

            <div class="clearfix"></div>

            <h1 class="!my-5">@lang('site.dashboard')</h1>

        </section>

        <section class="content">



        </section>

    </div>

@endsection
