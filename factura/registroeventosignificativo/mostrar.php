<?php
require_once '../../login/check.php';

require_once '../../factura/sfe/core.php';
$core = new Core;
$eventDate = date("Y-m-d", strtotime($_POST['fechaEvento']));
$eventStatus = 'PENDING';
$showRegisteredEvents = $core->showRegisteredEvents('', '', $eventDate, $eventStatus);
$eventosSignificativos = [];
if ($showRegisteredEvents['status'] == true) {
    $eventosSignificativos = $showRegisteredEvents['data'] ?? [];
}
if (count($eventosSignificativos) == 0) {
    echo "<div class='alert alert-error'>" . $idioma['NoHayEventosSignificativos'] . "</div>";
    return;
}
?>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>N</th>
            <th><?php echo $idioma['EventoSignificativo'] ?></th>
            <th><?php echo $idioma['Descripcion'] ?></th>
            <th><?php echo $idioma['FechaInicio'] ?></th>
            <th><?php echo $idioma['FechaFin'] ?></th>
            <th><?php echo $idioma['Estado'] ?></th>
            <th><?php echo $idioma['FacturasEmitidas'] ?></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        foreach ($eventosSignificativos as $evento) :
            $i++;
        ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo ucfirst(mb_strtolower($evento['event_reason_description'])) ?></td>
                <td><?php echo $evento['description'] ?></td>
                <td><?php echo $evento['date_start_event'] ?></td>
                <td><?php echo $evento['date_end_event'] ?></td>
                <td><?php echo $evento['event_status'] ?></td>
                <td><?php echo $evento['count_invoices'] ?></td>
                <td>
                    <?php if ($evento['count_invoices'] == 0) { ?>
                        <a href="cancelarevento.php?CodigoEventoSignificativo=<?php echo $evento['unique_id_event'] ?>" class="btn btn-info cancelarEvento" data-row="<?php echo $i ?>"><?php echo $idioma['CancelarEvento'] ?></a>
                    <?php } ?>
                    <?php if ($evento['date_end_event'] == "" && $evento['count_invoices'] == 0) { ?>
                        <a href="finalizarevento.php?CodigoEventoSignificativo=<?php echo $evento['unique_id_event'] ?>" class="btn btn-warning finalizarEvento" data-row="<?php echo $i ?>"><?php echo $idioma['FinalizarEvento'] ?></a>
                    <?php } ?>
                    <?php if ($evento['date_end_event'] != "") { ?>
                        <a href="enviarpaquete.php?CodigoEventoSignificativo=<?php echo $evento['unique_id_event'] ?>" class="btn btn-info enviarPaquete" data-row="<?php echo $i ?>"><?php echo $idioma['EnviarPaquete'] ?></a>
                    <?php } ?>
                    <div class="response_row_<?php echo $i ?>"></div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>