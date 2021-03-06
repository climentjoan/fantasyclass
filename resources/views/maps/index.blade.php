@extends('layouts.teacher')

@section('help')
  <span class="mr-3"><i class="fas fa-question-circle"></i> {{ __('general.help') }}</span> <a href="https://youtu.be/b2QcE7VwJXE" target="_blank"><i class="fab fa-youtube mr-3 has-text-danger" style="font-size: 2em;"></i></a></span>
@endsection

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
          <i class="fad fa-map-marked-alt" aria-hidden="true"></i>
        </span>
        <span>{{ __('menu.map') }}</span>
    </a>
</li>
@include('layouts.breadcrumbend')
@endsection

@section('content')
<div>
  <show-maps code="{{ $class->code }}" maps="{{ $maps }}" active-map="{{ $activeMap }}"></show-behaviours>
</div>
@endsection