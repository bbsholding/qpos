@csrf
<div class="card-body">
  <div class="row">
    <div class="mb-3 col-md-6">
      <label for="nom" class="form-label">
        Nom
        <span class="text-danger">*</span>
      </label>
      <input type="text" class="form-control" placeholder="Entrez le nom" name="nom"
        value="{{ old('nom', isset($caisse) ? $caisse->nom : '') }}" required>
    </div>
    <div class="mb-3 col-md-6">
      <label for="lieu" class="form-label">
        Emplacement
      </label>
      <input type="text" class="form-control" placeholder="Entrez l'emplacement" name="lieu"
        value="{{ old('lieu', isset($caisse) ? $caisse->lieu : '') }}">
    </div>
    <div class="mb-3 col-md-12">
      <div class="form-switch px-4">
        <input type="hidden" name="is_active" value="0">
        <input class="form-check-input" type="checkbox" name="is_active" id="active"
          value="1" {{ old('is_active', isset($caisse) ? (int)$caisse->is_active : 1) ? 'checked' : '' }}>
        <label class="form-check-label" for="active">
          Actif
        </label>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <button type="submit" class="btn bg-gradient-primary">{{ isset($caisse) ? 'Mettre à jour' : 'Créer' }}</button>
    </div>
  </div>
</div>

