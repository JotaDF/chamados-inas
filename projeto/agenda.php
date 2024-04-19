<?php
//Juridico
$mod = 6;
require_once('./verifica_login.php');
require_once('./actions/ManterAgenda.php');

$db_agenda = new ManterAgenda();
$filtro = " WHERE a.id_usuario=" . $usuario_logado->id;
$events = $db_agenda->listar($filtro);
?>

<!DOCTYPE html>
<html lang="pt-br">

	<head>

    	<meta charset="utf-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
    	<meta name="description" content="">
    	<meta name="author" content="">

    	<title>Agenda</title>
		<!-- Custom fonts for this template-->
		<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

        <!-- Custom styles for this template-->
        <link href="css/sb-admin-2.min.css" rel="stylesheet">
        <link rel="shortcut icon" href="favicon.ico" />
        <!------ Include the above in your HEAD tag ---------->

    	<!-- Bootstrap Core CSS -->
    	<!--link href="agenda/css/bootstrap.min.css" rel="stylesheet" -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94W">
	
		<!-- FullCalendar -->
		<link href='agenda/css/fullcalendar.css' rel='stylesheet' />
		<link href='agenda/css/fullcalendar.print.min.css' rel='stylesheet' media='print' />

    	<!-- Custom CSS Agenda -->
    	<link href='agenda/css/calendar.css' rel='stylesheet' />

	</head>

    <body id="page-top">

        <!-- Page Wrapper -->
        <div id="wrapper">
        <?php include './menu_agenda.php'; ?>
            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">
                <!-- Main Content -->
                <div id="content">
                    <?php include './top_bar.php'; ?>
   
		<!-- Page Content -->
		<div class="container">
			<div class="row">
				<div class="col-lg-12 text-center">
					<p class="lead"></p>
					<div id="calendar" class="col-centered">
					</div>
				</div>
			</div>
			<!-- /.row -->
			</div>
                <!-- End of Main Content -->                
            </div>
            <!-- End of Content Wrapper -->
                    <!-- Footer -->
					<footer class="sticky-footer bg-white">
						<div class="container my-auto">
							<div class="copyright text-center my-auto">
								<span>Copyright &copy; INAS-DF 2023</span>
							</div>
						</div>
					</footer>
					<!-- End of Footer -->
							
					<!-- Logout Modal-->
					<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">Pronto pra sair?</h5>
									<button class="close" type="button" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">×</span>
									</button>
								</div>
								<div class="modal-body">Clique em Sair para fechar sua sessão.</div>
								<div class="modal-footer">
									<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
									<a class="btn btn-primary" href="login.html">Sair</a>
								</div>
							</div>
						</div>
					</div>
        </div>
        <!-- End of Page Wrapper -->

			<!-- Valida data dos Modals -->
			<script type="text/javascript">
				function validaForm(erro) {
					if(erro.inicio.value>erro.termino.value){
						alert('Data de Inicio deve ser menor ou igual a de termino.');
						return false;
					}else if(erro.inicio.value==erro.termino.value){
						alert('Defina um horario de inicio e termino.(24h)');
						return false;
					}
				}
			</script>


			<!-- Modal Editar Evento -->
			<div class="modal fade" id="ModalEvent" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
				<form method="POST" action="save_agenda.php" onsubmit="return validaForm(this);">
                    <input type="hidden" name="id" id="id_evento">
                    <input type="hidden" name="id_usuario" value="<?=$usuario_logado->id ?>" id="id_usuario">

					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Editar Evento</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
					<div class="form-group">
                            <label for="titulo" class="col-sm-2 control-label">Título</label>
                            <div class="col-sm-10">
                            <input type="text" name="titulo" class="form-control" id="titulo" placeholder="Titulo" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="descricao" class="col-sm-2 control-label">Descrição</label>
                            <div class="col-sm-10">
                            <textarea type="text" name="descricao" class="form-control" id="descricao" placeholder="Descrição"></textarea>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="cor" class="col-sm-2 control-label">Cor</label>
                            <div class="col-sm-10">
                            <select name="cor" class="form-control" id="cor">
                            <option value="">Escolher</option>
                                <option style="color:#0071c5" value="#0071c5">&#9724; Azul Escuro</option>
                                <option style="color:#40E0D0" value="#40E0D0">&#9724; Turquesa</option>
                                <option style="color:#008000" value="#008000">&#9724; Verde</option>						  
                                <option style="color:#FFD700" value="#FFD700">&#9724; Amarelo</option>
                                <option style="color:#FF8C00" value="#FF8C00">&#9724; Laranja</option>
                                <option style="color:#FF0000" value="#FF0000">&#9724; Vermelho</option>
                                <option style="color:#000" value="#000">&#9724; Preto</option>
                                
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inicio" class="col-sm-2 control-label">Início</label>
                            <div class="col-sm-10">
                            <input type="text" name="inicio" class="form-control" id="inicio" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="termino" class="col-sm-2 control-label">Término</label>
                            <div class="col-sm-10">
                            <input type="text" name="termino" class="form-control" id="termino" required>
                            </div>
                        </div>
                        <!-- Deletar Evento -->
                        <div class="form-group" id="deletar"> 
                            <div class="col-sm-offset-2 col-sm-10">
                            <div class="checkbox">
                                <label class="text-danger"><input type="checkbox"  name="delete"> Deletar Evento</label>
                            </div>
                            </div>
                        </div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary">Save changes</button>
					</div>

					</form>
				</div>
			</div>
			</div>



		</div>

		<!-- jQuery Version 1.11.1 -->
		<script src="agenda/js/jquery.js"></script>

		<!-- Bootstrap Core JavaScript -->
		<!--script src="agenda/js/bootstrap.min.js"></script-->
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJN">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmW">

		
		<!-- FullCalendar -->
		<script src='agenda/js/moment.min.js'></script>
		<script src='agenda/js/fullcalendar.min.js'></script>
		<script src='agenda/locale/pt-br.js'></script>
		<!-- Custom scripts for all pages-->
        <script src="js/sb-admin-2.min.js"></script>
		<script>
	function modalShow() {
		$('#modalShow').modal('show');
	}

	$(document).ready(function() {
		$('#calendar').fullCalendar({

		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay,listYear'
		},
		validRange:{start: new Date().toISOString().substring(0,10)},
		defaultDate:'<?php echo date('Y-m-d'); ?>',
		editable: true,
		navLinks: true,
		eventLimit: true,
		selectable: true,
		selectHelper: true,
		select: function(start, end) {
			$('#ModalEvent #inicio').val(moment(start).format('DD-MM-YYYY HH:mm:ss'));
			$('#ModalEvent #termino').val(moment(end).format('DD-MM-YYYY HH:mm:ss'));
			$('#ModalEvent').modal('show');
		},
		eventRender: function(event, element) {
			element.bind('click', function() {
				$('#ModalEvent #id_evento').val(event.id);
				$('#ModalEvent #titulo').val(event.title);
				$('#ModalEvent #descricao').val(event.description);
				$('#ModalEvent #cor').val(event.color);
				$('#ModalEvent #inicio').val(event.start.format('DD-MM-YYYY HH:mm:ss'));
				$('#ModalEvent #termino').val(event.end.format('DD-MM-YYYY HH:mm:ss'));
                if(event.id != ""){
                    $("#deletar").show();
                } else {
                    $("#deletar").hide();
                }
				$('#ModalEvent').modal('show');
			});
		},
		eventDrop: function(event, delta, revertFunc) { 
			edit(event);
		},
					
		eventResize: function(event,dayDelta,minuteDelta,revertFunc) { 
			edit(event);
		},

		events: [
					<?php 
                    foreach($events as $event){ 
						$start = explode(" ", $event->inicio);
						$end = explode(" ", $event->termino);
						if($start[1] == '00:00:00'){
							$start = $start[0];
						}else{
							$start = $event->inicio;
						}
						if($end[1] == '00:00:00'){
							$end = $end[0];
						}else{
							$end = $event->termino;
						}
						?>
						{
							id: '<?=$event->id ?>',
							title: '<?=$event->titulo ?>',
							description: '<?=$event->descricao ?>',
							start: '<?=$start ?>',
							end: '<?=$end ?>',
							color: '<?=$event->cor ?>',
						},
						<?php 
		 			} ?>
				]
			});
				
				function edit(event){
					start = event.start.format('DD-MM-YYYY HH:mm:ss');
					if(event.end){
						end = event.end.format('DD-MM-YYYY HH:mm:ss');
					}else{
						end = start;
					}
					
					id =  event.id;
					
					$.ajax({
					url: 'save_agenda_data.php',
					type: "POST",
					data: {'id':id, 'inicio': start, 'termino': end},
					success: function(rep) {
							if(rep == 'OK'){
								alert('Modificação Salva!');
							}else{
								alert('Falha ao salvar, tente novamente!'); 
							}
						}
				});
			}
		});

</script>
<script type="text/javascript" class="init">
                        var total = 0;
                        verificaNotificacoes();
                        function atualizaNotificacoes() {
                            $.get( "get_notificacao.php?id=<?=$usuario_logado->id ?>")
                            .done(function(data) {
                                //var resp = JSON.parse(data);
                                //console.log(resp);
                                $("#notifica").html(data);
                            });

                        }
                        function verificaNotificacoes() {
                            $.get( "get_total_notificacao.php?id=<?=$usuario_logado->id ?>")
                            .done(function(data) {
                                //var resp = JSON.parse(data);
                                //console.log(resp);
                                if(data != total){
                                    total = data;
                                    atualizaNotificacoes();
                                    if(total != 0){
                                        $("#total_not").html(total);
                                    } else {
                                        $("#total_not").html("");
                                    }
                                    
                                }
                            });

                        }
                        setInterval(verificaNotificacoes, 5000); 
                    </script>
		

	</body>

</html>