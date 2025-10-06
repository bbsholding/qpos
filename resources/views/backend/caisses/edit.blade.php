@extends('backend.master')

@section('title', 'Modifier la caisse')

@section('content')
<div class="card">
  <div class="card-body">
    <form action="{{ route('backend.admin.caisses.update',$caisse->id) }}" method="post" class="accountForm">
      @method('PUT')
      @include('backend.caisses._form',[ 'caisse' => $caisse ])
    </form>
  </div>
</div>
@endsection
@push('script')

@endpush
