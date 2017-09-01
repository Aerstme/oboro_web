	// ------------------------------
	// Isaac - OBORO CONTROL PANEL
	/*jslint browser: true*/
	/*global $, jQuery, alert*/
	/*jslint vars: true, plusplus: true, devel: true, nomen: true, indent: 4, maxerr: 50*/
	/*global define */

	if (typeof jQuery === 'undefined') {
		throw new Error('init.js requires jQuery');
	}

	var Oboro = Oboro || {};


	(function ($) {
		'use strict';

		$(window).on("resize", function (e) {
			if (!Oboro.SpamCheck(e)) {
				return false;
			}
			console.log("window width: " + window.innerWidth);
		});

		$('.selectpicker').selectpicker({});

		$('.server_info > ul.nav > li > a').on('click', function () {
			$('.server_info > ul.nav').find('.active').removeClass('active');
			$(this).parent().addClass('active');
			var id = $(this).attr('data-roll');
			$('.tab-content').find('.active').fadeOut("slow", function () {
				$(this).removeClass('active').css('opacity', '0');
				$('#' + id).fadeIn("slow", function () {
					$(this).addClass('active').css('opacity', '1');
				});
			});
		});

		$("html").niceScroll({
			cursorwidth: "2px",
			cursorcolor: "rgb(185, 179, 179)",
			cursorborder: "rgb(185, 179, 179)",
			cursorborderradius: "4px",
			zindex: 150,
			scrollspeed: 50,
			spacebarenabled: false,
			enablemousewheel: true,
			bouncescroll: true,
			autohidemode: true
		});

		$(".tab-content").niceScroll({
			cursorwidth: "2px",
			cursorcolor: "rgb(185, 179, 179)",
			cursorborder: "rgb(185, 179, 179)",
			cursorborderradius: "4px",
			zindex: 150,
			scrollspeed: 50,
			spacebarenabled: false,
			enablemousewheel: true,
			bouncescroll: true,
			autohidemode: true
		});

		$('#OboroDT, #OboroDT2').DataTable({
			responsive: true,
			bFilter: true,
			bInfo: true,
			bPaginate: true
		});

		$('#OboroDT3').DataTable({
			responsive: true,
			bFilter: true,
			bInfo: false,
			bPaginate: true,
			lengthMenu: [4, 6, 8, 10, 15, 20]
		});	


		$('#OboroDT_LARGE').DataTable({
			responsive: true,
			bFilter: true,
			bInfo: true,
			bPaginate: true,
			Processing: true,
			bSortClasses: false,
			ajax: "libs/ajax/datatables.ajax.itemdb.php",
		});

		$('[id="OBORO_NORMALIZED"]').on('submit', function (e) {
			e.preventDefault();
			$(".loader").fadeIn("slow");
			var opt = $(this).find('select[name="opt"]').val() || $(this).find('input[name="opt"]').val() || false,
				rank = $(this).find('input[name="rank"]').val() || false,
				order = $(this).find('select[name="order"]').val() || false,
				search = $(this).find('input[name="buscar"]').val() || false,
				name_pick = $(this).find('input[name="name"]').val() || 0,
				acc_id = $(this).find('input[name="account_id"]').val() || 0,
				item_id = $(this).find('input[name="item_id"]').val() || 0,
				map = $(this).find('input[name="map"]').val() || 0,
				string	= "?" + rank;

				if (opt)
					string += "-" + opt;
				if (order)
					string += "-" + order;
				if (search)
					string += "-" + search;
			
				if (opt == 001)
					string += "-" + name_pick + "-" + acc_id + "-" + item_id + "-" + map;
				

				window.location.href = string;
		});

		var AlertBox = function(contenido) {
			$.confirm({
				title: 'Encountered an error!',
				closeIcon: true,
				closeIconClass: 'fa fa-close',
				backgroundDismiss: true,
				content: contenido,
				autoClose: 'close|5000',
				type: 'red',
				typeAnimated: true,
				buttons: {
					close: function () {
						text: 'Ok'
					}
				}
			});
		};

		$('.OBOROBACKWORK').on('submit', function (e) {
			e.preventDefault();
			$(".loader").fadeIn("slow");

			var that = this;
			$.post("libs/ajax/functions.php", $(that).serialize(), function (r) {
				switch ($(that).find('input[name="OPT"]').val()) 
				{
					case 'LOGIN':
						if ($.trim(r) !== "ok")
							AlertBox(r);
						else
							window.location.href = "?";
					break;

					case 'REGISTRO':
						if ($.trim(r) !== "ok")
							$('.error_log').css('background', '#ffacac').html(r + "<br/><b>Note</b> Please click the submit(blue) button to update error list");
						else 
						{
							Oboro.alerta("success", "&Eacute;xito", "Account has been created");
							window.location.href = "index.php";
						}
					break;

					case 'ACCOUNTPANEL':
						switch($.trim(r)) 
						{
							case 'okdeslog':
								Oboro.alerta("success", "&Eacute;xito", "Please log in again to finish");
								window.location.href = "index.php?session_destroy=true";
							break;

							case 'ok':
								Oboro.alerta("success", "&Eacute;xito", "Your account has been update");
							break;

							default:
								AlertBox(r);
							break;
						}
					break;

					case 'CHARPANEL':
						if ($.trim(r) === "ok") 
						{
							Oboro.alerta("success", "&Eacute;xito", "Your account has been updated");
							window.location.href = "index.php?account.info";
						} 
						else
							AlertBox(r);
					break;
					case 'RECOVERPASS':
						if ($.trim(r) === "ok") 
							Oboro.alerta("success", "&Eacute;xito", "Please check your email for the new login");
						else
							AlertBox(r);
					break;

					case 'CONVERT_ITEM_DB':
						if ($.trim(r.split("@")[0]) === "error") 
						{
							Oboro.alerta("success", "&Eacute;xito", "Your Item_DB.SQL Has been succesfully Created, starting your download soon...");
							setTimeout(function () {
								window.location.href = r.split("@")[1];
							}, 1000);
						} else
							AlertBox(r);
					break;

					case 'LOGIN_WITH_GEO':
						if ($.trim(r) === "ok") 
						{
							Oboro.alerta("success", "&Eacute;xito", "Welcomeback");
							window.location.href = "index.php";
						} else
							AlertBox(r);
					break;

					case 'UPDATE_GEO_INFO':
						if ($.trim(r) === "ok") {
							Oboro.alerta("success", "&Eacute;xito", "Geo-Localization Information Updated succesfully");
						} else 
							AlertBox(r);
					break;

					case 'CREATE_DONATION_ITEM':
						if ($.trim(r) === "ok") 
						{
							Oboro.alerta("success", "&Eacute;xito", "New donation item created");
							window.location.href = "?admin.donationshop";
						} 
						else 
							AlertBox(r);
					break;

					case 'DELETE_DONATION_ITEM':
						if ($.trim(r) === "ok") 
						{
							Oboro.alerta("success", "&Eacute;xito", "Donation Item has been deleted from donation shop");
							window.location.href = "?admin.donationshop";
						} else
							AlertBox(r);
					break;
				}
			});
			$(".loader").fadeOut("slow");
		});

		$('.dona-box-on-buy').on('submit', function (e) {
			e.preventDefault();
			$(".loader").fadeIn("slow");

			var item_temp = $(this).attr('data-dona-id');
			var that = this;
			if ($(this).find("input[name='confirma-compra']").prop('checked') == false)
				AlertBox("You must have to confirm the checkbox");
			else 
			{
				$(this).find("input[name='sub']").val("").val("Processing.");

				$.post("libs/ajax/donationshop.validator.php", {
					item_id: item_temp
				}, function (r) {
					if ($.trim(r) === "ok") 
					{
						$.confirm({
							title: 'Congratulations!',
							closeIcon: true,
							closeIconClass: 'fa fa-close',
							backgroundDismiss: true,
							content: "item has been successfully added to your inventory",
							autoClose: 'close|5000',
							type: 'green',
							typeAnimated: true,
							buttons: {
								close: function () {
									text: 'Ok'
								}
							},
							onClose: function () {
								$(that).find("input[name='sub']").val("").val("Buy Again");
								$("#get-donation-points").text(+($("#get-donation-points").text().replace('.','').replace('£',''))-($(that).parent().parent().find(".donation_value").text().split(",")[0].replace('.','').replace('£','')));
							},
						});
					} 
					else
					{
						$(that).find("input[name='sub']").val("").val("Can't Buy").prop('disabled', true);
						AlertBox(r);
					}
				}).fail(function (jqXHR, textStatus, errorThrown) {
					alert(errorThrown);
				});;
			}
			$(".loader").fadeOut("slow");
		});

		$('.btn-cierra').on('click', function () {
			if ($(this).parent().parent().parent().find('.panel-body').css('display') !== 'none')
				$(this).parent().parent().parent().find('.panel-body').slideUp("slow");
			else
				$(this).parent().parent().parent().find('.panel-body').slideDown("slow");
		});

		$("#ShowLoginForm").on('click', function () {
			$("#oboro_login_style").slideDown("slow");
		});

		$('[id^="fileInput"').on('change', function () {
			var input = $(this);
			$(this).closest('label').find('span').html(input.val().replace(/\\/g, '/').replace(/.*\//, ''));
		});

		$('[id^="get_btn_donation_"]').on('click', function (e) {
			e.preventDefault();
			var row = $(this).closest('tr').attr('id'),
				name = $('#' + row).find('input[name="name"]').val(),
				description = $('#' + row).find('textarea[name="description"]').val(),
				donation = $('#' + row).find('input[name="dona"]').val(),
				item_id = $('#' + row).attr('id').split('get_row_donation_')[1];
			$.post("libs/ajax/functions.php", {
				name: name,
				desc: description,
				dona: donation,
				item_id: item_id,
				OPT: 'DonationAdminUpdate'
			}, function (r) {
				if ($.trim(r) === "ok") 
				{
					var file = $('#' + row).find('#fileInput')[0].files[0];
					if (file) {
						var formData = new FormData();
						formData.append('image', $('#' + row).find('#fileInput')[0].files[0]);
						formData.append('OPT', 'DonationAdminUpdateImg');
						$.ajax({
							url: "libs/ajax/functions.php",
							type: "POST",
							data: formData,
							contentType: false,
							cache: false,
							processData: false,
							success: function (data) {
								if ($.trim(data) === 'ok') {
									Oboro.alerta("success", "&Eacute;xito", "Item updated succesfully");
									window.location.href = "index.php?admin.donationshop";
								} else
									AlertBox(data);
							}
						});
					} else
						Oboro.alerta("success", "&Eacute;xito", "Item updated succesfully");
				} else {
					AlertBox(r);
				}
			});
		});
	}(jQuery));