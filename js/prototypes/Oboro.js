// Global Oboro namespace para PANI
// Isaac
/*jslint browser: true*/
/*global $, jQuery, alert*/
/*jslint vars: true, plusplus: true, devel: true, nomen: true, indent: 4, maxerr: 50*/
/*global define */

var Oboro = {

	SpamCheck: function (ObjectEvent) {
		'use strict';

		var isFirst = ObjectEvent.firstLoad === undefined;
		ObjectEvent.firstLoad = false;

		return isFirst;
	},
	
	GetRank: new Array(20),

	SHOWPROFILE: function (char_id, skill_id, killer_id, option, element_id, force) {
		'use strict';
		if (Oboro.GetRank[element_id] == 0 || Oboro.GetRank[element_id] == null || force == 1)
		{
			$.post((option == 0 ? "modules/rankings/rankings.bg.profile.php" : "modules/rankings/rankings.woe.profile.php") , {
				cid: char_id,
				sid: skill_id,
				tid: killer_id,
				eid: element_id
			}).done(function (r) {
				$("#dinamically_load_ranking_"+element_id).html("").html(r).find(".profile_information_char").fadeIn("slow");
				Oboro.GetRank[element_id] = 1;
			});
		} 
		else if (Oboro.GetRank[element_id] == 1)
		{
			$("#dinamically_load_ranking_"+element_id).fadeOut("slow");
			Oboro.GetRank[element_id] = 2;
		}
		else if (Oboro.GetRank[element_id] == 2)
		{
			$("#dinamically_load_ranking_"+element_id).fadeIn("slow");
			Oboro.GetRank[element_id] = 1;
		}
	},

	//success, info, warning, danger
	alerta: function (type, cabeza, contenido) {
		'use strict';
		$('<div id="hideOboroAlert" class="alert alert-' + type + '"><strong>' + cabeza + '!</strong> ' + contenido + '.</div>').appendTo("body");
	}
};

$(document).on('keyup', function (e) {
	if ( e.which === 27 ) {
		$("#oboro_login_style").slideUp("slow");
	}
});
