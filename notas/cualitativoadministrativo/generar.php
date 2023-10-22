<?php
include_once("../../login/check.php");
if(isset($_POST)){
	$Periodo=$_POST['Periodo'];
	include_once("../../class/casilleros.php");
	include_once("../../class/notascualitativa.php");
	$casilleros=new casilleros;
	$notascualitativa=new notascualitativa;
	$casillas=$casilleros->mostrarTodo("Trimestre=$Periodo");
	if(count($casillas)){
		//echo count($casillas);
		$notas=$notascualitativa->mostrarTodoRegistro("Trimestre=$Periodo");	
		if(count($notas)){
			?><div class="alert alert-error"><strong><?php echo $idioma["NotasCualitativasYaGeneradasParaPeriodo"];?></strong><hr />
            <strong><?php echo $idioma["DeseaVolverAGenerar"];?> <?php echo $Periodo?> <?php echo $idioma['Periodo']?></strong></div>
            <button class="btn btn-danger" id="generarreemplazar" rel="<?php echo $Periodo?>"><?php echo $idioma['ComprendoYDeseoGenerar']?></button>
			<?php 
		}else{
			foreach($casillas as $cas){
				$valores=array("Trimestre"=>$Periodo,
							"CodDocenteMateriaCurso"=>$cas['CodDocenteMateriaCurso']
							);
				$notascualitativa->insertarRegistro($valores);
			}
			?>
            <div class="alert alert-success">
        		<strong><?php echo $idioma['CasillerosNotasCualitativas']?> <?php echo $idioma['GeneradosCorrectamente']?></strong>
        	</div>
            <?php
		}
	}else{
		?><div class="alert"><strong><?php echo $idioma["NoTieneAsignadoCasillerosParaPeriodo"];?></strong>
        </div>
        <div class="alert alert-info">
        <strong><?php echo $idioma["AsigneCasillerosLuegoGenereNotasCualitativas"];?></strong>
		</div>
		<?php
	}
}
?>