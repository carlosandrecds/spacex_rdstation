<div class="page-header card">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h5>Upcoming Launchs</h5>
                    <span>Here you can find all the launchs coming at SpaceX</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class=" breadcrumb breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url(); ?>"><i class="feather icon-home"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="pcoded-inner-content">
	<div class="main-body">
		<div class="page-wrapper">
			<div class="page-body">

				<!-- [ page content ] start -->
				<div class="row">
					<div class="col-sm-12">
						<div class="card">
							<div class="card-header">
								<h5>Listagem</h5>
									<div class="card-header-right">
									Check all  Launchs
                                </div>
							</div>
							<div class="card-block">
								<p>

								<div class="card-body">

									<div class="table-responsive">
									<table class="table table-de table-columned">
										<thead>
											<tr style="background-color: white">
												<th>Flight Number</th>	
												<th>Name</th>
												<th>Data</th>
												<th>Status</th>
											</tr>
										</thead>
										<tbody>
											<?php 

												$curl = curl_init();

												curl_setopt_array($curl, array(
												CURLOPT_URL => 'http://local.api.com/upcoming',
												CURLOPT_RETURNTRANSFER => true,
												CURLOPT_ENCODING => '',
												CURLOPT_MAXREDIRS => 10,
												CURLOPT_TIMEOUT => 0,
												CURLOPT_FOLLOWLOCATION => true,
												CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
												CURLOPT_CUSTOMREQUEST => 'GET',
												));

												$data = curl_exec($curl);

												curl_close($curl);
												
												$api = json_decode($data);


												foreach (@$api as $key) 
												{		
													//FORMAT THE DATE FROM THE API
													$da = date_create($key->date_utc);
													$data = date_format($da, "d/m/Y H:i:s");

													if($key->upcoming == TRUE){
														$upcoming = '<div class="btn btn-success" >UPCOMING EVENT</div>';
													}else{
														$upcoming = '<div class="btn btn-danger" >DONE</div>';
													}

													echo '<tr>';
														echo "<td>$key->flight_number</td>";
														echo "<td>$key->name</td>";
														echo "<td>$data</td>";
														echo "<td>$upcoming</td>";
													echo '</tr>';
												}
											?>
										</tbody>
									</table>
									</div>
								</p>
							</div>
						</div>
					</div>
				</div>
				<!-- [ page content ] end -->
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

    <?php 
    	
    	if ( $this->session->flashdata('message') != '' ) : 
    ?>

    	var retornoMsg = <?php echo $this->session->flashdata('message'); ?>;

    	if ( retornoMsg.tip == 2 )
    	{
			var titulo = 'Erro';
			var tipo = 'error';
		}
		else
		{
			var titulo = 'Sucesso';
			var tipo = 'success';
		}

		function verificarCheckBox() {
			var check = document.getElementsByName("itemCheck"); 

			for (var i=0;i<check.length;i++){ 
				if (check[i].checked == true){ 
					// CheckBox Marcado... Faça alguma coisa...

				}  else {
				// CheckBox Não Marcado... Faça alguma outra coisa...
				}
			}
		}
		
        swal({
			title: titulo,
			text: retornoMsg.msg,
			type: tipo
		});

	<?php endif; ?>

</script>