@extends('layouts.app')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-12">
         <button type="button" id="addUser" class="uk-button uk-button-primary mb-2" uk-toggle="target: #my-id">
            Nuevo usuario
         </button>
         <div class="card">
            <div class="card-header">Listado de usuarios</div>

            <div class="card-body">
               @include('errors')

               <table id="userList" class="table">
                  <thead>
                     <tr>
                        <th scope="col">Cédula</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido</th>
                        <th scope="col">Acciones</th>
                     </tr>
                  </thead>
               </table>

            </div>

         </div>

         @include('users.form')

      </div>
   </div>
</div>
@endsection

