@extends('hangarauto::layouts.master')

@push('breadcrumbs')
    <li class="breadcrumb-item active">{{ trans('hangarauto::Soat.Soat') }}</li>
@endpush

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https:://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection

@section('content')
    <!-- Main Content -->
    <div class="container-fluid">
        <div class="row">
            <div class="col pt-4">
                <div class="card-header">
                    <h4>{{trans('hangarauto::Soat.Soat')}}</h3>
                </div><br>
                @include('hangarauto::admin.revisiones.SOAT.create')
                <div class="card">
                    <div class="card-body">
                        <table id="Travel" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <th>#</th>
                                <th>{{trans('hangarauto::Vehiculos.Vehicle') }}</th>
                                <th>{{trans('hangarauto::Vehiculos.Responsability') }}</th>
                                <th>{{trans('hangarauto::Vehiculos.Review Date') }}</th>
                                <th>{{trans('hangarauto::Vehiculos.Expiration Date') }}</th>
                                <th>{{trans('hangarauto::Drivers.Actions') }}</th>
                            </thead>
                            <tbody>
                                @foreach($Soat as $s)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$s->vehicle->name}}</td>
                                        <td>{{$s->person->fullname}}</td>
                                        <td>{{$s->review_date}}</td>
                                        <td>{{$s->expiration_date}}</td>
                                        <td>
                                            <a class="btn btn-primary" href="{{ route('hangarauto.'. getRoleRouteName(Route::currentRouteName()) .'.soat.edit', $s->id) }}" type="button"><i class="fas fa-edit"></i></a>
                                            <a class="btn btn-danger btn-delete" href="{{ route('hangarauto.'. getRoleRouteName(Route::currentRouteName()) .'.soat.delete', $s)}}" data-action="eliminar" data-toggle="tooltip" data-placement="top" title="Eliminar">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Manejar clics en el enlace de eliminar
            $('.btn-delete').click(function(e) {
                e.preventDefault();
                var url = $(this).attr('href');
                
                // Mostrar alerta de confirmación de SweetAlert
                Swal.fire({
                    title: "¿Estás seguro?",
                    text: "Una vez eliminado, ¡no podrás recuperar este registro!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Sí, eliminar",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Si el usuario confirma, redirigir al enlace de eliminación
                        window.location.href = url;
                    }  else {
                        Swal.fire('Cancelado', 'La acción ha sido cancelada', 'info');
                    }
                });
            });
        });
    </script>
@endsection