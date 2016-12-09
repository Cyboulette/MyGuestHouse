$('.btnDeleteNews').on('click', function(e) {
	e.preventDefault();
	$("#deleteNews .modal-body").html('<div class="loader"></div><br/><div class="text-center"><em>Chargement en cours</em></div>');
	$('#deleteNews').modal('toggle');
	var idNews = $(this).attr('data-id');
	var dataToPost = 'idNews='+encodeURIComponent(idNews);
	$.ajax({
		type: "POST",
		url: 'index.php?controller=admin&action=deleteNewsForm',
		data: dataToPost,
		dataType: 'json',
		success: function(retour) {
			console.log(retour);
			$("#deleteNews .modal-body").html(retour.message);
		},
		error: function(retour) {
			console.log(retour);
		}
	});
})