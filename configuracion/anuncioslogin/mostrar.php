<?php
include_once("../../login/check.php");
include_once("../../class/anuncioslogin.php");
$anuncioslogin = new anuncioslogin;
$men = $anuncioslogin->mostrarAnuncios();
if (count($men)) {
?><a href="#" class="btn btn-mini btn-success" id="exportarexcel"><?php echo $idioma['ExportarExcel'] ?></a>
	<table class="table table-bordered table-striped table-hover table-condensed">
		<thead>
			<tr>
				<th>N</th>
				<th><?php echo $idioma['Mensaje'] ?></th>
				<th><?php echo $idioma['Resaltar'] ?></th>
				<th><?php echo $idioma['Visible'] ?></th>
				<th><?php echo $idioma['FechaRegistro'] ?></th>
				<th></th>
			</tr>
		</thead>
		<?php
		$i = 0;
		foreach ($men as $m) {
			$i++;
		?>
			<tr>
				<td class="der"><?php echo $i ?></td>
				<td><?php echo $m['Mensaje'] ?>
					<br>
					<?php if ($m['Imagen'] != "") { ?>
						<a href="../../<?php echo $m['Imagen'] ?>" class="" target="_blank">
							<img src="../../<?php echo $m['Imagen'] ?>" class="img-polaroid" height="100" style="height:200px" />
						</a>
				</td>
			<?php } ?>
			<td class="centrar"><?php echo $m['Resaltar'] ? $idioma['Si'] : $idioma['No'] ?></td>
			<td class="centrar">
				<span class="badge badge-<?php echo $m['Visible'] ? 'success' : 'important' ?>">
					<?php echo $m['Visible'] ? $idioma['Si'] : $idioma['No'] ?>
				</span>
			</td>
			<td><?php echo date("d/m/Y", strtotime($m['FechaRegistro'])) ?></td>
			<td><a href="#" class="btn btn-mini modificar" title="<?php echo $idioma['Modificar'] ?>" rel="<?php echo $m['CodAnunciosLogin'] ?>"><i class="icon-pencil"></i></a><a href="#" class="btn btn-mini eliminar" title="<?php echo $idioma['Eliminar'] ?>" rel="<?php echo $m['CodAnunciosLogin'] ?>"><i class="icon-remove"></i></a></td>
			</tr>
		<?php
		}
		?>
	</table><?php
		} else {
			?><div class="alert alert-error"><?php echo $idioma['NoExisteMensajesRegistrados'] ?></div><?php
																									}
																										?>