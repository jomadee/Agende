<?php
/**
*
* Agende | lliure 5.x
*
* @Versão 4.0
* @Desenvolvedor Jeison Frasson <jomadee@lliure.com.br>
* @Entre em contato com o desenvolvedor <jomadee@lliure.com.br> http://www.lliure.com.br
* @Licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

class calendario{

	public $urlReal;
	
	var $mes = array(
					'01' => 'Janeiro',
					'02' => 'Fevereiro',
					'03' => 'Março',
					'04' => 'Abril',
					'05' => 'Maio',
					'06' => 'Junho',
					'07' => 'Julho',
					'08' => 'Agosto',
					'09' => 'Setembro',
					'10' => 'Outubro',
					'11' => 'Novembro',
					'12' => 'Dezembro'
					);
					
	function setUrl( $urlReal )	{
		$this->url = $urlReal;
	}
	
	function mesAnterior($dia,$mes,$ano){
		if($mes == 1){
			$man = 12;
			$aan = $ano - 1;
		} else {
			$man = $mes - 1;
			$aan = $ano;
		}

		$val = checkdate($man,$dia,$aan);
		if($val == 0){
			$dia = 1;
		}
		echo '<a href="'.$this->url.'data='.sprintf("%02.0f",$dia).'/'.sprintf("%02.0f",$man).'/'.$aan.'">«</a>';
	}

	function mesProximo($dia,$mes,$ano){
		if($mes == 12){
			$mpr = 1;
			$apr = $ano + 1;
		} else {
			$mpr = $mes + 1;
			$apr = $ano;
		}

		$val = checkdate($mpr,$dia,$apr);
		if($val == 0){
			$dia = 1;
		}
		echo '<a href="'.$this->url.'data='.sprintf("%02.0f",$dia).'/'.sprintf("%02.0f",$mpr).'/'.$apr.'">»</a>';
	}

	function anoAnterior($dia,$mes,$ano){
		$aan = $ano - 1;
		echo '<a href="'.$this->url.'data='.sprintf("%02.0f",$dia).'/'.sprintf("%02.0f",$mes).'/'.$aan.'">«</a>';
	}

	function anoProximo($dia,$mes,$ano){
		$apr = $ano + 1;
		echo '<a href="'.$this->url.'data='.sprintf("%02.0f",$dia).'/'.sprintf("%02.0f",$mes).'/'.$apr.'">»</a>';
	}
   
	function cria($data){
		$arr = explode("/",$data);
		$dia = $arr[0];
		$mes = $arr[1];
		$ano = $arr[2];

		if(($dia == '') OR ($mes = '') OR ($ano = '')){
			$data = date("d/m/Y");
			$arr = explode("/",$data);
			$dia = $arr[0];
			$mes = $arr[1];
			$ano = $arr[2];
		}

		$arr = explode("/",$data);
		$dia = $arr[0];
		$mes = $arr[1];
		$ano = $arr[2];

		$val = checkdate($mes,$dia,$ano); // Verifica se a data é válida
		if($val == 1){
			$ver = date('d/m/Y', mktime(0,0,0,$mes,$dia,$ano));
		} else {
			$ver = date('d/m/Y', mktime(0,0,0,date(m),date(d),date(Y)));
		}

		$arr = explode("/",$ver);
		$dia = $arr[0];
		$mes = $arr[1];
		$ano = $arr[2];

		$ult = date("d", mktime(0,0,0,$mes+1,0,$ano));
		$dse = date("w", mktime(0,0,0,$mes,1,$ano));

		$tot = $ult+$dse;
		if($tot != 0){
			$tot = $tot+7-($tot%7);
		}

		for($i = 0; $i <= 31; $i++){
			$evento[$i] = 0;
		}
	
		
		$sql = mysql_query("
					select a.id, FROM_UNIXTIME(a.data, '%e') as dia, a.data, a.nome, b.logo
					from plugin_programacao a
					
					left join plugin_programacao_organ b
					on b.id = a.organizador
					
					where FROM_UNIXTIME(a.data, '%m-%Y') = '".$mes."-".$ano."'
					") or die(mysql_error());
					
		while($eventos = mysql_fetch_assoc($sql)){
			$evento[$eventos['dia']] = $eventos;
		}

		for($i=0;$i<$tot;$i++){
			$dat = $i-$dse+1;
			if(($i >= $dse) AND ($i < ($dse+$ult))){
				$aux[$i]  = '';
				if(isset($evento[$dat]['id'])){ // dia que tem evento
					$aux[$i] .= '<td class="temEvento"><div class="padding">'.
							
							(!empty($this->url) ?
							'<a href="'.$this->url.'data='.sprintf("%02.0f",$dat).'/'.$mes.'/'.$ano.'">'.$dat.'</a>' :
							'<span class="diTo">Dia '.str_pad($dat, 2, 0, STR_PAD_LEFT).' <span> - '.date('H', $evento[$dat]['data']).'h</span> </span>').	
							'<span class="banda">'.$evento[$dat]['nome'].'</span>'.
							'<img src="uploads/programacao/'.$evento[$dat]['logo'].'" alt="" />'.
							'</div></td>';
				} elseif(($dat == date(d)) AND ($mes == date(m)) AND ($ano == date(Y))){  // Hoje!!
				
					$aux[$i] .= '<td class="calendario_dias_hoje"><div class="padding">'.$dat.'</div></td>';;
				} else { // Outros dias
				
					$aux[$i] .= '<td class="calendario_dias"><div class="padding">Dia '.str_pad($dat, 2, 0, STR_PAD_LEFT).'</div></td>';
				}
			} else {
				$aux[$i] = '
				<td>
				</td>
				';
			}

			if(($i%7) == 0){
				$aux[$i] = '<tr align="center">'.$aux[$i];
			}

			if(($i%7) == 6){
				$aux[$i] .= '</tr>';
			}
		}	

		?>
		<table>
			<?/*
			<tr class="calendario_mes_ano">
				<td> <?php $this->anoAnterior($dia,$mes,$ano); ?></td>
				
				<td colspan="5"><?php echo $ano ?></td>
				
				<td> <?php $this->anoProximo($dia,$mes,$ano); ?></td>
			</tr>
			<tr class="calendario_mes_ano">
			
				<td>
					<?php
					$this->mesAnterior($dia,$mes,$ano);
					?>
				</td>
				
				<td colspan="5"><?php echo $this->mes[$mes] ?></td>
			
				<td><?php $this->mesProximo($dia,$mes,$ano); ?></td>
			</tr>
			*/?>


			<tr class="calendario_semana">
				<td>Dom</td>
				<td>Seg</td>
				<td>Ter</td>
				<td>Qua</td>
				<td>Qui</td>
				<td>Sex</td>
				<td>Sab</td>
			</tr>
			  <?php echo implode(' ',$aux);
			  if(count($aux) == 35){
				?>
				  <tr>
					<td colspan="7"></td>
				  </tr>
				<?php
			  }
			  
			 /*
			?>
			<tr>
				<td class="calendario_mes_ano" colspan="7" align="center">[ <a href="<?php echo $this->url.'data='. date(d).'/'.date(m).'/'.date(Y)?>">Hoje</a> ]</td>
			</tr>
			*/
			?>
		</table>
		<?php
	} 
} 
?>
<div class="calendario">
	<?php
	$calendario = new calendario;
	$calendario->setUrl("");
	$calendario->cria($_GET["data"]);
	?>
</div>