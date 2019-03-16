@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">

  <!-- Four columns -->
@foreach ($games->chunk(2) as $gameGroup)
  <div class="flex mb-4">
  @foreach($gameGroup as $game)
    <div class="flex-2 h-auto w-1/2">

      <div class="max-w-md w-full lg:flex">
          <div class="justify-center w-1/3 h-48 border-l border-b border-t border-r-0 border-grey-light rounded-l flex flex-none bg-white" >
          <image class="content-center h-48" src="{{ $game->front_box_art }}"></image>
        </div>
        <div class="w-2/3 mr-8 border-r border-b border-t border-l-0 border-grey-light bg-white rounded-r p-4 flex flex-col justify-between leading-normal">
          <div class="mb-8">
            <div class="text-black font-bold text-xl mb-2">{{ $game->title }}</div>
            <p class="text-grey-darker text-base">Game Description</p>
          </div>
        </div>
      </div>

    </div>
  @endforeach
  </div>
@endforeach

</div>
<div class="flex justify-center w-auto">
  {{ $games->links() }}
</div>
@endsection
