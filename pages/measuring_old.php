<?php
/* Generate tracking ID */
$useChars = 'ABCDIFGHIJKLMNOPQRSTUVWXYZ123456789';
$trackingID = $useChars{mt_rand(0,29)};
for($i=1;$i<7;$i++) {
  $trackingID .= $useChars{mt_rand(0,29)};
}

?>

	<div class="container-content container">
		<div class="row">
			<div class="col-12">
				<div class="session">
					<button>Начать сессию</button>
					<button>Завершить сессию</button>
				</div>
				<div class="session_id hidden"></div>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="measuring">

					<form action="">

						<div class="wrap_sku_table_name">

							<div class="sku_name">
								Артикул
							</div>
							<div class="title_name">
								Название
							</div>
							<div class="ean_name">
								EAN
							</div>
							<div class="height_name">
								Высота
							</div>
							<div class="width_name">
								Ширина
							</div>
							<div class="length_name">
								Длина
							</div>
							<div class="volume_name">
								Объем
							</div>
							<div class="weight_name">
								Вес
							</div>

						</div>

						<div class="wrap_sku">

							<div class="sku">
								<label for="sku">Введите артикул товара:</label>
								<input type="text" id="input_sku" name="sku">
								<div class="search_sku hidden"></div>
							</div>
							<div class="title">
								<input type="text" name="title">
							</div>
							<div class="ean">
								<input type="text" name="ean">
							</div>
							<div class="height">
								<input type="text" name="height">
							</div>
							<div class="width">
								<input type="text" name="width">
							</div>
							<div class="length">
								<input type="text" name="length">
							</div>
							<div class="volume">
								<input type="text" name="volume">
							</div>
							<div class="weight">
								<input type="text" name="weight">
							</div>

						</div>

					</form>

				</div>
			</div>
		</div>
	</div>