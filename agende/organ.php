<?php
/**
*
* Agende | lliure 5.x
*
* @Versão 4.1
* @Desenvolvedor Jeison Frasson <jomadee@lliure.com.br>
* @Entre em contato com o desenvolvedor <jomadee@lliure.com.br> http://www.lliure.com.br
* @Licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
?>

<div class="contBlog">
	<div class="menuBlog">
		<ul>
			<li class="top">Organizadores</li>
			<li><a href="<?php echo $llHome.'&amp;p=organ&amp;id'?>"><img src="<?php echo $_ll['tema']['icones'].'lightbulb.png'; ?>"> Adicionar organizador</a></li>
			<li><a href="<?php echo $llHome.'&amp;p=organ'?>"><img src="<?php echo $_ll['tema']['icones'].'list_num.png'; ?>"> Listar Organizadores</a></li>
		</ul>
	</div>

	<?php
	if(!isset($_GET['id'])){ //////////////////////////////	LISTANDO POSTAGENS	

		$navegador = new navigi();
		$navegador->tabela = $llTable.'_organizadores';
		$navegador->query = 'select * from '.$navegador->tabela.' order by id desc';
		$navegador->delete = true;
		$navegador->rename = true;
		$navegador->pasta = $llPasta;
		$navegador->config = array('link' => $llHome.'&p=organ&id=', 'ico' => $llAppPasta.'img/organizador.png');
		$navegador->monta();
	
	} else { //////////////////////////////	EDIÇÃO DO ORGANIZADOR
		$consulta = mysql_query('select * from '.$llTable.'_organizadores where id = "'.$_GET['id'].'" limit 1');
		$dados = mysql_fetch_assoc($consulta);
		
		
		?>		
		<div class="limitBlog">			
			<form method="post" class="form" action="<?php echo  $_ll['app']['onserver'].'&ac=organ&id='.$_GET['id']?>"  enctype="multipart/form-data">
				<fieldset style="width: 500px;">				
					<div style="width: 338px;">
						<label>Nome</label>
						<input type="text" value="<?php echo (isset($dados['nome'])?$dados['nome']:'')?>" name="nome" />
					</div>	

					<div>
						<?php
						$file = new fileup; 
						$file->titulo = 'Logo';
						$file->rotulo = 'Selecionar imagem';
						$file->registro = $dados['logo'];
						$file->campo = 'logo';
						$file->extencao = 'png jpg';
						$file->form();
						?>
					</div>
				</fieldset>
				
				<div class="botoes">
					<button type="submit" class="confirm" name="salvar">Salvar</button>
					<a href="<?php echo $backReal;?>">Voltar</a>
					<button type="submit" name="salvar-edit">Salvar e continuar editando</button>
				</div>
			</form>
					
		</div>
		<?php
	}
	?>
</div>
