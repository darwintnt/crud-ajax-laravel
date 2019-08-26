<div id="my-id" uk-modal="bgClose: false">
   <div class="uk-modal-dialog">
      <button class="uk-modal-close-default" type="button" uk-close></button>
      <div class="uk-modal-header">
         <h2 class="uk-modal-title">
            Nuevo Usuario
         </h2>
      </div>
      <div class="uk-modal-body">
         <span id="messages_info"></span>
         <form method="POST" id="createUser" enctype="multipart/form-data">
            @csrf
            <div class="uk-grid-small uk-child-width-1-2@m" uk-grid>

               <div class="form-group">
                  <label for="name">Nombre(s)</label>
                  <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
               </div>

               <div class="form-group">
                  <label for="last_name">Apellido(s)</label>
                  <input type="text" class="form-control" id="last_name" name="last_name"
                     value="{{ old('last_name') }}">
               </div>

               <div class="form-group">
                  <label for="identification_card">Cédula</label>
                  <input type="text" class="form-control" id="identification_card" name="identification_card"
                     value="{{ old('identification_card') }}">
               </div>

               <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
               </div>

               <div class="form-group">
                  <label for="phone_number">Teléfono</label>
                  <input type="text" class="form-control" id="phone_number" name="phone_number"
                     value="{{ old('phone_number') }}">
               </div>

            </div>

            <input type="hidden" name="action" id="action">
            <input type="hidden" name="hidden_id" id="hidden_id">
            <input type="submit" id="action_button" class="uk-button uk-button-primary uk-width-1-1@m" value="Crear">

         </form>
      </div>
   </div>
</div>

@section('scripts')

<script>
$('#createUser').on('submit', function(e){
e.preventDefault();
$('.uk-modal-title').text("Nuevo Usuario");
$('#action_button').val("Crear");

if($('#action').val() == 'Crear'){

$.ajax({
  method: "POST",
  url: "{{ route('users.store') }}",
  data: new FormData(this),
  dataType: 'json',
  contentType: false,
  cache:false,
  processData: false,
  success: function(data){
   let html = '';
     if(data.errors)
     {
      html =
      `<div class="alert alert-danger" role="alert">
         <ul>`;
         for(var count = 0; count < data.errors.length; count++){
            html += `<li>${data.errors[count]}</li>`;
            } html +=
         `</ul>
      </div>`;
     }

     if(data.success)
     {
      html = `<div class="alert alert-success" role="alert">${data.success}</div>`;
      $('#createUser')[0].reset();
      $('#userList').DataTable().ajax.reload();
     }
     $('#messages_info').html(html);
   }
});

}

if($('#action').val() == 'Editar'){

let userId = $('#hidden_id').val();

$.ajax({
  method: "POST",
  url: `/users/${userId}`,
  data: new FormData(this),
  dataType: 'json',
  contentType: false,
  cache:false,
  processData: false,
  success: function(data){
   let html = '';
     if(data.errors)
     {
      html =
      `<div class="alert alert-danger" role="alert">
         <ul>`;
         for(var count = 0; count < data.errors.length; count++){
            html += `<li>${data.errors[count]}</li>`;
            } html +=
         `</ul>
      </div>`;
     }

     if(data.success)
     {
      html = `<div class="alert alert-success" role="alert">${data.success}</div>`;
      $('#createUser')[0].reset();
      $('#userList').DataTable().ajax.reload();
     }
     $('#messages_info').html(html);
   }
});

}

});

</script>

@endsection