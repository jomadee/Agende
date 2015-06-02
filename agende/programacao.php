<?php
/**
*
* Agende | lliure 5.x
*
* @Versão 4.3
* @Desenvolvedor Jeison Frasson <jomadee@lliure.com.br>
* @Entre em contato com o desenvolvedor <jomadee@lliure.com.br> http://www.lliure.com.br
* @Licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
?>

<div class="contBlog">
	<div class="menuBlog">
		<ul>
			<li class="top">Programação</li>
			<li><a href="<?php echo $llHome.'&amp;id'?>"><img src="<?php echo $_ll['tema']['icones'].'lightbulb.png'; ?>"> Adicionar programação</a></li>
			<li><a href="<?php echo $llHome?>"><img src="<?php echo $_ll['tema']['icones'].'list_num.png'; ?>"> Listar programação</a></li>
		</ul>
	</div>

	<?php
	if(!isset($_GET['id'])){ //////////////////////////////	LISTANDO POSTAGENS	
		$consulta = "select * from ".$llTable."_programacao order by id desc";
		$query = mysql_query($consulta);
		$tr = mysql_num_rows($query); 

		$total_reg = "10";

		if (!isset($_GET['pagina'])) {
			$pc = "1";
		} else {
			$pc = $_GET['pagina'];
		} 
		
		$inicio = $pc - 1;
		$inicio = $inicio * $total_reg; 
				
		$tp = ceil($tr / $total_reg); 
		
		$limite = mysql_query($consulta." LIMIT $inicio,$total_reg ");
		?>
		<script type="text/javascript">
			$().ready(function() {
				$('.excluir').click(function() {
					return confirmAlgo('essa programação');
				});
			});
		</script>
		
		<table class="table">
			<tr>
				<th width="85px">Data</th>		
				<th>Nome</th>
				<th style="width: 20px;"></th>		
			</tr>
		<?php
		$i = 1;
		while($dados = mysql_fetch_array($limite)){
			?>
			<tr class="alterna<?php echo ($i%2?'0':'1')?>">
				<td><?php echo !empty($dados['data']) ? date('d/m H:i',$dados['data']) : 'sem data'?></td>
				
				<td><a href="<?php echo $llHome.'&amp;id='.$dados['id'].(isset($_GET['pagina'])?'&amp;pagina='.$_GET['pagina']:''); ?>"><?php echo $dados['titulo'];?><a/></td>
								
				<td class="ico"><a href="<?php echo $_ll['app']['onserver'].'&ac=programacao-del&id='.$dados['id'].(isset($_GET['pagina'])?'&amp;pagina='.$_GET['pagina']:'')?>" title="excluir" class="excluir"><img src="<?php echo $_ll['tema']['icones'].'trash.png'; ?>" alt="excluir"/></a></td>
			</tr>
			<?php		
			$i++;
		}
		?>
		</table>

		<div class="paginacao">
			<?php
			$anterior = $pc -1;
			$proximo = $pc +1;
			
			$url = $llHome;
			
			if($tp > 1){
				$tm = 3;
				
				$ini = $pc-$tm;
				if($ini < 1){
					$ini = 1;
				}

				$ult = $pc+$tm;
				if($ult > $tp){
					$ult = $tp;
				}
			
				for($i = $ini; $i <= $ult; $i++){
					echo ($i > 1?'<span>|</span>':'');
					echo "<span><a href='".$url."&amp;pagina=".$i."'".($i == $pc?"class='atual'":"").">".$i."</a></span>";
				}
			}
			?>
		</div>
		<?php
		if($tr < 1){
			echo 'Nenhuma programação encontrada';
		}
	} else { //////////////////////////////	PROGRAMAÇÃO
		$dados = mysql_fetch_array(mysql_query('select * from '.$llTable.'_programacao where id ="'.$_GET['id'].'" limit 1'));
			
		$organ = mysql_query('select * from '.$llTable.'_organizadores order by nome asc')
		?>

		
		<div class="limitBlog">
			<form method="post" class="form" action="<?php echo $_ll['app']['onserver'].'&ac=programacao&id='.$_GET['id'].(isset($_GET['pagina'])?'&amp;pagina='.$_GET['pagina']:'')?>" enctype="multipart/form-data">
				<fieldset>			
					<div>
						<table>
							<tr>
								<td>	
									<label>Nome</label>
									<input type="text" value="<?php echo (isset($dados['titulo'])?$dados['titulo']:'')?>" name="titulo" />
								</td>
								
								<td style="width: 30%;">
									<label>Organizador</label>
									<select name="organizador" >
										<?php
										while($orgDados = mysql_fetch_assoc($organ)){
											echo '<option value="'.$orgDados['id'].'" '.(isset($dados['organizador']) && $dados['organizador'] == $orgDados['id'] ? 'selected' : '').'>'.$orgDados['nome'].'</option>';
										}
										?>
									</select>
								</td>
								
								<td  style="width: 20%;">
									<label>Data</label>
									<input type="text" value="<?php echo (isset($dados['data']) && !empty($dados['data'])? date('d/m/Y H:i',$dados['data']):'')?>" class="data" name="data" />
								</td>
							</tr>
						</table>					
					</div>

					<div>
						<label>Endereço</label>
						<input type="text" name="endereco" value="<?php echo isset($dados['endereco'])? $dados['endereco'] : '';?>"/>
					</div>
					
					<div>
						<label>Descrição</label>
						<textarea name="descricao" class="texto"><?php echo (isset($dados['descricao'])?stripslashes($dados['descricao']):'')?></textarea>
					</div>
					
				</fieldset>
				
				<div class="botoes">
					<button type="submit" class="confirm" name="salvar">Salvar</button>
					<a href="<?php echo $backReal;?>">Voltar</a>
					<button type="submit" name="salvar-edit">Salvar e continuar editando</button>
				</div>
			</form>				
		</div>
		
		<script src="js/jquery.maskedinput.js" type="text/javascript"></script>
		<script type="text/javascript">		
			$(document).ready(function(){
				$(".data").mask("99/99/9999 99:99");
				
				ajustaForm();
			});
			
			tinyMCE.init({
				// General options
				mode : "textareas",
				theme : "lliure",
				width: '100%',
			});
		</script>
		<?php
	}
	?>
</div>
