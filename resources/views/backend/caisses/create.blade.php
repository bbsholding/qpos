@extends('backend.master')

@section('title', 'Créer une caisse')

@section('content')
<div class="card">
  <div class="card-body">
    <form action="{{ route('backend.admin.caisses.store') }}" method="post" class="accountForm">
      @include('backend.caisses._form')
    </form>
  </div>
</div>
@endsection

@push('style')
<style>
  .select2-container--default .select2-selection--single {
    height: calc(1.5em + 0.75rem + 2px) !important;
  }
</style>

@endpush
@push('script')
<script src="{{ asset('js/image-field.js') }}"></script>
<script>
  $(function() {
    //Date picker
    $('#reservationdate').datetimepicker({
      format: 'YYYY-MM-DD'
    });
  })
</script>
@endpush
