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

$('.btnDeleteReservation').on('click', function(e) {
	e.preventDefault();
	$("#deleteReservation .modal-body").html('<div class="loader"></div><br/><div class="text-center"><em>Chargement en cours</em></div>');
	$('#deleteReservation').modal('toggle');
	var idReservation = $(this).attr('data-id');
	var dataToPost = 'idReservation='+encodeURIComponent(idReservation);
	$.ajax({
		type: "POST",
		url: 'index.php?controller=admin&action=deleteReservationForm',
		data: dataToPost,
		dataType: 'json',
		success: function(retour) {
			console.log(retour);
			$("#deleteReservation .modal-body").html(retour.message);
		},
		error: function(retour) {
			console.log(retour);
		}
	});
})

$('#cpMainColor').colorpicker({
	format: "hex"
});

function insertTag(startTag, endTag, textareaId, tagType) {
	var field = document.getElementById(textareaId);
	var scroll = field.scrollTop;
	field.focus();
	
	
	if (window.ActiveXObject) {
		var textRange = document.selection.createRange();            
		var currentSelection = textRange.text;
	} else {
		var startSelection   = field.value.substring(0, field.selectionStart);
		var currentSelection = field.value.substring(field.selectionStart, field.selectionEnd);
		var endSelection     = field.value.substring(field.selectionEnd);
	}

	if (tagType) {
		switch (tagType) {
			case "lien":
				endTag = "[/lien]";
				if (currentSelection) {
					if (currentSelection.indexOf("http://") == 0 || currentSelection.indexOf("https://") == 0 || currentSelection.indexOf("ftp://") == 0 || currentSelection.indexOf("www.") == 0) {
							var label = prompt("Quel est le libellé du lien ?") || "";
							startTag = "[lien url=" + currentSelection + "]";
							currentSelection = label;
					} else {
							var URL = prompt("Quelle est l'url ?");
							startTag = "[lien url=" + URL + "]";
					}
				} else {
					var URL = prompt("Quelle est l'url ?") || "";
					var label = prompt("Quel est le libellé du lien ?") || "";
					startTag = "[lien url=" + URL + "]";
					currentSelection = label;
				}
			break;
			case "liste":
				endTag = "[/liste]";
				var titreListe = prompt("Quel est le titre de cette liste ?") || "";
				var elements = "";

				while(element = prompt("Quel élément à ajouter à cette liste ? (Appuyez sur annuler pour arrêter)")) {
					if(element !== null) {
						elements += "[li]"+element+"[/li]";
					} else {
						break;
					}
				}
				startTag = "[liste titre="+titreListe+"]";
				currentSelection = elements;
			break;
		}
	}

	if (window.ActiveXObject) {
		textRange.text = startTag + currentSelection + endTag;
		textRange.moveStart('character', -endTag.length-currentSelection.length);
		textRange.moveEnd('character', -endTag.length);
		textRange.select();  
	} else { // Ce n'est pas IE
		field.value = startSelection + startTag + currentSelection + endTag + endSelection;
		field.focus();
		field.setSelectionRange(startSelection.length + startTag.length, startSelection.length + startTag.length + currentSelection.length);
	}  
	
	field.scrollTop = scroll;   
}