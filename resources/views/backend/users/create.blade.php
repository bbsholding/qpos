@extends('backend.master')

@section('title', 'Créer un utilisateur')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('backend.admin.user.create') }}" method="post" class="accountForm"
                enctype="multipart/form-data">
                @csrf
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="fullName" class="form-label">Nom complet</label>
                            <input type="text" class="form-control" id="fullName" placeholder="Entrer le nom complet"
                                name="name" value="{{ old('name') }}" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email" class="form-label">Email de connexion</label>
                            <input type="text" class="form-control" id="email" placeholder="Email" name="email"
                                value="{{ old('email') }}" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="confirmPassword" class="form-label">Rôle & Permissions</label>
                            <select class="custom-select" name="role" required>
                                <option value="">-- Sélectionner un rôle ---</option>
                                @foreach ($roles as $role)
                                    <option {{ old('role') == $role->id ? 'selected' : '' }} value="{{ $role->id }}">
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control" id="password" placeholder="Entrer le mot de passe"
                                name="password" value="{{ old('password') }}" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="thumbnail">Image de profil</label>
                            <input type="file" class="form-control" name="profile_image"
                                onchange="previewThumbnail(this)">
                            <img class="img-fluid thumbnail-preview" src="{{ nullImg() }}" alt="preview-image">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-block bg-gradient-primary">Créer</button>
            </form>
        </div>
    </div>
@endsection
