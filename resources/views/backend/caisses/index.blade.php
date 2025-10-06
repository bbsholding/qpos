@extends('backend.master')

@section('title', 'Caisses')

@section('content')
<div class="card">

  @can('product_create')
  <div class="mt-n5 mb-3 d-flex justify-content-end">
    <a href="{{ route('backend.admin.caisses.create') }}" class="btn bg-gradient-primary">
      <i class="fas fa-plus-circle"></i>
      Ajouter une caisse
    </a>
  </div>
  @endcan
  <div class="card-body p-2 p-md-4 pt-0">
    <div class="row g-4">
      <div class="col-md-12">
        <div class="card-body table-responsive p-0" id="table_data">
          <table id="datatables" class="table table-hover">
            <thead>
              <tr>
                <th data-orderable="false">#</th>
                <th>Nom</th>
                <th>Emplacement</th>
                <th>Statut</th>
                <th data-orderable="false">Action</th>
              </tr>
            </thead>
          </table>
          <!-- Pagination Links -->
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('script')

<script type="text/javascript">
  $(function() {
    let table = $('#datatables').DataTable({
      processing: true,
      serverSide:true,
      ordering: true,
      ajax: {
        url: "{{ route('backend.admin.caisses.index') }}"
      },
      language: {
        "sProcessing":     "Traitement en cours...",
        "sSearch":        "Rechercher :",
        "sLengthMenu":    "Afficher _MENU_ éléments",
        "sInfo":          "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
        "sInfoEmpty":     "Affichage de l'élément 0 à 0 sur 0 élément",
        "sInfoFiltered":  "(filtré de _MAX_ éléments au total)",
        "sInfoPostFix":   "",
        "sLoadingRecords": "Chargement en cours...",
        "sZeroRecords":   "Aucun élément à afficher",
        "sEmptyTable":    "Aucune donnée disponible dans le tableau",
        "oPaginate": {
            "sFirst":      "Premier",
            "sPrevious":   "Précédent",
            "sNext":       "Suivant",
            "sLast":       "Dernier"
        },
        "oAria": {
            "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
            "sSortDescending": ": activer pour trier la colonne par ordre décroissant"
        }
      },

      columns: [{
          data: 'DT_RowIndex',
          name: 'DT_RowIndex'
        },
      
        {
          data: 'nom',
          name: 'nom'
        },
        {
          data: 'lieu',
          name: 'lieu'
        },
        {
          data: 'is_active',
          name: 'is_active'
        },
    
        {
          data: 'action',
          name: 'action'
        },
      ]
    });
  });
</script>
@endpush
