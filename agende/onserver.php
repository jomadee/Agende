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

switch($_GET['ac']){
	case 'programacao':
		$check = true;
		require_once('api/fileup/inicio.php');
		$id = $_GET['id'];
		
		$retorno = jf_form_actions('salvar', 'salvar-edit');
		
		if(!empty($_POST['data']))
			$_POST['data'] = jf_dunix($_POST['data']);
		
		if(empty($_POST['organizador'])){
			$_SESSION['aviso'][0] = '<strong>Erro:</strong> Selecione um organizador';
			$check = false;
		}
		
		$file = new fileup;
		$file->diretorio = '../uploads/agende/';
		$file->up(); 
			
		if($check){
			if(empty($id)){
				global $jf_ultimo_id;
				echo jf_insert(PREFIXO.'agende_programacao', $_POST);
				$id = $jf_ultimo_id;
				
				$_SESSION['aviso'] = array('Programação adicionada com sucesso!', 1);
			} else {
				jf_update(PREFIXO.'agende_programacao', $_POST, array('id' => $id));
				
				$_SESSION['aviso'] = array('Programação alterada com sucesso!', 1);
			}
		} else {
			$retorno = 'salvar-edit';
		}
		
		switch ($retorno){
			case 'salvar':
				$retorno = $_ll['app']['home'].(isset($_GET['pagina'])?'&pagina='.$_GET['pagina']:'');
			break;
			
			case 'salvar-edit':
				$retorno = $_ll['app']['home'].(isset($_GET['pagina'])?'&pagina='.$_GET['pagina']:'').'&id='.$id;
			break;		
		}
		
		header('location: '.$retorno);
	break;
	
	
	case 'organ':
		require_once('api/fileup/inicio.php');
		$id = $_GET['id'];
		
		$retorno = jf_form_actions('salvar', 'salvar-edit');

		$file = new fileup;
		$file->diretorio = '../uploads/agende/';
		$file->up(); 
		
		if(empty($id)){
			global $jf_ultimo_id;
			jf_insert(PREFIXO.'agende_organizadores', $_POST);
			$id = $jf_ultimo_id;
			
			$_SESSION['aviso'] = array('Organizador adicionado com sucesso!', 1);
		} else {
			jf_update(PREFIXO.'agende_organizadores', $_POST, array('id' => $id));
			
			$_SESSION['aviso'] = array('Organizador alterado com sucesso!', 1);
		}
		
		switch ($retorno){
			case 'salvar':
				$retorno = $_ll['app']['home'].'&p=organ'.(isset($_GET['pagina'])?'&pagina='.$_GET['pagina']:'');
			break;
			
			case 'salvar-edit':
				$retorno = $_ll['app']['home'].'&p=organ'.(isset($_GET['pagina'])?'&pagina='.$_GET['pagina']:'').'&id='.$id;
			break;		
		}
		
		header('location: '.$retorno);
	break;
	
	case 'programacao-del':
		jf_delete(PREFIXO.'agende_programacao', array('id' => $_GET['programacao-del']));
		
		$_SESSION['aviso'] = array('Programação excluida com sucesso!', 1);
		
		header('location: ../../index.php?app=agende'.(isset($_GET['pagina'])?'&pagina='.$_GET['pagina']:''));
	break;
}


?>
