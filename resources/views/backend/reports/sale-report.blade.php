@extends('backend.master')

@section('title', 'Rapport de Vente')

@section('content')
<div class="card">
  <div class="mt-n5 mb-3 d-flex justify-content-end">
    <div class="form-group">
      <div class="input-group">
        <button type="button" class="btn btn-default float-right" id="daterange-btn">
          <i class="far fa-calendar-alt"></i> Filtrer par date
          <i class="fas fa-caret-down"></i>
        </button>
      </div>
    </div>
  </div>
  <div class="card-body p-2 p-md-4 pt-0">
    <div class="row g-4">
      <div class="col-md-12">
        <div class="card-body p-0">
          <section class="invoice">
            <!-- info row -->
            <div class="row invoice-info">
              <div class="col-sm-4">
              </div>
              <!-- /.col -->
              <div class="col-sm-4">
                <address>
                  <strong>Rapport de Vente ({{$start_date}} - {{$end_date}})</strong><br>
                </address>
              </div>
              <!-- /.col -->
              <div class="col-sm-2">
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row justify-content-center">
              <div class="col-12">
                <table id="datatables" class="table table-hover">
                  <thead>
                    <tr>
                      <th data-orderable="false">#</th>
                      <th>ID Vente</th>
                      <th>Client</th>
                      <th>Date</th>
                      <th>Article</th>
                      <th>Sous-total {{currency()->symbol??''}}</th>
                      <th>Remise {{currency()->symbol??''}}</th>
                      <th>Total {{currency()->symbol??''}}</th>
                      <th>Payé {{currency()->symbol??''}}</th>
                      <th>Reste {{currency()->symbol??''}}</th>
                      <th>Statut</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($orders as $index => $order)
                    <tr>
                      <td>{{ $index + 1 }}</td>
                      <td>#{{$order->id}}</td>
                      <td>{{ $order->customer->name ?? '-' }}</td>
                      <td>{{ $order->created_at->format('d-m-Y') }}</td>
                      <td>{{$order->total_item}}</td>
                      <td>{{number_format($order->sub_total,2,'.',',')}}</td>
                      <td>{{number_format($order->discount,2,'.',',')}}</td>
                      <td>{{number_format($order->total,2,'.',',')}}</td>
                      <td>{{number_format($order->paid,2,'.',',')}}</td>
                      <td>{{number_format($order->due,2,'.',',')}}</td>
                      <td>
                        @if ($order->status)
                        Payé
                        @else
                        Reste
                        @endif
                      </td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="11" class="text-center">Aucune vente trouvée.</td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
            <div class="row no-print">
              <div class="col-12">
                <button type="button" onclick="window.print()" class="btn btn-success float-right"><i class="fas fa-print"></i> Imprimer</a>
                </button>
              </div>
            </div>
            <!-- /.row -->
          </section>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('style')
<style>
  .invoice {
    border: none !important;
  }
</style>
@endpush
@push('script')
<script>
  $(function() {
    // Extraire les dates de début et de fin des paramètres URL
    const urlParams = new URLSearchParams(window.location.search);
    const startDate = urlParams.get('start_date') || moment().subtract(29, 'days').format('YYYY-MM-DD'); // Par défaut, les 30 derniers jours
    const endDate = urlParams.get('end_date') || moment().format('YYYY-MM-DD'); // Par défaut, aujourd'hui

    // Initialiser le sélecteur de plage de dates
    $('#daterange-btn').daterangepicker({
        ranges: {
          'Aujourd\'hui': [moment(), moment()],
          'Hier': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          '7 derniers jours': [moment().subtract(6, 'days'), moment()],
          '30 derniers jours': [moment().subtract(29, 'days'), moment()],
          'Ce mois-ci': [moment().startOf('month'), moment().endOf('month')],
          'Mois dernier': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment(startDate, "YYYY-MM-DD"),
        endDate: moment(endDate, "YYYY-MM-DD")
      },
      function(start, end) {
        // Mettre à jour le texte du bouton avec la plage sélectionnée
        $('#daterange-btn span').html(start.format('D MMMM YYYY') + ' - ' + end.format('D MMMM YYYY'));

        // Rediriger avec les dates sélectionnées
        window.location.href = '{{ route("backend.admin.sale.report") }}?start_date=' + start.format('YYYY-MM-DD') + '&end_date=' + end.format('YYYY-MM-DD');
      }
    );

    // Afficher la plage de dates initiale sur le bouton
    $('#daterange-btn span').html(moment(startDate, "YYYY-MM-DD").format('D MMMM YYYY') + ' - ' + moment(endDate, "YYYY-MM-DD").format('D MMMM YYYY'));
  });
</script>
@endpush
