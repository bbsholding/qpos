@extends('backend.master')

@section('title', 'Créer un client')

@section('content')
<div class="card">
  <div class="card-body">
    <form action="{{ route('backend.admin.customers.store') }}" method="post" class="accountForm"
      enctype="multipart/form-data">
      @csrf
      <div class="card-body">
        <div class="row">
          <div class="mb-3 col-md-6">
            <label for="title" class="form-label">
              Nom
              <span class="text-danger">*</span>
            </label>
            <input type="text" class="form-control" placeholder="Entrez le nom" name="name"
              value="{{ old('name') }}" required>
          </div>
          <div class="mb-3 col-md-6">
            <label for="title" class="form-label">
              Téléphone
              <span class="text-danger">*</span>
            </label>
            <input type="text" class="form-control" placeholder="Entrez le téléphone" name="phone"
              value="{{ old('phone') }}" required>
          </div>
          <div class="mb-3 col-md-6">
            <label for="title" class="form-label">
              Adresse
            </label>
            <input type="text" class="form-control" placeholder="Entrez l'adresse" name="address"
              value="{{ old('Address') }}">
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <button type="submit" class="btn bg-gradient-primary">Créer</button>
          </div>
        </div>
      </div>
      <!-- /.card-body -->
    </form>
  </div>
</div>
@endsection
@push('script')
<script>
</script>
@endpush
