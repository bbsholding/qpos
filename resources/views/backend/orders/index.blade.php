@extends('backend.master')

@section('title', 'Vente')

@section('content')
<div class="card">
  <div class="card-body p-2 p-md-4 pt-0">
    <div class="row g-4">
      <div class="col-md-12">
        <div class="card-body table-responsive p-0" id="table_data">
          <table id="datatables" class="table table-hover">
            <thead>
              <tr>
                <th data-orderable="false">#</th>
                <th>ID Vente</th>
                <th>Client</th>
                <th>Article</th>
                <th>Sous-total {{currency()->symbol??''}}</th>
                <th>Remise {{currency()->symbol??''}}</th>
                <th>Total {{currency()->symbol??''}}</th>
                <th>Payé {{currency()->symbol??''}}</th>
                <th>Due {{currency()->symbol??''}}</th>
                <th>Status</th>
                <th data-orderable="false">Action</th>
              </tr>
            </thead>
          </table>
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
      serverSide: true,
      ordering: true,
      order: [
        [1, 'desc']
      ],
      ajax: {
        url: "{{ route('backend.admin.orders.index') }}"
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
          data: 'saleId',
          name: 'saleId'
        },
        {
          data: 'customer',
          name: 'customer'
        },
        {
          data: 'item',
          name: 'item'
        },
        {
          data: 'sub_total',
          name: 'sub_total'
        },
        {
          data: 'discount',
          name: 'discount'
        },
        {
          data: 'total',
          name: 'total'
        },
         {
          data: 'paid',
          name: 'paid'
        },
         {
          data: 'due',
          name: 'due'
        },
        {
          data: 'status',
          name: 'status'
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
