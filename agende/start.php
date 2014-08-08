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


$llHome = 'index.php?app=agende';
$llPasta = 'app/agende/';
$llTable = PREFIXO.'agende';

$botoes = array(
	array('href' => $backReal, 'img' => $plgIcones.'br_prev.png', 'title' => $backNome)
	);

if(isset($_GET['grupo'])){
	$botoes[] = array('href' => $llHome.'&amp;p=programacao&amp;grupo='.$_GET['grupo'].'&amp;id', 'img' => $plgIcones.'preso.png', 'title' => 'Adicionar banner');
} else {
	$botoes[] = array('href' => $llHome.'&amp;p=organ', 'img' => $plgIcones.'folder.png', 'title' => 'Organizadores');
	$botoes[] = array('href' => $llHome, 'img' => $plgIcones.'folder.png', 'title' => 'Programação');

}

echo app_bar('Agende', $botoes);

require_once(( isset($_GET['p']) ? $_GET['p'] : 'programacao' ).".php");
?>
