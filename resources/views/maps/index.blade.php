@extends('layouts.teacher')

@section('content')
<div class="columns is-multiline is-variable is-1 has-margin-y-2">

    <div class="column has-padding-y-2 is-6-tablet is-12-mobile is-3-desktop is-3-fullhdbox">
      <div class="box w-100 h-100 is-flex is-all-centered">
        <h3 class="w-100 has-text-centered">
          <a href="/classroom/{{ $class->code }}/maps/create" class="is-rounded text-center pointer">
            <i class="fal fa-user mr-2"></i> {{ __('map.create') }}
          </a>
        </h3>
      </div>
    </div>

  @foreach ($class->maps as $map)

  <div class="column has-padding-y-2 is-6-tablet is-12-mobile is-3-desktop is-3-fullhdbox has-margin-bottom-0 is-flex is-all-centered">
    <div class="box w-100 h-100 d-flex is-relative rounded classroom-round text-center">
      <h3 class="is-size-4 has-text-light">
        
        @if($map->active)
        <a href="/classroom/{{ $class->code }}/maps/{{ $map->code }}" class="has-text-bold">
        @else
        <a href="/classroom/{{ $class->code }}/maps/{{ $map->code }}" class="has-text-light">
        @endif
            {{ $map->name }}
          </a>
      </h3>
    </div>
  </div>
  @endforeach
</div>
@endsection