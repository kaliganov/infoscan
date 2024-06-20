<?php
/* Generate tracking ID */
$useChars = 'ABCDIFGHIJKLMNOPQRSTUVWXYZ123456789';
$trackingID = $useChars{mt_rand(0,29)};
for($i=1;$i<7;$i++) {
	$trackingID .= $useChars{mt_rand(0,29)};
}

?>

	<div class="container-content container">

		<div class="row"> <!-- Ряд сессии -->
			<div class="col-4">
				<div class="session">
					<button id="start_session_id">Начать сессию</button>
				</div>
			</div>
			<div class="col-5">
				<div class="session">
					<div class="session_id hidden">
						<div class="icon_img">
							<img src="../images/document.svg">
						</div>
						<div class="session_text">Номер сессии: </div>
						<div id="session_id"><?php echo $trackingID; ?></div>
					</div>
				</div>
			</div>
			<div class="col-3">
				<div class="session">
					<button id="end_session_id">Прервать сессию</button>
				</div>
			</div>
		</div> <!-- END Ряд сессии -->

		<div class="row"> <!-- Ряд текста и картинки при загрузке -->
			<div class="col-12">
				<div class="start_text">
					<p>Нажмите “Начать сессию” для начала работы</p>
				</div>
				<div class="start_img">
					<img src="../images/open-box.svg">
				</div>
			</div>
		</div> <!-- END Ряд текста и картинки при загрузке -->

		<div class="row"> <!-- Ряд поиска товара по артикулу -->
			<div class="col-12">
				<div class="measuring">

					<div class="row">
						<div class="col-4"></div>
						<div class="col-4">
							<div class="sku_choosing hidden">
								<div class="sku_input">
									<input type="text" id="input_sku" name="sku">
									<div class="search_sku hidden"></div>
								</div>
							</div>
						</div>
						<div class="col-4"></div>
					</div>

				</div>
			</div>
		</div> <!-- END Ряд поиска товара по артикулу -->

		<div class="row"> <!-- Ряд всплывашки проверки введеного артикула -->
			<div class="col-12">
				<div class="row">
					<div class="col-2"></div>
					<div class="col-8">
						<div class="text_sku_info hidden">
						Проверьте товар ещё раз
					</div>
					</div>
					<div class="col-2"></div>
				</div>
			</div>
			<div class="col-12">
				<div class="sku_info hidden">
					<div class="wrap_sku_info">

					</div>
				</div>
			</div>
		</div> <!-- END Ряд всплывашки проверки введеного артикула -->

		<div class="row"> <!-- Кнопка "Проверено. Начать измерения" -->
			<div class="col-12">
				<div class="wrap_start_measuring hidden">
					<button id="start_measuring" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#startMeasuring">Проверено. Начать измерения</button>
				</div>
			</div>
		</div> <!-- END Кнопка "Проверено. Начать измерения" -->

		<div class="row"> <!-- Ряд таблички замеров -->
			<div class="header_result_measuring hidden">
				<img src="../images/big_document.svg">
				<p>Здесь мы покажем всю найденную информацию о выбранном артикуле</p>
				<hr>
				<div class="button_container">
					<div class="button_save_file_full_pack">
						<button id="save_file_full_pack">Скачать EXCEL (3 файла)</button>
					</div>
				</div>
			</div>
			<div class="up_text hidden">
				<div class="up_text_img">
					<img src="../images/document.svg">
				</div>
				<p>Результаты текущей сессии измерений</p>
			</div>
			<div id="result_measuring" class="hidden"></div>
			<div class="next_measuring hidden">
				<button id="next_measuring">Следующее измерение</button>
			</div>
		</div> <!-- END Ряд таблички замеров -->

		<div class="row"> <!-- Ряд текста и картинки после нажатия кнопки "Начать сессию" -->
			<div class="col-12">
				<div class="session_start_search_sku_text hidden">
					<p>Самое время ввести первый артикул для измерения</p>
				</div>
				<div class="time_img hidden">
					<img src="../images/time.svg">
				</div>
			</div>
		</div>

	</div> <!-- END container-content container -->

	<div class="modal fade" id="startMeasuring" tabindex="-1" aria-labelledby="startMeasuringLabel" style="display: none;" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<img src="../images/hello.svg">
					<h5 class="modal-title">СЛЕДУЙТЕ ИНСТРУКЦИИ</h5>
					<button id="close_modal_button" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<ul class="instruction_list">
						<li>Поставьте товар (упаковку) на прибор</li>
						<li>Выставите ограничители габаритов</li>
						<li>Отсканируйте Штрих-код</li>
						<li>Далее прибор проведет измерения</li>
						<li>На экране прибора на зеленом фоне будет написано: "EAN - Успешно записан"</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="startMeasuringMasterBox" tabindex="-1" aria-labelledby="startMeasuringLabel" style="display: none;" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<img src="../images/hello.svg">
					<h5 class="modal-title">СЛЕДУЙТЕ ИНСТРУКЦИИ</h5>
					<button id="close_modal_button_2" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<ul class="instruction_list">
						<li>Поставьте мастербокс на прибор</li>
						<li>Выставите ограничители габаритов</li>
						<li>Отсканируйте Штрих-код</li>
						<li>Далее прибор проведет измерения</li>
						<li>На экране прибора на зеленом фоне будет написано: "EAN - Успешно записан"</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="saveData" tabindex="-1" aria-labelledby="startMeasuringLabel" style="display: none;" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<img src="../images/hello.svg">
					<h5 class="modal-title">Обновление данных</h5>
					<button id="close_modal_button_2" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<p>Данные успешно обновлены</p>
				</div>
			</div>
		</div>
	</div>
