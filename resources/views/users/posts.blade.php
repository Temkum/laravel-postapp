@extends('layouts.app')

@section('content')
  <div class="flex justify-center">
    <div class="w-5/12">

      <div class="p-6">
        <h1 class="text-2xl font-medium mb-1">{{ $user->name }}</h1>
        <p class="">Posted {{ $posts->count() }} {{ Str::plural('post', $posts->count()) }} and received
          {{ $user->receivedLikes()->count() }}
          likes </p>
      </div>

      <div class="bg-white p-6 rounded-lg">
        @if ($posts->count())
          @foreach ($posts as $post)
            <x-post :post="$post" />
          @endforeach

          {{-- pagination --}}
          {{ $posts->links() }}
        @else
          <p>{{ $user->name }} does not have any posts!</p>
        @endif

      </div>

    </div>
  </div>
@endsection
