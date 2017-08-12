<?php

/*------------------------------------------------------------*/
/* Clase para un reporte con paginacion Ajax
/* date: 30-09-09
/*------------------------------------------------------------*/

class simplePagina{  
  var $rpp  = 20;
  var $page = 1;
  var $count= 0;
  var $task = '';
  var $div  = '';
  var $code = '';
  
  
  function simplePagina( $count, $div, $page=1, $task="", $rpp=20){    
    $this->count= $count;
    $this->page = $page;
    $this->rpp  = $rpp;
    $this->task = $task;
    $this->div  = $div;
  }
  
  function addControls(){
    $this->code .="<div class=\"controls\">";      
    $this->code .="<a href=\"#\" onclick=\"first('".$this->task."','".$this->div."'); return false;\" title=\"Pagina inicial\"><img src=\"images/icons/first.gif\" alt=\"Pagina Inicial\" style=\"vertical-align:middle;\"/> Inicio</a>&nbsp;&nbsp;";
    $this->code .="<a href=\"#\" onclick=\"previus('".$this->task."','".$this->div."'); return false;\" title=\"Anterior\"><img src=\"images/icons/previus.gif\" alt=\"\" style=\"vertical-align:middle;\" /> Ant.</a>&nbsp;&nbsp;";
    $this->code .= "<select id=\"ipage\" onchange=\"goPage('".$this->task."','".$this->div."'); return false;\">";
    $nro = ceil($this->count/$this->rpp);    
    if( $nro > 0 ){
      for( $i = 1; $i<= $nro; $i++ ){
        if( $i == $this->page){
          $this->code .= "<option value=\"".$i."\" selected=\"selected\">".$i."</option>\n";
        }else{
          $this->code .= "<option value=\"".$i."\">".$i."</option>\n";
        }        
      }
    }else{
      $this->code .= "<option value=\"1\">1</option>\n";
    }
    $this->code .="</select>\n";
    $this->code .="&nbsp;<a href=\"#\" onclick=\"nextp('".$this->task."','".$this->div."'); return false;\" title=\"Siguiente\">Sig. <img src=\"images/icons/next.gif\" alt=\"Siguiente\" style=\"vertical-align:middle;\" /></a>&nbsp;&nbsp;";
    $this->code .="<a href=\"#\" onclick=\"last('".$this->task."','".$this->div."'); return false;\" title=\"Ultima Pagina\">Final <img src=\"images/icons/last.gif\" alt=\"Ultima\" style=\"vertical-align:middle;\" /></a>&nbsp;&nbsp;";
    $this->code .="</div>";
    $this->code .="<input type=\"hidden\" id=\"pages\" value=\"".$nro."\" />\n";
    
    return $this->code;
  }
  
}

class ximpleTable{
	var $code = "";	
	var $openTr = 0;
  var $nroColumns = 0;
	
	function ximpleTable( $class, $more = "" ){
		$this->code .= "\n<table class=\"".$class."\" ".$more." border=\"0\" cellspacing=\"0\" cellpadding=\"0\" >\n";
	}
  
  function setHead( $class, $vector ){
		$this->code .= "<tr class=\"".$class."\">\n\t";
		for( $i = 0, $n = count( $vector ); $i < $n; $i++ ){
			$this->code .= "<th>".$vector[$i]."</th> ";
		}
		$this->nroColumns = $n;
		$this->code .= "\n</tr>\n";
	}
		
	function addRow( $class = "", $more = "" ){
		if( $this->openTr ){
			$this->code .= "</tr>\n";
		}
		$this->code .= "<tr".($class==""?"":" class=\"".$class."\"")." ".($more==""?"":$more).">\n\t";
		$this->openTr = 1;
	}
	
	function addCell( $value, $more = "" ){
		$this->code .= "<td".($more==""?"":" ".$more." ").">".$value."</td>";
	}
	
  
  function show(){
		if( $this->openTr == 1 ){
			$this->code .= "</tr>\n";
		}
		$this->code .= "</table>\n";
		return $this->code;
	}

}

class simpleWindow{
	var $css = "";
	var $footer = 0; 
	
	function simpleWindow( $id, $title="", $width="100%", $margin="10px auto" ){
		echo "<div id=\"".$id."\"style=\"width:".$width."; margin: ".$margin."; \">\n";
		echo "<div class=\"x-box-tl\">\n";
		echo "  <div class=\"x-box-tr\">\n";
		echo "    <div class=\"x-box-tc\"></div>\n";
		echo "  </div>\n";
		echo "</div>\n";
		echo "<div class=\"x-box-ml\">\n";
		echo "  <div class=\"x-box-mr\">\n";
		echo "    <div class=\"x-box-mc\">\n";
		echo "       <div class=\"xsubtitulo\"> ".$title."</div>\n";
		echo "       <div class=\"mainbody\">\n ";
	}
  
	function setCss( $styles ){
		$this->css = $styles;
	}
	
	function addCell( $class, $value = "", $id = "", $more = "" ){
		echo "<div class=\"".$class."\" ".($id==""?"":"id=\"".$id."\"")." >".$value." ".$more."</div>\n";
	}
  
	function setData( $data = "", $title="" ){    
		echo $title!=""?("<div class=\"xsubtitulo\"><br/> ".$title."</div>\n"):"";
		echo $data;    
	}
  
	function setBody( $data = "", $title="", $line=0 ){    
		echo "<fieldset>\n";
		echo $title!=""?(" <legend>".$title."</legend>\n"):"";
		echo $data;
		echo "</fieldset>\n";    
	}
  
  function setMore( $more = "", $title = "", $line=0 ){        
    echo "       <div class=\"mainbody\">\n ";
    echo "<fieldset>\n";
    echo $title!=""?(" <legend>".$title."</legend>\n"):"";    
    echo $more;
    echo "</fieldset>\n";
    echo "</div>\n";    
    echo $line==1?"<div class=\"myfooter\"></div>\n":"";
  }  
  function setExtra( $extra = "", $title = "", $line=0 ){    
    echo $title!=""?("<div class=\"xsubtitulo\"><br/> ".$title."</div>\n"):"";
    echo "       <div class=\"mainbody\">\n ";
    echo $extra;
    echo "</div>\n";
    echo $line==1?"<div class=\"myfooter\"></div>\n":"";
  }
  
  function setFoot( $foot = "", $align="left" ){ // next to set.data
    $this->footer = 1;   
    echo "</div>\n"; // closing to data
    echo "<div class=\"myfooter\"></div>\n";
    echo "<div style=\"text-align: ".$align.";\"> ".$foot."</div>\n";
  } 
  
  function setFooter( $foot = "", $align="left" ){ // Iconos    
    echo "<div style=\"text-align: ".$align.";\"> ".$foot."</div>\n";
  } 
  
  function setLine(){
    echo "<div class=\"myline\"></div>\n";
  }  
  
  function closeWindow(){    
    if( $this->footer == 0 ){
      echo "    </div>\n";
    }
    echo "    </div>\n";
    echo "  </div>\n";
    echo "</div>  \n";
    echo "<div class=\"x-box-bl\">\n";
    echo "  <div class=\"x-box-br\">\n";
    echo "    <div class=\"x-box-bc\"></div>\n";
    echo "  </div>\n";
    echo "</div>\n";
    echo "</div>\n";
  }

}

/*------------------------------------------------------------*/
/* Clase para dibujar con divs con medidas
/* date: 10-08-09
/*------------------------------------------------------------*/
class ximpleDiv{
  var $css = "";

  function ximpleDiv( $id, $code="", $width="98%", $height="auto" ){
    echo "<div id=\"".$id."\" style=\"width:".$width."; height:".$height."\">".$code."\n";
  }

  function setCss( $styles ){
    $this->css = $styles;
	}

  function addCell( $class, $value = "",  $width="98%", $height="auto", $id = "", $more = "" ){
		echo "<div class=\"".$class."\" ".($id==""?"":"id=\"".$id."\"")." style=\"width:".$width."; height:".$height.";\" >".$value." ".$more."</div>\n";
	}

  function add2Cell( $label, $value, $lwidth = "25%", $vwidth = "78%",  $lheight = "auto", $vheight = "auto" ){
		echo "<div class=\"".$this->css."1\" style=\"width:".$lwidth."; height:".$lheight.";\">".$label."</div>\n";
		echo "<div class=\"".$this->css."2\" style=\"width:".$vwidth."; height:".$vheight.";\">".$value."</div>\n";
	}
  
  function add4Cell( $label, $value, $label1 = "", $value1 = "", $lwidth = "20%",  $vwidth = "28%", $lheight = "auto", $vheight = "auto" ){
		echo "<div class=\"".$this->css."3\" style=\"width:".$lwidth."; height:".$lheight.";\">".$label."</div>\n";
		echo "<div class=\"".$this->css."4\" style=\"width:".$vwidth."; height:".$vheight.";\">".$value."</div>\n";
    echo "<div class=\"".$this->css."5\" style=\"width:".$lwidth."; height:".$lheight.";\">".$label1."</div>\n";
		echo "<div class=\"".$this->css."6\" style=\"width:".$vwidth."; height:".$vheight.";\">".$value1."</div>\n";    
	}

  function end(){
    echo "</div>";
  }

}

class simpleDiv{
	var $css = "";
	
	function simpleDiv( $id, $code = "" ){
		echo "<div id=\"".$id."\">".$code."\n";
	}
	
	function setCss( $styles ){
		$this->css = $styles;
	}
	
	function addCell( $class, $value = "", $id = "", $more = "" ){
		echo "<div class=\"".$class."\" ".($id==""?"":"id=\"".$id."\"")." >".$value." ".$more."</div>\n";
	}
	
	function add2Cell( $label, $value, $lmore = "", $vmore = "" ){
		echo "<div class=\"".$this->css."1\">".$label." ".$lmore."</div>\n";
		echo "<div class=\"".$this->css."2\">".$value." ".$vmore."</div>\n";
	}
	  
	function add4Cell( $label, $value, $label1 = "", $value1 = "" ){
		echo "<div class=\"".$this->css."3\">".$label."</div>\n";
		echo "<div class=\"".$this->css."4\">".$value."</div>\n";
		echo "<div class=\"".$this->css."5\">".$label1."</div>\n";
		echo "<div class=\"".$this->css."6\">".$value1."</div>\n";    
	}
	
	function add8Cell( $label, $value, $label1 = "", $value1 = "", $label2 = "", $value2 = ""/*, $label3 = "", $value3 = ""*/ ){
		echo "<div class=\"".$this->css."7\">".$label."</div>\n";
		echo "<div class=\"".$this->css."8\">".$value."</div>\n";
		echo "<div class=\"".$this->css."9\">".$label1."</div>\n";
		echo "<div class=\"".$this->css."10\">".$value1."</div>\n";
		echo "<div class=\"".$this->css."11\">".$label2."</div>\n";
		echo "<div class=\"".$this->css."12\">".$value2."</div>\n";
		/*echo "<div class=\"".$this->css."13\">".$label3."</div>\n";
		echo "<div class=\"".$this->css."14\">".$value3."</div>\n";*/    
	}
	
	function addCellLink( $class, $value, $lnk, $more = "" ){
		echo "<div class=\"".$class."\"><a href=\"".$lnk."\" ".$more.">".$value."</a></div>\n";
	}
	
	function addDiv( $class = "", $html ){
		echo "<div".($class==""?"":" class=\"".$class."\"").">".$html."</div>\n";
	}
  
	function end(){
		echo "</div>\n";
	}
}

/*------------------------------------------------------------*/
/* Clase para dibujar tablas
/* date: 05-08-09
/*------------------------------------------------------------*/
class simpleTable{
	var $code = "";
	var $nroColumns = 0;
	var $openTr = 0;
	
	function simpleTable( $class, $more = "" ){
		$this->code .= "\n<table class=\"".$class."\" ".$more." border=\"0\" cellspacing=\"1\" cellpadding=\"1\" >\n";
	}
	
	function setHead( $class, $vector ){
		$this->code .= "<tr class=\"".$class."\">\n\t";
		for( $i = 0, $n = count( $vector ); $i < $n; $i++ ){
			$this->code .= "<th>".$vector[$i]."</th> ";
		}
		$this->nroColumns = $n;
		$this->code .= "\n</tr>\n";
	}
	
	function addRow( $class = "", $more = "" ){
		if( $this->openTr ){
			$this->code .= "</tr>\n";
		}
		$this->code .= "<tr".($class==""?"":" class=\"".$class."\"")." ".($more==""?"":$more).">\n\t";
		$this->openTr = 1;
	}
	
	function addCell( $value, $more = "" ){
		$this->code .= "<td".($more==""?"":" ".$more." ").">".$value."</td>";
	}

	function addCellN( $value, $more = "" ){
		$this->code .= "<th".($more==""?"":" ".$more." ").">".$value."</th>";
	}
  
	function show(){
		if( $this->openTr == 1 ){
			$this->code .= "</tr>\n";
		}
		$this->code .= "</table>\n";
		return $this->code;
	}
}

/*------------------------------------------------------------*/
/* Clase para crear formularios
/* date: 05-08-09
/*------------------------------------------------------------*/
class simpleForm{
	
	function simpleForm( $action, $method = "post", $more = "" ){
		echo "<form id=\"miForm\" action=\"".$action."\" method=\"".$method."\" ".$more.">\n";
	}
	
	function addText( $name, $value = "", $size = 40, $more = "", $class="texto" ){
		return "<input type=\"text\" class=\"".$class."\" name=\"".$name."\" id=\"".$name."\" value=\"".$value."\" size=\"".$size."\" ".$more." autocomplete=\"off\"/>";
	}
	
  //onchange=\"conMayusculas(this)\"   -> convert to uppercase
  
	function addTextBox( $name, $id, $value = "", $size = 40, $more = "", $class="texto" ){
		return "<input type=\"text\" class=\"".$class."\" name=\"".$name."\" id=\"".$id."\" value=\"".$value."\" size=\"".$size."\" ".$more."/>";
	}
	
	function addLabel( $name, $value, $label = "", $more = "" ){
		if( $label == "" ){
			return $value."<input type=\"hidden\" name=\"".$name."\" id=\"".$name."\" value=\"".$value."\" ".$more."/>\n";
		}else{
			return $label."<input type=\"hidden\" name=\"".$name."\" id=\"".$name."\" value=\"".$value."\" ".$more."/>\n";
		}
	}
	
	function addHidden( $name, $value ){
		echo "<div><input type=\"hidden\" name=\"".$name."\" id=\"".$name."\" value=\"".$value."\" /></div>\n";
	}
	
	function addPassword( $name, $value = "", $size = 20, $more = "", $class="texto" ){
		return "<input type=\"password\" class=\"".$class."\" name=\"".$name."\" id=\"".$name."\" value=\"".$value."\" size=\"".$size."\" ".$more."/>";
	}
	
	function addTextarea( $name, $value = "", $size = 255, $more = "", $class="texto" ){
		$code = "<textarea rows=\"4\" class=\"".$class."\" cols=\"50\" name=\"".$name."\" id=\"".$name."\" onkeydown=\"textCounter(this.form.".$name.", this.form.size".$name.", ".$size.");\" onkeyup=\"textCounter(this.form.".$name.", this.form.size".$name.", ".$size.");\" ".$more.">".$value."</textarea>\n";
		$code .= "<input type=\"text\" class=\"".$class."\" name=\"size".$name."\" size=\"2\" maxlength=\"3\" value=\"".$size."\" readonly=\"readonly\" /> caracteres";
		return $code;
	}
	
	function addAreaText( $name, $value = "", $size = 255, $more = "", $class="texto" ){
		$code = "<textarea rows=\"3\" class=\"".$class."\" cols=\"40\" name=\"".$name."\" id=\"".$name."\" ".$more.">".$value."</textarea>\n";
		return $code;
	}
	
	function addTextDate( $name, $value = "", $more="", $i = 0, $hora = 0 ){
		$code = "<input type=\"text\" class=\"texto\" name=\"".$name."\" id=\"".$name."\" value=\"".$value."\" size=\"15\" ".$more." />\n";
		$code .= "<a href=\"#\" onclick=\"displayCalendar(document.forms[".$i."].".$name.",'dd/mm/yyyy',this)\"><img src=\"images/acc_calendar.png\" style=\"border: 0;\" alt=\"\"/></a>";		
		return $code;
	}

	function addTextDateExtend( $name, $value = "", $i = 0, $hora = 0, $more = "", $class="texto" ){
		$code = "<input type=\"text\" class=\"".$class."\" name=\"".$name."\" id=\"".$name."\" value=\"".$value."\" size=\"10\" ".$more."  onblur=\"esFechaValida(this);\"/>\n";
		$code .= "<a href=\"#\" onclick=\"displayCalendar(document.forms[".$i."].".$name.",'dd/mm/yyyy',this)\"><img src=\"images/acc_calendar.png\" border=\"0\" align=\"absbottom\" /></a>";
		return $code;
	}
	
	function addTextDateExtendBox( $name, $id, $value = "", $i = 0, $hora = 0, $more = "", $class="texto" ){
		$code = "<input type=\"text\" class=\"".$class."\" name=\"".$name."\" id=\"".$id."\" value=\"".$value."\" size=\"10\" ".$more." onblur=\"esFechaValida(this);\"/>\n";
		$code .= "<a href=\"#\" onClick=\"displayCalendar(document.forms[".$i."].".$id.",'dd/mm/yyyy',this)\"> <img src=\"images/acc_calendar.png\" border=\"0\" align=\"absbottom\"></a>";
		return $code;
	}

	function addSelect( $name, $opts, $value = "", $more = "" ){
		if( count($opts) >= 1 ){
			$code = "\n<select name=\"".$name."\" id=\"".$name."\" ".$more.">\n";
			for( $i=0, $n = count( $opts ); $i<$n; $i++ ){
				if( $opts[$i][0] == $value ){
					$code .= "\t<option value=\"".$opts[$i][0]."\" selected=\"selected\">".$opts[$i][1]."</option>\n";
				}else{
					$code .= "\t<option value=\"".$opts[$i][0]."\">".$opts[$i][1]."</option>\n";
				}
			}
			$code .= "</select>\n";	
		}else{
			$code = "No existen opciones";
		}
		return $code;
	}
	
	function addSelectBox( $name, $id, $opts, $value = "", $more = "" ){
		if( count($opts) >= 1 ){
			$code = "\n<select name=\"".$name."\" id=\"".$id."\" ".$more.">\n";
			for( $i=0, $n = count( $opts ); $i<$n; $i++ ){
				if( $opts[$i][0] == $value ){
					$code .= "\t<option value=\"".$opts[$i][0]."\" selected=\"selected\">".$opts[$i][1]."</option>\n";
				}else{
					$code .= "\t<option value=\"".$opts[$i][0]."\">".$opts[$i][1]."</option>\n";
				}
			}
			$code .= "</select>\n";	
		}else{
			$code = "No existen opciones";
		}
		return $code;
	}
	
	function addRadio( $name, $display, $checked = 0, $more="" ){
		return "<label><input type=\"radio\" name=\"".$name."\" ".($checked==0?"":"checked=\"checked\"")." ".$more."/>".$display."</label>";
	}
	
  function addUploadFile($name, $value = "", $size = 20){
		global $_CONF;
		if($value!=""){
			$code = "<a href=\"".$_CONF['http_files']."/".$value."\" />Descargar</a>";
		}else{
			$code = "<input name=\"".$name."\" id=\"".$name."\" size=\"".$size."\" type=\"file\" />";
		}
		return $code;
	}
	
	function addRadioYesNo( $name, $check = 0 ){
		if( $check == 0 ){
			$code = "<input type=\"radio\" name=\"".$name."\" value=\"1\" /> Si";
			$code .= "<input type=\"radio\" name=\"".$name."\" value=\"0\" checked=\"checked\" /> No";
		}else{
			$code = "<input type=\"radio\" name=\"".$name."\" value=\"1\" checked=\"checked\" /> Si";
			$code .= "<input type=\"radio\" name=\"".$name."\" value=\"0\" /> No";
		}
		return $code;
	}
	
	function addRadioSexo( $name, $check = 0 ){
		if( $check == 0 ){
			$code = "<input type=\"radio\" name=\"".$name."\" value=\"1\" /> Masculino ";
			$code .= "<input type=\"radio\" name=\"".$name."\" value=\"0\" checked=\"checked\" /> Femenino";
		}else{
			$code = "<input type=\"radio\" name=\"".$name."\" value=\"1\" checked=\"checked\" /> Masculino";
			$code .= "<input type=\"radio\" name=\"".$name."\" value=\"0\" /> Femenino";
		}
		return $code;
	}
	
	function addCheckbox( $name, $value, $display, $checked = 0, $more="" ){
		return "<input type=\"checkbox\" name=\"".$name."\" id=\"".$name."\" value=\"".$value."\" ".($checked==0?"":"checked=checked")." ".$more." />&nbsp;".$display;
	}

	function closeForm(){
		echo "</form>\n";
	}
}

/*------------------------------------------------------------*/
/* Other Functions
/* date: 05-08-09
/*------------------------------------------------------------*/
function simpleSelect( $name, $opts, $value = "", $more = "" ){
  if( count($opts) >= 1 ){
    $code = "\n<select name=\"".$name."\" id=\"".$name."\" ".$more.">\n";
    for( $i=0, $n = count( $opts ); $i<$n; $i++ ){
      if( $opts[$i][0] == $value ){
        $code .= "\t<option value=\"".$opts[$i][0]."\" selected=\"selected\">".specialChars( $opts[$i][1] )."</option>\n";
      }else{
        $code .= "\t<option value=\"".$opts[$i][0]."\">".specialChars( $opts[$i][1] )."</option>\n";
      }
    }
    $code .= "</select>\n";	
  }else{
    $code = "No existen opciones";
  }
  return $code;
}

function simpleComboBox( $name, $opts, $value = "", $more = "" ){
	if( count($opts) >= 1 ){
		$code = "\n<select name=\"".$name."\" id=\"".$name."\" ".$more.">\n";
		$code .= "\t<option value=\"0\" selected=\"selected\">Seleccionar</option>\n";
		for( $i=0, $n = count( $opts ); $i<$n; $i++ ){
			if( $opts[$i][0] == $value ){
				$code .= "\t<option value=\"".$opts[$i][0]."\" selected=\"selected\">".specialChars($opts[$i][1])."</option>\n";
			}else{
				$code .= "\t<option value=\"".$opts[$i][0]."\">".specialChars($opts[$i][1])."</option>\n";
			}
		}
		$code .= "</select>\n";	
	}else{
		$code = "No existen opciones";
	}
	return $code;
}

function simpleText( $name, $value = "", $size = 40, $more = "", $class="texto" ){
	return "<input type=\"text\" class=\"".$class."\" name=\"".$name."\" id=\"".$name."\" value=\"".$value."\" size=\"".$size."\" ".$more." autocomplete=\"off\"/>";
}

function simpleTextareaPlan( $name, $value = "", $size = 8000, $more = "", $class="texto" ){
	$code = "<textarea rows=\"2\" class=\"".$class."\" cols=\"40\" name=\"".$name."\" id=\"".$name."\" onkeydown=\"textCounter(this.form.".$name.", this.form.size".$name.", ".$size.");\" onkeyup=\"textCounter(this.form.".$name.", this.form.size".$name.", ".$size.");\" ".$more.">".$value."</textarea>\n";
	//$code .= "<input type=\"text\" class=\"".$class."\" name=\"size".$name."\" size=\"2\" maxlength=\"3\" value=\"".$size."\" readonly=\"readonly\" /> caracteres";
	return $code;
}

function simpleTextarea( $name, $value = "", $size = 255, $more = "", $class="texto" ){
	$code = "<textarea rows=\"2\" class=\"".$class."\" cols=\"40\" name=\"".$name."\" id=\"".$name."\" onkeydown=\"textCounter(this.form.".$name.", this.form.size".$name.", ".$size.");\" onkeyup=\"textCounter(this.form.".$name.", this.form.size".$name.", ".$size.");\" ".$more.">".$value."</textarea>\n";
	//$code .= "<input type=\"text\" class=\"".$class."\" name=\"size".$name."\" size=\"2\" maxlength=\"3\" value=\"".$size."\" readonly=\"readonly\" /> caracteres";
	return $code;
}

function simpleTextareaCount( $name, $value = "", $size = 255, $more = "", $class="texto" ){
  $code = "<textarea rows=\"4\" class=\"".$class."\" cols=\"30\" name=\"".$name."\" id=\"".$name."\" onkeydown=\"textCounter(this.form.".$name.", this.form.size".$name.", ".$size.");\" onkeyup=\"textCounter(this.form.".$name.", this.form.size".$name.", ".$size.");\" ".$more.">".$value."</textarea>\n";
  $code .= "<input type=\"text\" class=\"".$class."\" name=\"size".$name."\" size=\"2\" maxlength=\"3\" value=\"".$size."\" readonly=\"readonly\" /> caracteres";
  return $code;
}

function simpleTextConstancia( $name, $value = "", $size = 800, $more = "", $class="texto" ){
  $code = "<textarea rows=\"4\" class=\"".$class."\" cols=\"90\" name=\"".$name."\" id=\"".$name."\" onkeydown=\"textCounter(this.form.".$name.", this.form.size".$name.", ".$size.");\" onkeyup=\"textCounter(this.form.".$name.", this.form.size".$name.", ".$size.");\" ".$more.">".$value."</textarea>\n";
  $code .= "<input type=\"text\" class=\"".$class."\" name=\"size".$name."\" size=\"2\" maxlength=\"3\" value=\"".$size."\" readonly=\"readonly\" /> caracteres";
  return $code;
}

function addHidden( $name, $value ){
	echo "<div><input type=\"hidden\" name=\"".$name."\" id=\"".$name."\" value=\"".$value."\" /></div>\n";
}

function simpleHidden( $name, $value ){
	return "<div><input type=\"hidden\" name=\"".$name."\" id=\"".$name."\" value=\"".$value."\" /></div>\n";
}

function simpleRadioYesNo( $name, $check = 0 ){
  if( $check == 0 ){
    $code = "<input type=\"radio\" name=\"".$name."\" value=\"1\" /> Si &nbsp;&nbsp;";
    $code .= "<input type=\"radio\" name=\"".$name."\" value=\"0\" checked=\"checked\" /> No";
  }else{
    $code = "<input type=\"radio\" name=\"".$name."\" value=\"1\" checked=\"checked\" /> Si &nbsp;&nbsp;";
    $code .= "<input type=\"radio\" name=\"".$name."\" value=\"0\" /> No";
  }
  return $code;
}

function simpleRadioSexo( $name, $check = 0 ){
	if( $check == 0 ){
		$code = "<input type=\"radio\" name=\"".$name."\" value=\"1\" /> Masculino ";
		$code .= "<input type=\"radio\" name=\"".$name."\" value=\"0\" checked=\"checked\" /> Femenino";
	}else{
		$code = "<input type=\"radio\" name=\"".$name."\" value=\"1\" checked=\"checked\" /> Masculino";
		$code .= "<input type=\"radio\" name=\"".$name."\" value=\"0\" /> Femenino";
	}
	return $code;
}

function simpleRadioJs( $name, $check = 0, $moreSi="", $moreNo="" ){
  if( $check == 0 ){
    $code = "<input type=\"radio\" id=\"".$name."_si\" name=\"".$name."\" value=\"1\" ".$moreSi." /> Si &nbsp;&nbsp;";
    $code .= "<input type=\"radio\" id=\"".$name."_no\" name=\"".$name."\" value=\"0\" ".$moreNo." checked=\"checked\" /> No";
  }else{
    $code = "<input type=\"radio\" id=\"".$name."_si\" name=\"".$name."\" value=\"1\" ".$moreSi." checked=\"checked\" /> Si &nbsp;&nbsp;";
    $code .= "<input type=\"radio\" id=\"".$name."_no\" name=\"".$name."\" value=\"0\" ".$moreNo." /> No";
  }
  return $code;
}

function simpleRadioECI( $name, $check = 0, $moreE="", $moreC="", $moreI="" ){
    $code = "<input type=\"radio\" id=\"".$name."_e\" name=\"".$name."\" value=\"1\" ".$moreE." /> Exoneraci&oacute;n &nbsp;&nbsp;";
    $code .= "<input type=\"radio\" id=\"".$name."_c\" name=\"".$name."\" value=\"2\" ".$moreC." /> Compensaci&oacute;n &nbsp;&nbsp;";
	$code .= "<input type=\"radio\" id=\"".$name."_i\" name=\"".$name."\" value=\"3\" ".$moreI." /> Inafectaci&oacute;n";
  
  return $code;
}

function simpleRadioTipoCNA( $name, $item1, $item2, $check = 0, $more="" ){
    $code = "<input type=\"radio\" id=\"".$name."_p\" name=\"".$name."\" value=\"1\" ".$more." checked=\"checked\"/> ".$item1." &nbsp;&nbsp;";
    $code .= "<input type=\"radio\" id=\"".$name."_a\" name=\"".$name."\" value=\"2\" ".$more." /> ".$item2." &nbsp;&nbsp;";
	return $code;
}

function simpleRadioDevengados( $name, $check = 0, $more="" ){
    $code = "<input type=\"radio\" id=\"".$name."_a\" name=\"".$name."\" value=\"1\" ".$more." checked=\"checked\"/> Administrativo &nbsp;&nbsp;";
    $code .= "<input type=\"radio\" id=\"".$name."_o\" name=\"".$name."\" value=\"2\" ".$more." /> Obreros &nbsp;&nbsp;";
	return $code;
}

function simpleCheck( $name, $value, $display, $checked = 0, $more="" ){
	return "<input type=\"checkbox\" name=\"".$name."\" id=\"".$name."\" value=\"".$value."\" ".($checked==0?"":"checked=checked")." ".$more." />&nbsp;".$display;
}

function simpleCheckbox( $name, $id, $value, $display, $checked = 0, $more="" ){
	return "<input type=\"checkbox\" name=\"".$name."\" id=\"".$id."\" value=\"".$value."\" ".($checked==0?"":"checked=\"checked\"")." ".$more." />&nbsp;".$display;
}

function simpleTextDate( $name, $value = "", $more="", $i = 0, $hora = 0 ){
	$code = "<input type=\"text\" class=\"texto\" name=\"".$name."\" id=\"".$name."\" value=\"".$value."\" size=\"15\" ".$more." />\n";
	$code .= "<a href=\"#\" onclick=\"displayCalendar(document.forms[".$i."].".$name.",'dd/mm/yyyy',this)\"><img src=\"images/acc_calendar.png\" style=\"border: 0;\" alt=\"\"/></a>";		
	return $code;
}

function dateCalendar( $name, $value = "", $more = "", $class="texto" ){
	$code = "<input type=\"text\" class=\"".$class."\" name=\"".$name."\" id=\"".$name."\" value=\"".$value."\" size=\"10\" ".$more." onblur=\"esFechaValida(this);\"/>\n";
	$code .= "<a href=\"#\" onClick=\"displayCalendar(document.forms[".$i."].".$id.",'dd/mm/yyyy',this)\"> <img src=\"images/acc_calendar.png\" border=\"0\" align=\"absbottom\"></a>";
	return $code;
}

function simpleUploadFile($name, $size = 20){ 
  $code = "<input name=\"".$name."\" id=\"".$name."\" size=\"".$size."\" type=\"file\" />";
  return $code;
}

function simpleDownloadFile( $value ){
  global $_CONF;
  $code = "<a  href=\"".$_CONF['http_files']."".$value."\"><img src=\"images/icons/download.png\" alt=\"\"> [Descargar]</a>";
  return $code;
}

function _printDay( $day ){
  switch( $day ){
    case '1':
    case '01': return "Domingo"; break;
    case '2':
    case '02': return "Lunes"; break;
    case '3':
    case '03': return "Martes"; break;
    case '4':
    case '04': return "Miercoles"; break;
    case '5':
    case '05': return "Jueves"; break;
    case '6':
    case '06': return "Viernes"; break;
    case '7':
    case '07': return "Sabado"; break;    
    default: return "";
  }
}

function _printMonth( $month, $abrev= 0 ){
  switch( $month ){
    case 1: return $abrev==1?"ENE":"Enero"; break;
    case 2: return $abrev==1?"FEB":"Febrero"; break;
    case 3: return $abrev==1?"MAR":"Marzo"; break;
    case 4: return $abrev==1?"ABR":"Abril"; break;
    case 5: return $abrev==1?"MAY":"Mayo"; break;
    case 6: return $abrev==1?"JUN":"Junio"; break;
    case 7: return $abrev==1?"JUL":"Julio"; break;
    case 8: return $abrev==1?"AGO":"Agosto"; break;
    case 9: return $abrev==1?"SEP":"Septiembre"; break;
    case 10: return $abrev==1?"OCT":"Octubre"; break;
    case 11: return $abrev==1?"NOV":"Noviembre"; break;
    case 12: return $abrev==1?"DIC":"Diciembre"; break;
    default: return "";
  }
}

function getMonth( $m=1, $s="D" ){    
  $month=array();
  $month[0][0] = "01";
  $month[0][1] = "Enero";
  $month[1][0] = "02";
  $month[1][1] = "Febrero";
  $month[2][0] = "03";
  $month[2][1] = "Marzo";
  $month[3][0] = "04";
  $month[3][1] = "Abril";
  $month[4][0] = "05";
  $month[4][1] = "Mayo";
  $month[5][0] = "06";
  $month[5][1] = "Junio";
  $month[6][0] = "07";
  $month[6][1] = "Julio";
  $month[7][0] = "08";
  $month[7][1] = "Agosto";
  $month[8][0] = "09";
  $month[8][1] = "Septiembre";
  $month[9][0] = "10";
  $month[9][1] = "Octubre";
  $month[10][0] = "11";
  $month[10][1] = "Noviembre";
  $month[11][0] = "12";
  $month[11][1] = "Diciembre";  
  if( $s == "D"){  
    $inicio = $m-1;
    $total  = (12-$m);
  }else{
    $inicio = 0;
    $total  = $m-1;
  }  
  $rmonth = array(); $j=0;
  for( $i = $inicio; $i <= ($total+$inicio); $i++ ){    
    $rmonth[$j][0] = $month[$i][0];
    $rmonth[$j][1] = $month[$i][1];    
    $j++;
  }    
  return $rmonth;
}

function getMonthSelect( $m=1, $s="D" ){    
	$month=array();
	$month[0][0] = "0";
	$month[0][1] = "Mes";
	$month[1][0] = "1";
	$month[1][1] = "Enero";
	$month[2][0] = "2";
	$month[2][1] = "Febrero";
	$month[3][0] = "3";
	$month[3][1] = "Marzo";
	$month[4][0] = "4";
	$month[4][1] = "Abril";
	$month[5][0] = "5";
	$month[5][1] = "Mayo";
	$month[6][0] = "6";
	$month[6][1] = "Junio";
	$month[7][0] = "7";
	$month[7][1] = "Julio";
	$month[8][0] = "8";
	$month[8][1] = "Agosto";
	$month[9][0] = "9";
	$month[9][1] = "Septiembre";
	$month[10][0] = "10";
	$month[10][1] = "Octubre";
	$month[11][0] = "11";
	$month[11][1] = "Noviembre";
	$month[12][0] = "12";
	$month[12][1] = "Diciembre";  
	if( $s == "D"){  
		$inicio = $m-1;
		$total  = (13-$m);
	}else{
		$inicio = 0;
		$total  = $m-1;
	}  
	$rmonth = array(); $j=0;
	for( $i = $inicio; $i <= ($total+$inicio); $i++ ){    
		$rmonth[$j][0] = $month[$i][0];
		$rmonth[$j][1] = $month[$i][1];    
		$j++;
	}    
	return $rmonth;
}

function getYears( $nro = "5" ){
  $year = array(); 
  $anio = date('Y');
  for( $i =0; $i<$nro; $i++ ){
    $year[$i][0] = $anio-$i;
    $year[$i][1] = $anio-$i;
  } 
  return $year;
}

function getYearsSelect( $nro = "5" ){
	$year = array(); 
	$year[0][0] = "0";
	$year[0][1] = "A&ntilde;o";
	$anio = date('Y');
	for( $i =1; $i<$nro; $i++ ){
		$year[$i][0] = $anio-$i+1;
		$year[$i][1] = $anio-$i+1;
	} 
	return $year;
}

function getYearsRange( $inicio, $fin ){
	$year = array(); 
	if( $inicio < 0 || $fin < 0 || $fin < $inicio ) return $year;
  $anio = $fin;
	for( $i =0, $nro = ($fin-$inicio); $i<=$nro; $i++ ){
    $year[$i][0] = $anio-$i;
    $year[$i][1] = $anio-$i;
  } 
  return $year;
}

function Year($inicio){
	$lista = array();
	$ulanio = date("Y");
	$j=0;
	for ($i=$inicio; $i<=$ulanio; $i++) {
		$lista[$j][0] = $i;		
		$lista[$j][1] = $i;
		$j++;
	}
	return $lista;
}

function _printValue( $value, $decimal="2" ){   
  if( $value == "" ) return "&nbsp;"; 
  if( $value == 0 ) return "&nbsp;";
  return number_format( $value, $decimal, ".", "" );
}

function _printFormat( $value, $decimal="2" ){   
  return number_format( $value, $decimal, ".", "" );
}

function getIP(){
  if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"),"unknown"))
    $ip = getenv("HTTP_CLIENT_IP");
  else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
    $ip = getenv("HTTP_X_FORWARDED_FOR");
  else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
    $ip = getenv("REMOTE_ADDR");
  else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
    $ip = $_SERVER['REMOTE_ADDR'];
  else
    $ip = "unknown";
  return($ip);
}

function charsJs( $cadena ){
  $cadena = str_replace("Ã±","ñ", $cadena );
  $cadena = str_replace("\'","''", $cadena );
  return $cadena;
}

function specialChars($cadena){
  $caracteres = array("Ñ", "Á", "É", "Í", "Ó", "Ú", "Ü", "ñ", "á", "é", "í", "ó", "ú", "ü", "º");
  $reemplazo = array("&Ntilde;", "&Aacute;", "&Eacute;", "&Iacute;", "&Oacute;", "&Uacute;", "&Uuml;", "&ntilde;", "&aacute;", "&eacute;", "&iacute;", "&oacute;", "&uacute;", "&uuml;", "&ordm;");
  for($j=0;$j<count($caracteres);$j++){
    $sw = 0;
    do{
      $pos_n = strpos($cadena, $caracteres[$j]);
      if($pos_n === false){
        $sw = 1;
      }else{
        $cadena = substr_replace($cadena,$reemplazo[$j],$pos_n,1);
      }
    }while($sw==0);
  }
  return $cadena;
}

function specapeChars($cadena){
  $caracteres = array("'");
  $reemplazo = array("''");
  for($j=0;$j<count($caracteres);$j++){
    $sw = 0;
    do{
      $pos_n = strpos($cadena, $caracteres[$j]);
      if($pos_n === false){
        $sw = 1;
      }else{
        $cadena = substr_replace($cadena,$reemplazo[$j],$pos_n,1);
      }
    }while($sw==0);
  }
  return $cadena;
}


?>
