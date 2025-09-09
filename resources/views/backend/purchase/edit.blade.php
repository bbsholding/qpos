@extends('backend.master')

@section('title', 'Modifier l\'achat')

@section('content')
<div class="card">
  <div class="card-body">
    <form action="{{ route('backend.admin.customers.update',$customer->id) }}" method="post" class="accountForm"
      enctype="multipart/form-data">
      @method('PUT')
      @csrf
      <div class="card-body row">
        <div class="mb-3 col-md-6">
          <label for="title" class="form-label">
            Nom
            <span class="text-danger">*</span>
          </label>
          <input type="text" class="form-control" placeholder="Entrez le nom" name="name"
            value="{{ $customer->name }}" required>
        </div>
        <div class="mb-3 col-md-6">
          <label for="title" class="form-label">
            Téléphone
            <span class="text-danger">*</span>
          </label>
          <input type="text" class="form-control" placeholder="Entrez le téléphone" name="phone"
            value="{{ $customer->phone }}" required>
        </div>
        <div class="mb-3 col-md-6">
          <label for="title" class="form-label">
            Adresse
          </label>
          <input type="text" class="form-control" placeholder="Entrez l'adresse" name="address"
            value="{{ $customer->address }}">
        </div>
      </div>
      <!-- /.card-body -->
  <button type="submit" class="btn btn-block bg-gradient-primary">Mettre à jour</button>
    </form>
  </div>
</div>
@endsection
@push('script')
<script>
</script>
@endpush
