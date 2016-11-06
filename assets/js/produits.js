$("#navigationProduits ul li a").on('click', function(e) {
	e.preventDefault();
	var datatri = $(this).parent().attr('data-tri');
	var isActive = $(this).parent().hasClass('active');
	if(datatri != undefined) {
		// Ajax
		if(datatri == "categorie") {
			var categorieID = $(this).parent().attr('data-categorie');
			var data = 'optionTri='+datatri+'&categorieID='+categorieID;
		} else {
			var data = 'optionTri='+datatri;
		}

		$.ajax({
			type: "POST",
			url: "lib/ajax/triProduits.php",
			data: data,
			dataType: 'json',
			success: function(retour) {
				if(isActive != true) {
					$("#navigationProduits .boutonsHaut li[class='active']").removeClass('active');
					if(datatri == "categorie") {
						$("#navigationProduits .boutonsHaut li[data-categorie='"+categorieID+"']").addClass('active');
					} else {
						$("#navigationProduits .boutonsHaut li[data-tri='"+datatri+"']").addClass('active');
					}
				}

				$(".displayProduits").html('<div class="loader"></div>');
				$(".loader").fadeOut("slow", function(){
					if(retour.result == true) {
						$(".displayProduits").html(retour.produits);
						$(".displayProduits").prepend('<div class="container-fluid"><h4>'+retour.title+'</h4></div>');
					} else {
						$(".displayProduits").html('<div class="container-fluid"><div class="alert alert-danger">Aucun produit ne correspond à vos critères de recherche</div></div>');
					}
				});
			},
			error: function(retour) {
				console.log(retour);
			}
		});
	}
});

$("#rechercheForm").on('submit', function(e) {
	e.preventDefault();
	var dataSearch = $(".searchText").val();
	
	if(dataSearch.length > 0) {
		var data = 'optionTri=searchText&text='+encodeURIComponent(dataSearch);
		$.ajax({
			type: "POST",
			url: "lib/ajax/triProduits.php",
			data: data,
			dataType: 'json',
			success: function(retour) {
				$(".displayProduits").html('<div class="loader"></div>');
				$(".loader").fadeOut("slow", function(){
					if(retour.result == true) {
						$(".displayProduits").html(retour.produits);
						$(".displayProduits").prepend('<div class="container-fluid"><h4>'+retour.title+'</h4></div>');
					} else {
						$(".displayProduits").html('<div class="container-fluid"><div class="alert alert-danger">Aucun produit ne correspond à vos critères de recherche</div></div>');
					}
				});
			},
			error: function(retour) {
				console.log(retour);
			}
		});
	}
});