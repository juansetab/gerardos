<div class="card">
	<h5 class="card-header">Usuarios del sistema</h5>
	<div class="card-body">
		<div class="btn-group btn-group-sm" role="group">
			<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal_insert">Añadir usuario</button>
		</div>
		<div class="table-responsive text-nowrap">
			<table id='main_table' class='table table-striped table-sm text-center text-nowrap'>
				<thead>
					<th class='text-center'>ACCIONES</th>
					<th class='text-center'>ROL</th>
					<th class='text-center'>USUARIO</th>
					<th class='text-center'>NOMBRE</th>
					<th class='text-center'>PRIMER APELLIDO</th>
					<th class='text-center'>SEGUNDO APELLIDO</th>
					<th class='text-center'>CORREO ELECTRÓNICO</th>
					<th class='text-center'>TELÉFONO</th>
					<th class='text-center'>STATUS</th>
					<th class='text-center'>CREACIÓN</th>
					<thead>
					<tbody>
						<?php foreach ($usuarios as $r) { ?>
							<tr id="tr_<?= $r["id"] ?>" data-id-row="<?= $r["id"] ?>">
								<td>
									<div class="btn-group btn-group-xs" role="group">
										<button type="button" class="btn btn-success btn-sm" onclick="s_CallModalEdit(this)">Editar</button>
										<button type="button" class="btn btn-danger btn-sm" onclick="s_CallModalEdit(this)">Password</button>
									</div>
								</td>
								<td id="rol"><?= $r["rol"] ?></td>
								<td id="username"><?= $r["username"] ?></td>
								<td id="name"><?= $r["name"] ?></td>
								<td id="first_lastname"><?= $r["first_lastname"] ?></td>
								<td id="second_lastname"><?= $r["second_lastname"] ?></td>
								<td id="email"><?= $r["email"] ?></td>
								<td id="phone"><?= $r["phone"] ?></td>
								<td id="status"><?= $r["status"] == 1 ? "Activo" : "Inactivo" ?></td>
								<td id="creation"><?= $r["creation"] ?></td>
							</tr>
						<?php } ?>
					</tbody>
			</table>
		</div>
	</div>
</div>
<div>
	<div id="modal_edit" class="modal" tabindex="-1">
		<div class="modal-dialog modal-dialog modal-xl">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Editar</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class='row'>
						<form id='form_edit' action='<?= base_url('') ?>' method='POST'>
							<div class='row'><input type='hidden' id='id' name='id' placeholder='' />
								<div class='form-group col-md-4 col-sm-12 col-lg-4'>
									<label class='form-label' for='id_instructor'>Id_instructor: </label>
									<input type='number' class='form-control form-control-sm' id='id_instructor' name='id_instructor' placeholder='' required />
								</div>
								<div class='form-group col-md-4 col-sm-12 col-lg-4'>
									<label class='form-label' for='folio'>Folio: </label>
									<input type='number' class='form-control form-control-sm' id='folio' name='folio' placeholder='' required />
								</div>
								<div class='form-group col-md-4 col-sm-12 col-lg-4'>
									<label class='form-label' for='nombre_alumno'>Nombre_alumno: </label>
									<input type='text' class='form-control form-control-sm' id='nombre_alumno' name='nombre_alumno' placeholder='' required />
								</div>
								<div class='form-group col-md-4 col-sm-12 col-lg-4'>
									<label class='form-label' for='fecha_inicio'>Fecha_inicio: </label>
									<input type='text' class='form-control form-control-sm' id='fecha_inicio' name='fecha_inicio' placeholder='' required />
								</div>
								<div class='form-group col-md-4 col-sm-12 col-lg-4'>
									<label class='form-label' for='fecha_final'>Fecha_final: </label>
									<input type='text' class='form-control form-control-sm' id='fecha_final' name='fecha_final' placeholder='' required />
								</div>
								<div class='form-group col-md-4 col-sm-12 col-lg-4'>
									<label class='form-label' for='fecha'>Fecha: </label>
									<input type='text' class='form-control form-control-sm' id='fecha' name='fecha' placeholder='' required />
								</div>
								<div class='form-group col-md-4 col-sm-12 col-lg-4'>
									<label class='form-label' for='status'>Status: </label>
									<select class='form-control form-control-sm' id='status' name='status'>
										<option value='1'>Activo</option>
										<option value='0'>Inactivo</option>
									</select>
								</div>

								<div class='form-group col-md-4 col-sm-12 col-lg-4'>
									<label class='form-label' for='creacion'>Creacion: </label>
									<input type='text' class='form-control form-control-sm' id='creacion' name='creacion' placeholder='' required />
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
					<button type="button" onclick="s_UpdateRow('constancias/')" class="btn btn-primary">Save changes</button>
				</div>
			</div>
		</div>
	</div>
</div>
<div>
	<div id="modal_insert" class="modal" tabindex="-1">
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
									<label class='form-label' for='id_instructor'>Id_instructor: </label>
									<input type='number' class='form-control form-control-sm' id='id_instructor' name='id_instructor' placeholder='' required />
								</div>
								<div class='form-group col-md-4 col-sm-12 col-lg-4'>
									<label class='form-label' for='folio'>Folio: </label>
									<input type='number' class='form-control form-control-sm' id='folio' name='folio' placeholder='' required />
								</div>
								<div class='form-group col-md-4 col-sm-12 col-lg-4'>
									<label class='form-label' for='nombre_alumno'>Nombre_alumno: </label>
									<input type='text' class='form-control form-control-sm' id='nombre_alumno' name='nombre_alumno' placeholder='' required />
								</div>
								<div class='form-group col-md-4 col-sm-12 col-lg-4'>
									<label class='form-label' for='fecha_inicio'>Fecha_inicio: </label>
									<input type='text' class='form-control form-control-sm' id='fecha_inicio' name='fecha_inicio' placeholder='' required />
								</div>
								<div class='form-group col-md-4 col-sm-12 col-lg-4'>
									<label class='form-label' for='fecha_final'>Fecha_final: </label>
									<input type='text' class='form-control form-control-sm' id='fecha_final' name='fecha_final' placeholder='' required />
								</div>
								<div class='form-group col-md-4 col-sm-12 col-lg-4'>
									<label class='form-label' for='fecha'>Fecha: </label>
									<input type='text' class='form-control form-control-sm' id='fecha' name='fecha' placeholder='' required />
								</div>
								<div class='form-group col-md-4 col-sm-12 col-lg-4'>
									<label class='form-label' for='status'>Status: </label>
									<select class='form-control form-control-sm' id='status' name='status'>
										<option value='1'>Activo</option>
										<option value='0'>Inactivo</option>
									</select>
								</div>

								<div class='form-group col-md-4 col-sm-12 col-lg-4'>
									<label class='form-label' for='creacion'>Creacion: </label>
									<input type='text' class='form-control form-control-sm' id='creacion' name='creacion' placeholder='' required />
								</div>
							</div>
							<button type='submit' class='btn btn-sm btn-primary'>Guardar</button>
						</form>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary">Save changes</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	BASE_URL = "<?= base_url(); ?>";
	window.onload = function(event) {
		DATATABLE = s_Datatable("main_table");

	};
</script>