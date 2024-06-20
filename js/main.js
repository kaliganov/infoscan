$(document).ready(function() {
	// Нажатие кнопки "Начать сессию"
	$('.session').on('click', "#start_session_id", function(e){
		e.preventDefault();
		e.stopPropagation();

		$(".session_id").removeClass("hidden").addClass("dib").fadeIn();
		$(".sku_choosing").removeClass("hidden").fadeIn();
		$(".session_start_search_sku_text").removeClass("hidden").fadeIn();
		$(".time_img").removeClass("hidden").fadeIn();
		$(".start_text").fadeOut().addClass("hidden");
		$(".start_img").fadeOut().addClass("hidden");
	});
	// END Нажатие кнопки "Начать сессию"


	// Нажатие кнопки "Прервать сессию"
	$('.session').on('click', "#end_session_id", function(e){
		e.preventDefault();
		e.stopPropagation();

		var result = confirm('Прервать сессию?');
		if (result) {
			location.reload();
		}
	});
	// END Нажатие кнопки "Прервать сессию"


	// Живой поиск SKU в Cards
	$('.measuring').on("keyup", '#input_sku', function () {
		if (this.value.length >= 2) {
			//var login = $(this).attr('data-login');
			$.ajax({
				type: 'post',
				url: "../ajax/sku-cards.php", // Путь к обработчику
				data: {'referal': this.value},
				response: 'text',
				success: function (data) {
					$(".search_sku").html(data).removeClass("hidden").fadeIn(); // Выводим полученые данные в списке
				}
			});
		} else {
			$(".search_sku").html('').fadeOut().addClass("hidden"); // Выводим полученые данные в списке
		}
		$(".sku_info").addClass("hidden");
	});

	$(".measuring .search_sku").hover(function () {
		$("#input_sku").blur(); // Убираем фокус с input
	});

	// При выборе результата поиска, прячем список и заносим выбранный результат в input
	$(".measuring").on("click", ".search_sku li", function () {
		let text = $(this).data();
		text = text.sku;

		//console.log(text);
		//return;

		$(this).closest(".measuring").find('input#input_sku').val(text);
		$(this).closest(".search_sku").fadeOut().addClass("hidden");

		$(".session_start_search_sku_text").fadeOut().addClass("hidden");
		$(".time_img").fadeOut().addClass("hidden");

		$.ajax({
			type: 'post',
			url: "../ajax/sku-cards.php", // Путь к обработчику
			data: {'sku': text},
			response: 'text',
			success: function (data) {
				$(".sku_info").removeClass("hidden").fadeIn();
				$(".text_sku_info").removeClass("hidden").fadeIn();
				$(".wrap_start_measuring").removeClass("hidden").fadeIn();
				$(".wrap_sku_info").html(data);
			}
		});
	}); 
	// END Живой поиск


	// Нажатие кнопки "Проверено, начать измерения"
	$(".wrap_start_measuring").on("click", "#start_measuring", function () {
		let session_id = $('#session_id').html();
		let sku = $('#input_sku').val();
		let buttonNextMeasuring = 0;

		$.ajax({
			type: 'post',
			url: "../ajax/openfile.php", // Путь к обработчику
			data: {'session_id': session_id,'sku': sku},
			response: 'html',
			success: function (data) {
				//console.log(data);
				if (data != 0) {
					buttonNextMeasuring = $('#next_measuring').offset();
					console.log(buttonNextMeasuring);

					if (buttonNextMeasuring.top == 0) {
						buttonNextMeasuring = 800;
						$('html, body').animate({scrollTop: buttonNextMeasuring}, 1300);
					}

					$("#result_measuring").html(data).removeClass("hidden").fadeIn();
					$(".header_result_measuring").removeClass("hidden").fadeIn();
					$(".up_text").removeClass("hidden").fadeIn();
					$(".next_measuring").removeClass("hidden").fadeIn();
					$(".sku_info").addClass("hidden");
					$(".text_sku_info").addClass("hidden");
					$(".wrap_start_measuring").addClass("hidden");
					$("#close_modal_button").click();

					if (buttonNextMeasuring.top != 0) {
						$('html, body').animate({scrollTop: buttonNextMeasuring.top}, 1300);
					}
				}
			}
		});
	});
	// END Нажатие кнопки "Проверено, начать измерения"


	// Нажатие кнопки "Сохранить данные"
	$("#result_measuring").on("click", ".save_sku", function () {

		let sku = $(this);
		let sessionId = $('#session_id').html();
		let sku_number = sku.parent().parent().children('.sku').html();
		let stringObject = sku.parentElement;
		let paletValue = sku.parent().parent().children('.palet_input').find('input').val();
		let masterBoxValue = sku.parent().parent().children('.master_box_input').find('input').val();
		let masterBoxHeightValue = sku.parent().parent().children('.master_box_height_input').find('input').val();
		let masterBoxLengthValue = sku.parent().parent().children('.master_box_length_input').find('input').val();
		let masterBoxWidthValue = sku.parent().parent().children('.master_box_width_input').find('input').val();
		let masterBoxWeightValue = sku.parent().parent().children('.master_box_weight_input').find('input').val();
		
		//console.log(paletValue, masterBoxValue, masterBoxHeightValue, masterBoxLengthValue, masterBoxWidthValue, masterBoxWeightValue);

		$.ajax({
			type: 'post',
			url: "../ajax/save-sku.php", // Путь к обработчику
			data: {'session_id': sessionId,
				'sku': sku_number,
				'palet': paletValue,
				'master_box': masterBoxValue,
				'master_box_height': masterBoxHeightValue,
				'master_box_length': masterBoxLengthValue,
				'master_box_width': masterBoxWidthValue,
				'master_box_weight': masterBoxWeightValue},
			response: 'html',
			success: function (data) {
				console.log(data);
				if (data) {
					$.ajax({
						type: 'post',
						url: "../ajax/draw_table.php", // Путь к обработчику
						data: {'session_id': sessionId,'sku': sku_number},
						response: 'html',
						success: function (data) {
							$("#result_measuring").html(data);
							if (paletValue != 0 && masterBoxValue != 0) {
								$(".zamer_masterboxa").removeClass("hidden").fadeIn();
							}
						}
					});
				}
			}
		});

	});
	// END Нажатие кнопки "Сохранить данные"


	// Нажатие кнопки "Удалить артикул"
	$("#result_measuring").on("click", ".delete_sku", function () {
		let sku = $(this);
		let stringObject = sku.parentElement;
		let sessionId = $('#session_id').html();
		let sku_number = sku.parent().parent().children('.sku').html();

		if (confirm('Удалить товар?')) {
			$.ajax({
				type: 'post',
				url: "../ajax/delete_sku.php", // Путь к обработчику
				data: {'session_id': sessionId,'sku': sku_number},
				response: 'html',
				success: function (data) {
					$.ajax({
						type: 'post',
						url: "../ajax/draw_table.php", // Путь к обработчику
						data: {'session_id': sessionId,'sku': sku_number},
						response: 'html',
						success: function (data) {
							$("#result_measuring").html(data);
						}
					});
				}
			});
		}
	});
	// END Нажатие кнопки "Удалить артикул"


	// Нажатие кнопки "Замер мастербокса"
	$("#result_measuring").on("click", ".zamer_masterboxa", function () {
		let sku = $(this);
		let sessionId = $('#session_id').html();
		let sku_number = sku.parent().parent().children('.sku').html();
		let stringObject = sku.parentElement;
		let paletValue = sku.parent().parent().children('.palet_input').find('input').val();
		let masterBoxValue = sku.parent().parent().children('.master_box_input').find('input').val();
		let masterBoxHeightValue = sku.parent().parent().children('.master_box_height_input').find('input').val();
		let masterBoxLenghtValue = sku.parent().parent().children('.master_box_length_input').find('input').val();
		let masterBoxWidthValue = sku.parent().parent().children('.master_box_width_input').find('input').val();
		let masterBoxWeightValue = sku.parent().parent().children('.master_box_weight_input').find('input').val();
		
		//console.log(paletValue, masterBoxValue, masterBoxHeightValue, masterBoxLenghtValue, masterBoxWidthValue, masterBoxWeightValue);

		$.ajax({
			type: 'post',
			url: "../ajax/openfile-masterbox.php", // Путь к обработчику
			data: {'session_id': sessionId,
				'sku': sku_number,
				'palet': paletValue,
				'master_box': masterBoxValue,
				'master_box_height': masterBoxHeightValue,
				'master_box_lenght': masterBoxLenghtValue,
				'master_box_width': masterBoxWidthValue,
				'master_box_weight': masterBoxWeightValue},
			response: 'html',
			success: function (data) {

				if (data) {
					$.ajax({
						type: 'post',
						url: "../ajax/draw_table.php", // Путь к обработчику
						data: {'session_id': sessionId,'sku': sku_number},
						response: 'html',
						success: function (data) {
							$("#close_modal_button_2").click();
							$("#result_measuring").html(data);
							if (paletValue != 0 && masterBoxValue != 0) {
								$(".zamer_masterboxa").removeClass("hidden").fadeIn();
							}
						}
					});
				}
			}
		});
	});
	// END Нажатие кнопки "Замер мастербокса"


	// Кнопка "Скачасть EXCEL 3 файла"
	$('body').on('click', "#save_file_full_pack", function(e) {

		let sessionId = $('#session_id').html();

		let array_td = [];
		$('#mytable td.sku').each(function(){
			array_td.push($(this).html());
		})
		console.log(array_td);

		let in_data = {"session_id": sessionId, "array_td": array_td};

		// Палет
		$.ajax({
			method: 'POST',
			data: in_data,
			url: '../ajax/create_excel_palet.php',
			response: 'html',
			dataType: 'binary',
			xhrFields: {
				'responseType': 'blob'
			},
			success: function(data, status, xhr) {
				//console.log(data);
				var blob = new Blob([data], {type: xhr.getResponseHeader('Content-Type')});
				var link = document.createElement('a');
				link.href = window.URL.createObjectURL(blob);
				link.download = 'габариты_палет.xlsx';
				link.click();
			}
		});

		// Мастербокс
		$.ajax({
			method: 'POST',
			data: in_data,
			url: '../ajax/create_excel_master_box.php',
			response: 'html',
			dataType: 'binary',
			xhrFields: {
				'responseType': 'blob'
			},
			success: function(data, status, xhr) {
				//console.log(data);
				var blob = new Blob([data], {type: xhr.getResponseHeader('Content-Type')});
				var link = document.createElement('a');
				link.href = window.URL.createObjectURL(blob);
				link.download = 'габариты_мастербокс.xlsx';
				link.click();
			}
		});

		// Индивидуальная упаковка
		$.ajax({
			method: 'POST',
			data: in_data,
			url: '../ajax/create_excel_individual_pack.php',
			response: 'html',
			dataType: 'binary',
			xhrFields: {
				'responseType': 'blob'
			},
			success: function(data, status, xhr) {
				//console.log(data);
				var blob = new Blob([data], {type: xhr.getResponseHeader('Content-Type')});
				var link = document.createElement('a');
				link.href = window.URL.createObjectURL(blob);
				link.download = 'габариты_штуки.xlsx';
				link.click();
			}
		});

	});
	// END Кнопка "Скачасть EXCEL (Индивидуальная упаковка)"


	// Нажатие кнопки "Следующее измерение"
	$(".next_measuring").on("click", "#next_measuring", function () {

		$('.sku_choosing').find('input').val('').focus();
		$('html, body').animate({scrollTop: 0}, 1300);

	});
	// END Нажатие кнопки "Следующее измерение"

}); // END $(document).ready(function() {
		

























/*$(function() {

	//SVG Fallback
	if(!Modernizr.svg) {
		$("img[src*='svg']").attr("src", function() {
			return $(this).attr("src").replace(".svg", ".png");
		});
	};

	//E-mail Ajax Send
	//Documentation & Example: https://github.com/agragregra/uniMail
	$("form").submit(function() { //Change
		var th = $(this);
		$.ajax({
			type: "POST",
			url: "mail.php", //Change
			data: th.serialize()
		}).done(function() {
			alert("Thank you!");
			setTimeout(function() {
				// Done Functions
				th.trigger("reset");
			}, 1000);
		});
		return false;
	});

	//Chrome Smooth Scroll
	try {
		$.browserSelector();
		if($("html").hasClass("chrome")) {
			$.smoothScroll();
		}
	} catch(err) {

	};

	$("img, a").on("dragstart", function(event) { event.preventDefault(); });
	
});

$(window).load(function() {

	$(".loader_inner").fadeOut();
	$(".loader").delay(400).fadeOut("slow");

});*/