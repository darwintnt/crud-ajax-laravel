// PERMITE LA ELIMINACIÓN DE REGISTROS EN TODAS LAS TABLAS INDEX DE LA APLICACIÓN
$(document).on("click", ".btn-delete-index", deleteItemIndex);

function deleteItemIndex(e) {

	e.preventDefault();
	let url = $(this).data("url");
	let param = {
		method: 'DELETE',
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	};

	// MENSAJE DE CONFIRMACIÓN
	swal({
			title: "Esta Seguro?",
			text: "Esta operación es irreversible, desea continuar?",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		})
		.then((willDelete) => {
			if (willDelete) {
				fetch(url, param)
					.then((res) => {
						return res.json();
					})
					.then((data) => {
						swal(data.message, {
							icon: data.icon,
						});
						setTimeout(() => {
							$(data.listId).DataTable().ajax.reload();
						}, 1000);
					})
					.catch(function (error) {
						console.error(error);
					});
			}
		});
}