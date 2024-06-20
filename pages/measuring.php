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

		<div class="row"> <!-- Ряд таблички замеров -->
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
		</div> <!-- END Ряд таблички замеров -->

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
					<button id="start_measuring">Проверено. Начать измерения</button>
				</div>
			</div>
		</div> <!-- END Кнопка "Проверено. Начать измерения" -->

		<div class="row"> <!-- Ряд таблички замеров-->
			<div class="col-12">
				<div class="header_result_measuring hidden">
					<img src="../images/big_document.svg">
					<p>Здесь мы покажем всю найденную информацию о выбранном артикуле</p>
					<hr>
					<div class="button_save_file">
						<button id="save_file_measuring">Сохранить в файл</button>
					</div>
				</div>
			</div>
			<div class="col-12">
				<div class="up_text hidden">
					<div class="up_text_img">
						<img src="../images/document.svg">
					</div>
					<p>Результаты текущей сессии измерений</p>
				</div>
				<div id="result_measuring" class="hidden"></div>
			</div>
		</div> <!-- END Ряд таблички замеров-->

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