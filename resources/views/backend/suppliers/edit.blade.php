@extends('backend.master')

@section('title', 'Modifier un fournisseur')

@section('content')
<div class="card">
  <div class="card-body">
    <form action="{{ route('backend.admin.suppliers.update',$supplier->id) }}" method="post" class="accountForm"
      enctype="multipart/form-data">
      @method('PUT')
      @csrf
      <div class="card-body">
        <div class="row">
          <div class="mb-3 col-md-6">
            <label for="title" class="form-label">
              Nom
              <span class="text-danger">*</span>
            </label>
            <input type="text" class="form-control" placeholder="Entrez le nom" name="name"
              value="{{ $supplier->name }}" required>
          </div>
          <div class="mb-3 col-md-6">
            <label for="title" class="form-label">
              Téléphone
              <span class="text-danger">*</span>
            </label>
            <input type="text" class="form-control" placeholder="Entrez le téléphone" name="phone"
              value="{{ $supplier->phone }}" required>
          </div>
          <div class="mb-3 col-md-6">
            <label for="title" class="form-label">
              Adresse
            </label>
            <input type="text" class="form-control" placeholder="Entrez l'adresse" name="address"
              value="{{ $supplier->address }}">
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <button type="submit" class="btn bg-gradient-primary">Mettre à jour</button>
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
