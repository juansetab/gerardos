<div class="card">
	<h5 class="card-header">Constancias generadas</h5>
	<div class="card-body">
		<div class="btn-group btn-group-sm mb-2" role="group">
			<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal_insert">Añadir Constancia</button>
			<a class="btn btn-success btn-sm" href="<?= base_url("excel/constanciasAction") ?>">Descargar Excel</a>
		</div>
		<div class="table-responsive text-nowrap">
			<table id='constancias' class='table table-striped table-sm text-center table-bordered text-nowrap'>
				<thead>
					<th class='text-center'>ACCIONES</th>
					<th class='text-center'>INSTRUCTOR</th>
					<th class='text-center'>NOMBRE DEL ALUMNO</th>
					<th class='text-center'>FECHA INICIO</th>
					<th class='text-center'>FECHA FINAL</th>
					<th class='text-center'>FECHA CONSTANCIA</th>
					<th class='text-center'>FOLIO</th>
					<th class='text-center'>CREACIÓN</th>
					<thead>
					<tbody>
						<?php foreach ($constancias as $r) { ?>
							<tr id="tr_<?= $r["id"] ?>" data-id-row="<?= $r["id"] ?>">
								<td>
									<div class="btn-group btn-group-xs" role="group">
										<button type="button" class="btn btn-success btn-xs" onclick="s_CallModalEdit(this)" title="Editar"><i class='bx bx-pencil'></i></button>
										<a class="btn btn-primary btn-xs" href="<?= base_url("constancias/pdf/{$r['qr']}") ?>" title="Constancia" target="_blank"><i class='bx bx-file'></i></a>
										<button type="button" class="btn btn-danger btn-xs" onclick="s_deleteRow()" title="Eliminar"><i class='bx bx-trash'></i></button>
									</div>
								</td>
								<td id="id_instructor"><?= $r["id_instructor"] ?></td>
								<td id="nombre_alumno"><?= $r["nombre_alumno"] ?></td>
								<td id="fecha_inicio"><?= $r["fecha_inicio"] ?></td>
								<td id="fecha_final"><?= $r["fecha_final"] ?></td>
								<td id="fecha"><?= $r["fecha"] ?></td>
								<td id="folio"><?= $r["folio"] ?></td>
								<td id="creacion"><?= $r["creacion"] ?></td>
							</tr>
						<?php } ?>
					</tbody>
			</table>
		</div>
	</div>
</div>
<div>
	<div id="modal_edit" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-dialog modal-xl">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Editar</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class='row'>
						<form id='form_edit' action='<?= base_url('') ?>' method='POST'>
							<div class='row'>
								<input type='hidden' id='id' name='id' placeholder='' />
								<div class='form-group col-md-4 col-sm-12 col-lg-4'>
									<label class='form-label' for='id_instructor'>Instructor: </label>
									<select class='form-control form-control-sm' id='id_instructor' name='id_instructor'>
										<?php foreach ($instructores as $k => $r) { ?>
											<option value="<?= $r["id"] ?>" <?= $k == 0 ? "selected" : "" ?>><?= $r["nombre"] ?></option>
										<?php } ?>
									</select>
								</div>
								<div class='form-group col-md-4 col-sm-12 col-lg-4'>
									<label class='form-label' for='nombre_alumno'>Nombre alumno: </label>
									<input type='text' class='form-control form-control-sm' id='nombre_alumno' name='nombre_alumno' placeholder='' required />
								</div>
								<div class='form-group col-md-4 col-sm-12 col-lg-4'>
									<label class='form-label' for='fecha_inicio'>Fecha inicio: </label>
									<input type='date' class='form-control form-control-sm' id='fecha_inicio' name='fecha_inicio' placeholder='' required />
								</div>
								<div class='form-group col-md-4 col-sm-12 col-lg-4'>
									<label class='form-label' for='fecha_final'>Fecha final: </label>
									<input type='date' class='form-control form-control-sm' id='fecha_final' name='fecha_final' placeholder='' required />
								</div>
								<div class='form-group col-md-4 col-sm-12 col-lg-4'>
									<label class='form-label' for='fecha'>Fecha de constancia: </label>
									<input type='date' class='form-control form-control-sm' id='fecha' name='fecha' placeholder='' required />
								</div>
								<div class='form-group col-md-4 col-sm-12 col-lg-4'>
									<label class='form-label' for='fecha'>Fecha de constancia: </label>
									<input type='text' class='form-control form-control-sm' id='creacion' name='creacion' placeholder='' readonly required />
								</div>
								<div class='form-group col-md-4 col-sm-12 col-lg-4'>
									<label class='form-label' for='folio'>Folio: </label>
									<input type='text' class='form-control form-control-sm' id='folio' name='folio' placeholder='' required />
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
					<button type="button" onclick="s_UpdateRow('constancias/updateConstanciaAction')" class="btn btn-primary">Guardar</button>
				</div>
			</div>
		</div>
	</div>
</div>
<div>
	<div id="modal_insert" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-dialog modal-xl">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Editar</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class='row'>
						<form id='form_insert' action='<?= base_url('') ?>' method='POST'>
							<div class='row'>
								<div class='form-group col-md-4 col-sm-12 col-lg-4'>
									<label class='form-label' for='id_instructor'>Instructor: </label>
									<select class='form-control form-control-sm' id='id_instructor' name='id_instructor'>
										<?php foreach ($instructores as $k => $r) { ?>
											<option value="<?= $r["id"] ?>" <?= $k == 0 ? "selected" : "" ?>><?= $r["nombre"] ?></option>
										<?php } ?>
									</select>
								</div>
								<div class='form-group col-md-4 col-sm-12 col-lg-4'>
									<label class='form-label' for='nombre_alumno'>Nombre alumno: </label>
									<input type='text' class='form-control form-control-sm' id='nombre_alumno' name='nombre_alumno' placeholder='' required />
								</div>
								<div class='form-group col-md-4 col-sm-12 col-lg-4'>
									<label class='form-label' for='fecha_inicio'>Fecha inicio: </label>
									<input type='date' class='form-control form-control-sm' id='fecha_inicio' name='fecha_inicio' placeholder='' required />
								</div>
								<div class='form-group col-md-4 col-sm-12 col-lg-4'>
									<label class='form-label' for='fecha_final'>Fecha final: </label>
									<input type='date' class='form-control form-control-sm' id='fecha_final' name='fecha_final' placeholder='' required />
								</div>
								<div class='form-group col-md-4 col-sm-12 col-lg-4'>
									<label class='form-label' for='fecha'>Fecha de constancia: </label>
									<input type='date' class='form-control form-control-sm' id='fecha' name='fecha' placeholder='' required />
								</div>
								<div class='form-group col-md-4 col-sm-12 col-lg-4'>
									<label class='form-label' for='folio'>Folio: </label>
									<input type='text' class='form-control form-control-sm' id='folio' name='folio' placeholder='' required />
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
					<button type="button" onclick="s_insertRow('constancias/insertConstanciaAction')" class="btn btn-primary">Guardar</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	BASE_URL = "<?= base_url(); ?>";
	window.onload = function(event) {
		DATATABLE = s_Datatable("constancias");

		document.querySelector("#modal_insert #fecha").addEventListener("change", function() {
			obtieneFolio();
		});
	};

	function obtieneFolio() {
		fecha = document.querySelector("#modal_insert #fecha").value;
		if (fecha == "" || typeof fecha === "undefined" || fecha == "000-00-00" || fecha == null) {
			s_SwalFire(
				"error",
				"¡Error!",
				"Fecha no válida"
			);
			return false;
		}
		$.ajax({
			url: "<?=  base_url("constancias/getFolioByYear") ?>",
			data: {
				date: fecha
			},
			type: "POST",
			dataType: "json",
			success: function(response) {
				if (response.status == 1) {
					document.querySelector("#modal_insert #folio").value = response.data.folio;
				} else {
					s_SwalFire("info", "¡Importante!", response.msg);
				}
			},
			error: function(xhr, status) {
				s_SwalFire(
					"error",
					"¡Error!",
					"Existió un problema al procesar la solicitud. " + status + xhr
				);
			},
		});
	}
</script>