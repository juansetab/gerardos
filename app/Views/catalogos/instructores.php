<div class="card">
	<h5 class="card-header">Instructores de curso</h5>
	<div class="card-body">
		<div class="btn-group btn-group-sm mb-2" role="group">
			<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal_insert">Añadir instructor</button>
		</div>
		<div class="table-responsive text-nowrap">
			<table id='tblInstrucciones' class='table table-striped table-sm text-center table-bordered text-nowrap'>
				<thead>
					<th class='text-center'>ACCIONES</th>
					<th class='text-center'>NOMBRE</th>
					<th class='text-center'>STATUS</th>
					<thead>
					<tbody>
						<?php foreach ($instructores as $r) { ?>
							<tr id="tr_<?= $r["id"] ?>" data-id-row="<?= $r["id"] ?>">
								<td>
									<div class="btn-group btn-group-xs" role="group">
										<button type="button" class="btn btn-success btn-xs" onclick="s_CallModalEdit(this)" title="Editar"><i class='bx bx-pencil'></i></button>
									</div>
								</td>
								<td id="nombre"><?= $r["nombre"] ?></td>
								<td id="status"><?= $r["status"] == 1 ? "Activo" : "Inactivo" ?></td>
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
									<label class='form-label' for='nombre'>Nombre: </label>
									<input type='text' class='form-control form-control-sm' id='nombre' name='nombre' placeholder='' required />
								</div>
								<div class='form-group col-md-4 col-sm-12 col-lg-4'>
									<label class='form-label' for='status'>Status: </label>
									<select class='form-control form-control-sm' id='status' name='status'>
										<option value='1'>Activo</option>
										<option value='0'>Inactivo</option>
									</select>
								</div>

							</div>
						</form>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
					<button type="button" onclick="s_UpdateRow('catalogos/updateInstructorAction')" class="btn btn-primary">Guardar</button>
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
									<label class='form-label' for='nombre'>Nombre: </label>
									<input type='text' class='form-control form-control-sm' id='nombre' name='nombre' placeholder='' required />
								</div>
								<div class='form-group col-md-4 col-sm-12 col-lg-4'>
									<label class='form-label' for='status'>Status: </label>
									<select class='form-control form-control-sm' id='status' name='status'>
										<option value='1'>Activo</option>
										<option value='0'>Inactivo</option>
									</select>
								</div>

							</div>
						</form>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
					<button type="button" onclick="s_insertRow('catalogos/insertInstructorAction ')" class="btn btn-primary">Guardar</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	BASE_URL = "<?= base_url() ?>";
	window.onload = function(event) {
		DATATABLE = s_Datatable("tblInstrucciones");

	};
</script>