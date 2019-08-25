$(document).ready(function () {
    const activeUsers = {
        id: '#userList',
        url: '/api/users',
        'columns': [{
                data: 'id'
            },
            {
                data: 'name'
            },
            {
                data: 'last_name'
            },
            {
                data: null,
                render: function (data) {
                    let edit_btn = `
                  <a href="#" class="edit-user" uk-toggle="target: #my-id">
                     <i class="edit-icon fas fa-edit fa-lg fa-fw" data-attr="${data.edit_url}"></i>
                  </a>
                  `;
                    let delete_btn = `
                  <i class="delete-icon btn-delete-index fas fa-trash fa-lg fa-fw"
							data-url="${data.delete_url}">
						</i>
                  `;
                    return edit_btn + delete_btn;
                }
            }
        ],
        columnDefs: [{
                targets: 3,
                orderable: false,
                searchable: false
            },
            {
                targets: '_all',
                searchable: true,
                orderable: true
            }
        ]
    };

    indexListSection(activeUsers);
});

function indexListSection(props) {

    $(`${props.id}`).DataTable({
        serverSide: true,
        responsive: true,
        ajax: props.url,
        columns: props.columns,
        columnDefs: props.columnDefs
    });

    $(`${props.id}`).removeClass("dataTable no-footer");
}

$('#addUser').click(function () {
    $('.uk-modal-title').text("Nuevo Usuario");
    $('#action_button').val("Crear");
    $('#action').val("Crear");
    $("#putMethod").remove();
});

$('#userList').on('click', '.edit-user', function (e) {
    let id = e.target.dataset.attr;
    $('#messages_info').html('');
    $.ajax({
        url: `/users/${id}/edit`,
        method: 'GET',
        dataType: "json",
        success: function (html) {
            $('#name').val(html.data.name);
            $('#last_name').val(html.data.last_name);
            $('#identification_card').val(html.data.identification_card);
            $('#email').val(html.data.email);
            $('#phone_number').val(html.data.phone_number);
            $('#hidden_id').val(html.data.id);
            $('.uk-modal-title').text("Editar Usuario");
            $('#action_button').val("Editar");
            $('#action').val("Editar");
            $("#createUser").append(`<input name="_method" type="hidden" value="PUT" id="putMethod">`);
        }
    })
});

$("#email").blur(function(){
   let email_data = $("#email").val();
   $.ajax({
       url: `/api/emailExist/${email_data}`,
       type: 'GET',
       data:{
           'data':email_data
       },
       success: function(data){
           // DONDE SE MOSTRARA EL MENSAJE
           if(data.errors)
           {
            html =
            `<div class="alert alert-danger" role="alert">
               <ul>
                  <li>${data.errors}</li>
               </ul>
            </div>`;
            $('#messages_info').html(html);
           } else {
            $('#messages_info').html('');
           }
       }
   });
});