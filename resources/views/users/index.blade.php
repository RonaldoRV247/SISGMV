@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Usuarios') }}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content container">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">

                    <div class="alert alert-info">
                        Listado de todos los usuarios registrados en el sistema.
                    </div>

                    <div class="card container">
                        <div class="card-body p-0">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary m-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Registrar Nuevo Usuario
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Crear nuevo usuario</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            
                                <div class="card-body login-card-body">
                                <form method="POST" action="{{ route('users.store') }}">
                                @csrf

                                <div class="input-group mb-3">
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                        placeholder="{{ __('Nombre') }}" required autocomplete="name" autofocus>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-user"></span>
                                        </div>
                                    </div>
                                    @error('name')
                                    <span class="error invalid-feedback">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>

                                <div class="input-group mb-3">
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                        placeholder="{{ __('Email') }}" required autocomplete="email">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-envelope"></span>
                                        </div>
                                    </div>
                                    @error('email')
                                    <span class="error invalid-feedback">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>

                                <div class="input-group mb-3">
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                        placeholder="{{ __('Contraseña') }}" required autocomplete="new-password">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-lock"></span>
                                        </div>
                                    </div>
                                    @error('password')
                                    <span class="error invalid-feedback">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>

                                <div class="input-group mb-3">
                                    <input type="password" name="password_confirmation"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        placeholder="{{ __('Confirmar contraseña') }}" required autocomplete="new-password">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-lock"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="input-group mb-3">
                                    <select name="role" id="role" class="form-control" required>
                                        <option selected hidden>Seleccionar rol</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-tool"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary btn-block">{{ __('Registrarse') }}</button>
                                    </div>
                                </div>
                            </form>
                                </div>
                            
                            </div>
                            </div>
                        </div>
                        </div>
                        <table class="table table-bordered table-hover" id="usuarios" style="width:100%;text-align: center;">
                            <thead class="table-dark" style="width:100%;text-align: center;">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Acciones</th> <!-- Nueva columna para acciones -->
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <!-- Enlace para editar roles -->
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Editar Roles</a>
                                        <!-- Botón para eliminar usuario -->
                                        <button type="button" class="btn btn-danger btn-delete" data-id="{{ $user->id }}" data-name="{{ $user->name }}">Eliminar</button>
                                        <!-- Botón para restablecer contraseña -->
                                        <button type="button" class="btn btn-warning btn-reset-password" data-id="{{ $user->id }}" data-name="{{ $user->name }}">Restablecer Contraseña</button>
                                        <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                            const deleteButtons = document.querySelectorAll('.btn-delete');
                                            const resetPasswordButtons = document.querySelectorAll('.btn-reset-password');

                                            deleteButtons.forEach(button => {
                                                button.addEventListener('click', function () {
                                                    const userId = this.getAttribute('data-id');
                                                    const userName = this.getAttribute('data-name');

                                                    Swal.fire({
                                                        title: `¿Estás seguro de que deseas eliminar a ${userName}?`,
                                                        text: "¡Esta acción no se puede deshacer!",
                                                        icon: 'warning',
                                                        showCancelButton: true,
                                                        confirmButtonColor: '#3085d6',
                                                        cancelButtonColor: '#d33',
                                                        confirmButtonText: 'Sí, eliminar',
                                                        cancelButtonText: 'Cancelar'
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            const form = document.createElement('form');
                                                            form.action = `/users/${userId}`;
                                                            form.method = 'POST';
                                                            form.innerHTML = `
                                                                @csrf
                                                                @method('DELETE')
                                                            `;
                                                            document.body.appendChild(form);
                                                            form.submit();
                                                        }
                                                    });
                                                });
                                            });

                                            resetPasswordButtons.forEach(button => {
                                                button.addEventListener('click', function () {
                                                    const userId = this.getAttribute('data-id');
                                                    const userName = this.getAttribute('data-name');

                                                    Swal.fire({
                                                        title: `¿Estás seguro de que deseas restablecer la contraseña de ${userName}?`,
                                                        text: "La nueva contraseña será generada automáticamente.",
                                                        icon: 'warning',
                                                        showCancelButton: true,
                                                        confirmButtonColor: '#3085d6',
                                                        cancelButtonColor: '#d33',
                                                        confirmButtonText: 'Sí, restablecer',
                                                        cancelButtonText: 'Cancelar'
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            fetch(`/users/${userId}/reset-password`, {
                                                                method: 'POST',
                                                                headers: {
                                                                    'Content-Type': 'application/json',
                                                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                                },
                                                            })
                                                            .then(response => {
                                                                if (!response.ok) {
                                                                    throw new Error(response.statusText);
                                                                }
                                                                return response.json();
                                                            })
                                                            .then(data => {
                                                                Swal.fire({
                                                                    title: `Contraseña Restablecida`,
                                                                    text: `La nueva contraseña de ${userName} es: ${data.new_password}`,
                                                                    icon: 'success'
                                                                });
                                                            })
                                                            .catch(error => {
                                                                Swal.fire({
                                                                    title: `Error`,
                                                                    text: `No se pudo restablecer la contraseña: ${error}`,
                                                                    icon: 'error'
                                                                });
                                                            });
                                                        }
                                                    });
                                                });
                                            });
                                        });
                                    </script>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer clearfix">
                            {{ $users->links() }}
                        </div>
                    </div>

                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection
