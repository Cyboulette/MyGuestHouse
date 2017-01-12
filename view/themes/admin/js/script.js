// Script pour datepicker
$( function() {
	if(date != null) {
		$('#datepickerDebut, #datepickerFin').datepicker({
			language: "fr",
			format: "dd/mm/yyyy",
			datesDisabled: date
		});
	}
});

function GetQueryStringParams(sParam)
{
	var sPageURL = window.location.search.substring(1);
	var sURLVariables = sPageURL.split('&');
	for (var i = 0; i < sURLVariables.length; i++)
	{
		var sParameterName = sURLVariables[i].split('=');
		if (sParameterName[0] == sParam)
		{
			return sParameterName[1];
		}
	}
}

//Script générique pour la suppression
$('.btnDelete').on('click', function(e) {
	e.preventDefault();
	$("#deleteItem .modal-body").html('<div class="loader"></div><br/><div class="text-center"><em>Chargement en cours</em></div>');
	$("#deleteItem").modal('toggle');
	var urlAction = $(this).attr('data-url');
	var idToDelete = $(this).attr('data-id');
	var dataToPost = 'idToDelete='+encodeURIComponent(idToDelete);
	var currentMode = GetQueryStringParams('mode');
	if(currentMode != null) {
		urlAction += '&mode='+currentMode;
	}
	console.log(urlAction);
	$.ajax({
		type: "POST",
		url: 'index.php?controller='+urlAction+'&action=preDeleteItem',
		data: dataToPost,
		dataType: 'json',
		success : function(retour) {
			console.log(retour);
			$("#deleteItem .modal-body").html(retour.message);
		},
		error: function(retour) {
			console.log(retour);
		}
	});
});

$('.btnSelectTheme').on('click', function(e) {
	e.preventDefault();
	$("#selectTheme .modal-body").html('<div class="loader"></div><br/><div class="text-center"><em>Chargement en cours</em></div>');
	$('#selectTheme').modal('toggle');
	var nameTheme = $(this).attr('data-name');
	var dataToPost = 'nameTheme='+encodeURIComponent(nameTheme);
	$.ajax({
		type: "POST",
		url: 'index.php?controller=adminThemes&action=changeThemeForm',
		data: dataToPost,
		dataType: 'json',
		success: function(retour) {
			console.log(retour);
			$("#selectTheme .modal-body").html(retour.message);
		},
		error: function(retour) {
			console.log(retour);
		}
	});
});

$('#cpMainColor').colorpicker({
	format: "hex"
});

$("#slideToUpload").fileinput({
	'showUpload': false,
	'allowedFileExtensions': ['png', 'jpg', 'jpeg', 'gif'],
	'allowedFileTypes': ['image'],
	'showPreview': true,
	'language': 'fr',
	layoutTemplates: {
		main1: "{preview}\n" +
		"<div class=\'input-group {class}\'>\n" +
		"   <div class=\'input-group-btn\'>\n" +
		"       {browse}\n" +
		"       {upload}\n" +
		"       {remove}\n" +
		"   </div>\n" +
		"   {caption}\n" +
		"</div>"
	}
});



function detectIdResa() {
	var hash = window.location.hash;
	if(hash !== "") {
		var idResaToShow = hash.replace("#selectResa=", "");
		idResaToShow = parseInt(idResaToShow);
		if(!isNaN(idResaToShow)) {
			var table = $('.tableCenter > tbody > tr');
			table.each(function() {
				var td = $(this).find('td');
				var nbTd = 0;
				td.each(function() {
					if(nbTd < 1) {
						var idTable = parseInt($(this).html());
						if(idResaToShow == idTable) {
							$(this).parent().addClass("found");
						} else {
							$(this).parent().removeClass("found");
						}
						nbTd++;
					}
				})
			});
		}
	}
}

$(window).on('hashchange', function() {
	detectIdResa();
});

detectIdResa();

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



