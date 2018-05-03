<?php  


?>
<form action='#' method="post" id="formulario_upload_files" enctype="multipart/form-data">
	
	<div class="container-fluid">
		<div class="col-md-6">
			<div class="form-group">
				<label>Upload de Foto da Pessoa:</label>
				<div class="input-group">
					<span class="input-group-btn">
						<span class="btn btn-default btn-file">
							Procurar... <input class="form-group" type="file" name="img_perfil" id="img_perfil">
						</span>								
					</span>
					<input id="urlFile" type="text" class="form-control" readonly>
				</div>		
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<img id="img-upload">							
			</div>
		</div>
	</div>

	<div class="container-fluid">
		<div class="col-md-6">
			<div class="form-group">
				<label>Upload de Atestado Médico:</label>
				<div class="input-group">
					<span class="input-group-btn">
						<span class="btn btn-default btn-file">
							Procurar... <input class="form-group" type="file" name="atestado_medico" id="atestado_medico">
						</span>								
					</span>
					<input id="urlFile" type="text" class="form-control" readonly>
				</div>		
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<img id="img-upload">							
			</div>
		</div>
	</div>

	<div class="container-fluid">
		<div class="col-md-6">
			<div class="form-group">
				<label>Upload de Autorização para Menores:</label>
				<div class="input-group">
					<span class="input-group-btn">
						<span class="btn btn-default btn-file">
							Procurar... <input class="form-group" type="file" name="autorizacao_menor" id="autorizacao_menor">
						</span>								
					</span>
					<input id="urlFile" type="text" class="form-control" readonly>
				</div>		
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<img id="img-upload">							
			</div>
		</div>
	</div>
	
	<div class="container-fluid">
		<div class="col-lg-3">
			<div class="form-group" id="botoes">
				<input type="button" class="btn btn-primary" id="btn_next" name="btn_next" value="Seguinte">
            	<input type="button" class="btn btn-primary" id="btn_upload" name="btn_upload" value="Carregar">
            	<input type="reset" class="btn btn-default" id="reset" value="Reset"> 

        	</div>
    	</div>	        	
    </div> 
</form>