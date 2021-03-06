@extends('layouts.teacher')

@section('breadcrumb')
@include('layouts.breadcrumbstart')
<li>
    <a href="/classroom/{{ $class->code }}">
        <span class="icon is-small">
            <i class="fad fa-home" aria-hidden="true"></i>
        </span>
        <span>{{ __('general.home') }}</span>
    </a>
</li>
<li class="is-active">
    <a href="#">
        <span class="icon is-small">
            <i class="fad fa-sliders-v-square mr-2" aria-hidden="true"></i>
        </span>
        <span>{{ __('menu.settings') }}</span>
    </a>
</li>
@include('layouts.breadcrumbend')
@endsection

@section('content')
<settings :tz="{{ json_encode(timezone_identifiers_list()) }}" :settings="{{ json_encode($settings) }}" :teachers="{{ $teachers }}" :user="{{ auth()->user() }}" :is-admin="{{ $isAdmin ?? 0 }}" :classroom="{{ $class }}"></settings>
@endsection
