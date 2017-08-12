<?php

function __autoload($class_name) {
    if (file_exists("classes/" . $class_name . ".class.php")) {
        require_once "classes/" . $class_name . ".class.php";
    }
}

/**
 * Initialise GZIP
 */
function initGzip() {
    global $mosConfig_gzip;
    $do_gzip_compress = FALSE;
    if ($mosConfig_gzip == 1) {
        $phpver = phpversion();
        $useragent = mosGetParam($_SERVER, 'HTTP_USER_AGENT', '');
        $canZip = mosGetParam($_SERVER, 'HTTP_ACCEPT_ENCODING', '');

        if ($phpver >= '4.0.4pl1' && ( strstr($useragent, 'compatible') || strstr($useragent, 'Gecko') )) {
            if (extension_loaded('zlib')) {
                ob_start('ob_gzhandler');
                return;
            }
        } else if ($phpver > '4.0') {
            if ($canZip == 'gzip') {
                if (extension_loaded('zlib')) {
                    $do_gzip_compress = TRUE;
                    ob_start();
                    ob_implicit_flush(0);
                    header('Content-Encoding: gzip');
                    return;
                }
            }
        }
    }
    ob_start();
}

/**
 * Perform GZIP
 */
function fecha_ves($nombre, $valor = "", $extra = "") {

    $fecha_hoy = date("d/m/Y");

    $mm = "<input type=\"text\" value=\"$valor\" name=\"$nombre\" size=\"10\" onblur=\"esFechaValida(this);\"  $extra/>\n";

    return $mm;
}

function doGzip() {
    global $do_gzip_compress;
    if ($do_gzip_compress) {
        /**
         * Borrowed from php.net!
         */
        $gzip_contents = ob_get_contents();
        ob_end_clean();

        $gzip_size = strlen($gzip_contents);
        $gzip_crc = crc32($gzip_contents);

        $gzip_contents = gzcompress($gzip_contents, 9);
        $gzip_contents = substr($gzip_contents, 0, strlen($gzip_contents) - 4);

        echo "\x1f\x8b\x08\x00\x00\x00\x00\x00";
        echo $gzip_contents;
        echo pack('V', $gzip_crc);
        echo pack('V', $gzip_size);
    } else {
        ob_end_flush();
    }
}

/**
 * Utility function to return a value from a named array or a specified default
 */
define("_MOS_NOTRIM", 0x0001);
define("_MOS_ALLOWHTML", 0x0002);

function _GetParam(&$arr, $name, $def = null, $mask = 0) {
    $return = null;
    if (isset($arr[$name])) {
        if (is_string($arr[$name])) {
            if (!($mask & _MOS_NOTRIM)) {
                $arr[$name] = trim($arr[$name]);
            }
            if (!($mask & _MOS_ALLOWHTML)) {
                $arr[$name] = strip_tags($arr[$name]);
            }
            if (!get_magic_quotes_gpc()) {
                $arr[$name] = addslashes($arr[$name]);
            }
        }
        return $arr[$name];
    } else {
        return $def;
    }
}

/**
 * Copy the named array content into the object as properties
 * only existing properties of object are filled. when undefined in hash, properties wont be deleted
 * @param array the input array
 * @param obj byref the object to fill of any class
 * @param string
 * @param boolean
 */
function mosBindArrayToObject($array, &$obj, $ignore = '', $prefix = NULL, $checkSlashes = true) {
    if (!is_array($array) || !is_object($obj)) {
        return (false);
    }
    foreach (get_object_vars($obj) as $k => $v) {
        if (substr($k, 0, 1) != '_') {   // internal attributes of an object are ignored
            if (strpos($ignore, $k) === false) {
                if ($prefix) {
                    $ak = $prefix . $k;
                } else {
                    $ak = $k;
                }
                if (isset($array[$ak])) {
                    $obj->$k = ($checkSlashes && get_magic_quotes_gpc()) ? mosStripslashes($array[$k]) : $array[$k];
                }
            }
        }
    }

    return true;
}

/**
 * Strip slashes from strings or arrays of strings
 * @param value the input string or array
 */
function mosStripslashes(&$value) {
    $ret = '';
    if (is_string($value)) {
        $ret = stripslashes($value);
    } else {
        if (is_array($value)) {
            $ret = array();
            while (list($key, $val) = each($value)) {
                $ret[$key] = mosStripslashes($val);
            } // while
        } else {
            $ret = $value;
        } // if
    } // if
    return $ret;
}

function jsAlert($msg, $path = "") {
    echo "<script type=\"text/javascript\">alert('" . $msg . "'); document.location.href='" . $path . "';</script>";
    exit();
}

function jsAlertMsg($msg) {
    echo "<script type=\"text/javascript\">alert('" . $msg . "');</script>";
}

function jsGoto($path) {
    echo "<script type=\"text/javascript\">document.location.href='" . $path . "';</script>";
    exit();
}

function jsConfirm($msg, $jsNext, $jsBack) {
    echo "<script type=\"text/javascript\"> if( confirm('" . $msg . "') ){" . $jsNext . ";}else{" . $jsBack . ";} </script>";
    exit();
}

function jsAlertGo($msg, $jsGo) {
    echo "<script type=\"text/javascript\"> alert('" . $msg . "'); " . $jsGo . "; </script>";
    exit();
}

function jsGo($jsGo) {
    echo "<script type=\"text/javascript\"> " . $jsGo . "; </script>";
    exit();
}

function tr10($d1, $d2 = "", $d3 = "", $d4 = "", $d5 = "", $d6 = "", $d7 = "", $d8 = "", $d9 = "", $d10 = "") {
    echo "<tr>
			<td>$d1</td>
			<td>$d2</td>
			<td>$d3</td>
			<td>$d4</td>
			<td>$d5</td>
			<td>$d6</td>
			<td>$d7</td>
			<td>$d8</td>
			<td>$d9</td>
			<td>$d10</td>
		</tr>";
}

////

function tr2($d1, $d2) {
    echo "<tr>
		<td>$d1</td>
		<td>$d2</td>
	</tr>";
}

function tr3($d1, $d2, $d3 = "") {
    echo "<tr>
		<td>$d1</td>
		<td>$d2</td>
		<td>$d3</td>
	</tr>";
}

function tr4($d1, $d2 = "", $d3 = "", $d4 = "") {
    echo "<tr>
			<td>$d1</td>
			<td>$d2</td>
			<td>$d3</td>
			<td>$d4</td>
		</tr>";
}

function tr5($d1, $d2 = "", $d3 = "", $d4 = "", $d5 = "") {
    echo "<tr>
			<td>$d1</td>
			<td>$d2</td>
			<td>$d3</td>
			<td>$d4</td>
			<td>$d5</td>
		</tr>";
}

function tr6($d1, $d2 = "", $d3 = "", $d4 = "", $d5 = "", $d6 = "") {
    echo "<tr>
			<td>$d1</td>
			<td>$d2</td>
			<td>$d3</td>
			<td>$d4</td>
			<td>$d5</td>
			<td>$d6</td>
		</tr>";
}

function tr8($d1, $d2 = "", $d3 = "", $d4 = "", $d5 = "", $d6 = "", $d7 = "", $d8 = "") {
    echo "<tr>
			<td>$d1</td>
			<td>$d2</td>
			<td>$d3</td>
			<td>$d4</td>
			<td>$d5</td>
			<td>$d6</td>
			<td>$d7</td>
			<td>$d8</td>
		</tr>";
}

function input_text($nombre, $valor = "", $tamaño = "", $espace = "", $readonly = false, $requerido = false, $mayu = false, $numero = false, $decimal = false, $disable = false) {
    $ro = ($readonly) ? " readonly=\"readonly\" " : "";
    $cl = ($requerido) ? " jsrequired " : "";
    $ros = ($disable) ? "disabled=\"disabled\" " : "";
    $may = ($mayu) ? " onchange=\"javascript:this.value=this.value.toUpperCase();\" " : "";
    $num = ($numero) ? " onkeypress=\"return soloNumeros(event);\" " : "";
    $num2 = ($decimal) ? " onkeypress=\"return soloNumerosDecimal(event);\" " : "";
    echo "<input type=\"text\" value=\"$valor\" $ro name=\"$nombre\" class=\"$cl\" size=\"$tamaño\" maxlength=\"$espace\" $may  $num $num2 $ros/>\n";
}

function inpu_text($nombre, $valor = "", $tamaño = "", $more = "") {

    $ro = ($readonly) ? " readonly=\"readonly\" " : "";
    $cl = ($requerido) ? " jsrequired " : "";
    $ros = ($disable) ? "disabled=\"disabled\" " : "";
    $may = ($mayu) ? " onchange=\"javascript:this.value=this.value.toUpperCase();\" " : "";
    $num = ($numero) ? " onkeypress=\"return soloNumeros(event);\" " : "";
    $num2 = ($decimal) ? " onkeypress=\"return soloNumerosDecimal(event);\" " : "";

    $v = "<input type=\"text\" value=\"$valor\" $ro name=\"$nombre\"  size=\"$tamaño\" $more/>\n";

    return $v;
}

function input_subm($nombre, $valor = "") {

    $vv = "<input name=\"$nombre\" type=\"submit\" class=\"botones\" value=\"$valor\" />\n";
    return $vv;
}

function frm_radio($nombre, $valor, $extra = "") {
    return "<input type=\"radio\" name=\"$nombre\" value=\"$valor\"  $extra/>";
}

function frm_checkbox($nombre, $valor, $extra = "") {
    return "<input type=\"checkbox\" name=\"$nombre\" value=\"$valor\"  $extra/>";
}

function input_anio($nombre, $valor = "", $tamaño = "", $espace = "", $readonly = false, $requerido = false, $numero = false) {

    $fecha_hoy = date("d-m-Y");
    list($dia_hoy, $mes_hoy, $anio_hoy) = split("[/.-]", $fecha_hoy);

    $ro = ($readonly) ? " READONLY " : "";
    $cl = ($requerido) ? " jsrequired " : "";

    echo "<input type=\"text\" value=\"$anio_hoy\" $ro name=\"$nombre\" class=\"$cl\" size=\"$tamaño\" maxlength='4'   onkeypress=\"return soloNumeros(event);\" />\n";
}

function input_submit($nombre, $valor = "") {

    echo "<input name=\"$nombre\" type=\"submit\" class=\"botones\" value=\"$valor\" />\n";
}

function input_file($nombre, $valor = "", $more = "") {

    $v = "<input type=\"file\" name=\"$nombre\" size=\"$valor\" class=\"$more\" />\n";
    return $v;
}

function input_boton($nombre, $valor = "", $more = "") {

    $v = "<input name=\"$nombre\" type=\"button\" class=\"botones\" value=\"$valor\" $more />\n";
    return $v;
}

function input_text_may($nombre, $valor = "", $tamaño = "", $espace = "", $readonly = false) {
    $ro = ($readonly) ? " READONLY " : "";
    return "<input type=\"text\" value=\"$valor\" $ro name=\"$nombre\" class=\"inputbox\" size=\"$tamaño\" maxlength=\"$espace\" onchange=\"aMayusculas(this)\"/>";
}

function input_textarea($nombre, $valor = "", $columnas = "", $filas = "", $otros = "") {
    return "<textarea name=\"$nombre\" cols=\"$columnas\" rows=\"$filas\" class=\"inputbox\"onchange=\"javascript:this.value=this.value.toUpperCase();\" $otros >$valor</textarea> ";
}

function input_hidden($nombre, $valor = "") {
    $ro = ($readonly) ? " readonly " : "";
    return "<input type=\"hidden\" value=\"$valor\" $ro name=\"$nombre\"/>";
}

function input_horatxt($nombre, $valor = "", $tamaño = "", $readonly = false) {
    $ro = ($readonly) ? " READONLY " : "";
    return "<input type=\"text\" name=\"$nombre\" size=\"$tamaño\" onFocus=\"window.document.form_reloj.reloj.blur()\"/>";
}

function check_text($nombre, $val, $checked = 0) {
    $ck = ($checked) == 1 ? " checked " : "";
    echo "<input type=\"checkbox\" class =\"inputbox\" name=\"$nombre\" border=\"0\" value=\"$val\"$ck/>";
}

function check_texte($nombre, $val, $checked = 0) {
    $ck = ($checked) == 1 ? " checked=\"checked\" " : "";
    return "<input type=\"checkbox\" class =\"inputbox\" name=\"$nombre\"  value=\"$val\"$ck />";
}

function frm_password($nombre, $valor) {
    return "<input type=\"password\" class =\"inputbox\" value=\"$valor\" name=\"$nombre\" style=\"background-color:#ffffdf; border: 1px solid #000000\"/>";
}

function frm_select($nombre, $arr, $default = '', $extra_tag = '') {
    $tmp = "<select name='$nombre' class='inputbox' $extra_tag >";
    $items = count($arr);
    if ($items != count($arr))
        return $tmp . "<option>ERR! en el array de valores</select>";
    $tmp .= "<option value=''> Seleccionar </option>";

    for ($i = 0; $i < $items; $i++) {
        $sel = 'selected="selected"';
        $val = $arr[$i]->valor;
        if (is_array($default)) {
            if (!in_array(strtolower($val), array_lower($default)))
                $sel = '';
        }else {
            if (!eregi($val, $default))
                $sel = '';
        }
        $tmp .= "<option value='$val' $sel>" . $arr[$i]->texto . "</option>";
    }
    return $tmp . '</select>';
}

function frm_select_nop($nombre, $arr, $default = '', $extra_tag = '') {
    $tmp = "<select name='$nombre' class='inputbox' $extra_tag >";
    $items = count($arr);
    if ($items != count($arr))
        return $tmp . "<option>ERR! en el array de valores</select>";
    for ($i = 0; $i < $items; $i++) {
        $sel = 'selected="selected"';
        $val = $arr[$i]->valor;
        if (is_array($default)) {
            if (!in_array(strtolower($val), array_lower($default)))
                $sel = '';
        }else {
            if (!eregi($val, $default))
                $sel = '';
        }
        $tmp .= "<option value='$val' $sel>" . $arr[$i]->texto . "</option>";
    }
    return $tmp . '</select>';
}

function fecha_hoy($nombre) {

    $fecha_hoy = date("d/m/Y");

    echo "<input type=\"text\" value=\"$fecha_hoy\" name=\"$nombre\" size=\"10\" onblur=\"esFechaValida(this);\"/>
    <img src=\"images/acc_calendar.png\" alt=\"Fecha\" onclick=\"displayCalendar(document.forms[0]." . $nombre . ",'dd/mm/yyyy',this)\"/>\n";
}

function fecha_hoyy($nombre) {

    $fecha_hoy = date("d/m/Y");

    $v = "<input type=\"text\" value=\"$fecha_hoy\" name=\"$nombre\" size=\"10\" onblur=\"esFechaValida(this);\"/>
    <img src=\"images/acc_calendar.png\" alt=\"Fecha\" onclick=\"displayCalendar(document.forms[0]." . $nombre . ",'dd/mm/yyyy',this)\"/>\n";

    return $v;
}

function fecha_v($nombre, $valor = "") {

    $fecha_hoy = date("d/m/Y");

    echo "<input type=\"text\" value=\"$valor\" name=\"$nombre\" size=\"10\" onblur=\"esFechaValida(this);\">
    <img src=\"images/acc_calendar.png\" onclick=\"displayCalendar(document.forms[0]." . $nombre . ",'dd/mm/yyyy',this)\">\n";
}

function fecha_ve($nombre, $valor = "", $extra = "") {

    $fecha_hoy = date("d/m/Y");

    $mm = "<input type=\"text\" value=\"$valor\" name=\"$nombre\" size=\"10\" onblur=\"esFechaValida(this);\" $extra/>
    <img src=\"images/acc_calendar.png\" alt=\"\" onclick=\"displayCalendar(document.forms[0]." . $nombre . ",'dd/mm/yyyy',this)\"/>\n";

    return $mm;
}

function fecha_fuer($nombre, $valor = "", $extra = "") {

    $fecha_hoy = date("d/m/Y");

    $mm = "<input type=\"text\" value=\"$valor\" name=\"$nombre\" size=\"10\" onblur=\"esFechaValida(this);\" $extra/>
    <img src=\"../images/acc_calendar.png\" alt=\"\" onclick=\"displayCalendar(document.forms[0]." . $nombre . ",'dd/mm/yyyy',this)\"/>\n";

    return $mm;
}

function calendar($nombre, $valor, $size, $readonly = false) {
    $ro = ($readonly) ? " READONLY " : "";
    return "<input type=\"text\" value=\"$valor\" $ro name=\"firstinput\" class=\"inputbox\" size=\"$size\"><small><a href=\"javascript:showCal('Calendar1')\"><img src=\"images/calendar.jpg\" border=\"0\"></a></small>";
}

function calendar2($nombre, $valor, $size, $readonly = false) {
    $ro = ($readonly) ? " READONLY " : "";
    return "<input type=\"text\" value=\"$valor\" $ro name=\"secondinput\" class=\"inputbox\" size=\"$size\"><small><a href=\"javascript:showCal('Calendar2')\"><img src=\"images/calendar.jpg\" border=\"0\"></a></small>";
}

function calendar3($nombre, $valor, $size, $readonly = false) {
    $ro = ($readonly) ? " READONLY " : "";
    return "<input type=\"text\" value=\"$valor\" $ro name=\"tercero\" class=\"inputbox\" size=\"$size\"><small><a href=\"javascript:showCal('Calendar3')\"><img src=\"images/calendar.jpg\" border=\"0\"></a></small>";
}

function calendar4($nombre, $valor, $size, $readonly = false) {
    $ro = ($readonly) ? " READONLY " : "";
    return "<input type=\"text\" value=\"$valor\" $ro name=\"cuarto\" class=\"inputbox\" size=\"$size\"><small><a href=\"javascript:showCal('Calendar4')\"><img src=\"images/calendar.jpg\" border=\"0\"></a></small>";
}

function calendar5($nombre, $valor, $size, $readonly = false) {
    $ro = ($readonly) ? " READONLY " : "";
    return "<input type=\"text\" value=\"$valor\" $ro name=\"quinto\" class=\"inputbox\" size=\"$size\"><small><a href=\"javascript:showCal('Calendar5')\"><img src=\"images/calendar.jpg\" border=\"0\"></a></small>";
}

function calendar6($nombre, $valor, $size, $readonly = false) {
    $ro = ($readonly) ? " READONLY " : "";
    return "<input type=\"text\" value=\"$valor\" $ro name=\"sexto\" class=\"inputbox\" size=\"$size\"><small><a href=\"javascript:showCal('Calendar6')\"><img src=\"images/calendar.jpg\" border=\"0\"></a></small>";
}

function num2letras($num, $fem = true, $dec = true) {
//if (strlen($num) > 14) die("El n?mero introducido es demasiado grande"); 
    $matuni[2] = "dos";
    $matuni[3] = "tres";
    $matuni[4] = "cuatro";
    $matuni[5] = "cinco";
    $matuni[6] = "seis";
    $matuni[7] = "siete";
    $matuni[8] = "ocho";
    $matuni[9] = "nueve";
    $matuni[10] = "diez";
    $matuni[11] = "once";
    $matuni[12] = "doce";
    $matuni[13] = "trece";
    $matuni[14] = "catorce";
    $matuni[15] = "quince";
    $matuni[16] = "dieciseis";
    $matuni[17] = "diecisiete";
    $matuni[18] = "dieciocho";
    $matuni[19] = "diecinueve";
    $matuni[20] = "veinte";
    $matunisub[2] = "dos";
    $matunisub[3] = "tres";
    $matunisub[4] = "cuatro";
    $matunisub[5] = "quin";
    $matunisub[6] = "seis";
    $matunisub[7] = "sete";
    $matunisub[8] = "ocho";
    $matunisub[9] = "nove";

    $matdec[2] = "veint";
    $matdec[3] = "treinta";
    $matdec[4] = "cuarenta";
    $matdec[5] = "cincuenta";
    $matdec[6] = "sesenta";
    $matdec[7] = "setenta";
    $matdec[8] = "ochenta";
    $matdec[9] = "noventa";
    $matsub[3] = 'mill';
    $matsub[5] = 'bill';
    $matsub[7] = 'mill';
    $matsub[9] = 'trill';
    $matsub[11] = 'mill';
    $matsub[13] = 'bill';
    $matsub[15] = 'mill';
    $matmil[4] = 'millones';
    $matmil[6] = 'billones';
    $matmil[7] = 'de billones';
    $matmil[8] = 'millones de billones';
    $matmil[10] = 'trillones';
    $matmil[11] = 'de trillones';
    $matmil[12] = 'millones de trillones';
    $matmil[13] = 'de trillones';
    $matmil[14] = 'billones de trillones';
    $matmil[15] = 'de billones de trillones';
    $matmil[16] = 'millones de billones de trillones';

    $num = trim((string) @$num);
    if ($num[0] == '-') {
        $neg = 'menos ';
        $num = substr($num, 1);
    } else
        $neg = '';
    while ($num[0] == '0')
        $num = substr($num, 1);
    if ($num[0] < '1' or $num[0] > 9)
        $num = '0' . $num;
    $zeros = true;
    $punt = false;
    $ent = '';
    $fra = '';
    for ($c = 0; $c < strlen($num); $c++) {
        $n = $num[$c];
        if (!(strpos(".,'''", $n) === false)) {
            if ($punt)
                break;
            else {
                $punt = true;
                continue;
            }
        } elseif (!(strpos('0123456789', $n) === false)) {
            if ($punt) {
                if ($n != '0')
                    $zeros = false;
                $fra .= $n;
            } else
                $ent .= $n;
        } else
            break;
    }
    $ent = '     ' . $ent;
    if ($dec and $fra and ! $zeros) {
        $fin = ' coma';
        for ($n = 0; $n < strlen($fra); $n++) {
            if (($s = $fra[$n]) == '0')
                $fin .= ' cero';
            elseif ($s == '1')
                $fin .= $fem ? ' uno' : ' un';
            else
                $fin .= ' ' . $matuni[$s];
        }
    } else
        $fin = '';
    if ((int) $ent === 0)
        return 'Cero ' . $fin;
    $tex = '';
    $sub = 0;
    $mils = 0;
    $neutro = false;
    while (($num = substr($ent, -3)) != '   ') {
        $ent = substr($ent, 0, -3);
        if (++$sub < 3 and $fem) {
            $matuni[1] = 'uno';
            $subcent = 'os';
        } else {
            $matuni[1] = $neutro ? 'un' : 'uno';
            $subcent = 'os';
        }
        $t = '';
        $n2 = substr($num, 1);
        if ($n2 == '00') {
            
        } elseif ($n2 < 21)
            $t = ' ' . $matuni[(int) $n2];
        elseif ($n2 < 30) {
            $n3 = $num[2];
            if ($n3 != 0)
                $t = 'i' . $matuni[$n3];
            $n2 = $num[1];
            $t = ' ' . $matdec[$n2] . $t;
        }else {
            $n3 = $num[2];
            if ($n3 != 0)
                $t = ' y ' . $matuni[$n3];
            $n2 = $num[1];
            $t = ' ' . $matdec[$n2] . $t;
        }
        $n = $num[0];
        if ($n == 1) {
            $t = ' ciento' . $t;
        } elseif ($n == 5) {
            $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t;
        } elseif ($n != 0) {
            $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t;
        }
        if ($sub == 1) {
            
        } elseif (!isset($matsub[$sub])) {
            if ($num == 1) {
                $t = ' mil';
            } elseif ($num > 1) {
                $t .= ' mil';
            }
        } elseif ($num == 1) {
            $t .= ' ' . $matsub[$sub] . '?n';
        } elseif ($num > 1) {
            $t .= ' ' . $matsub[$sub] . 'ones';
        }
        if ($num == '000')
            $mils ++;
        elseif ($mils != 0) {
            if (isset($matmil[$sub]))
                $t .= ' ' . $matmil[$sub];
            $mils = 0;
        }
        $neutro = true;
        $tex = $t . $tex;
    }
    $tex = $neg . substr($tex, 1) . $fin;
    return ucfirst($tex);
}

function resfecha($ini, $fin) {
//echo $ini;
    $inicio = preg_split("/[.-\/]+/", $ini);
    $final = preg_split("/[.-\/]+/", $fin);
//var_dump($inicio);
//calculo timestam de las dos fechas 
    $timestamp1 = mktime(0, 0, 0, $inicio[1], $inicio[0], $inicio[2]);
    $timestamp2 = mktime(0, 0, 0, $final[1], $final[0], $final[2]);

//resto a una fecha la otra 
    $segundos_diferencia = $timestamp2 - $timestamp1;
//echo $segundos_diferencia; 
//convierto segundos en dÃ±as 
    $dias_diferencia = $segundos_diferencia / (60 * 60 * 24);
//echo "<br>".$dias_diferencia;
//obtengo el valor absoulto de los dÃ±as (quito el posible signo negativo) 
    $dias_diferencia = abs($dias_diferencia);

//quito los decimales a los dÃ±as de diferencia 
    $dias_diferencia = floor($dias_diferencia);


    return $dias_diferencia;
}

function conviertefecha($variable) {
    if ($variable == "") {
        return "null";
    }
    $fecha = preg_split("/[T.\-\/]+/", $variable);

    if (strlen($fecha[0]) == 4) {
        return "'" . $fecha[0] . '-' . $fecha[1] . '-' . $fecha[2] . "'";
    } else if (strlen($fecha[2]) == 4) {
        return "'" . $fecha[2] . '-' . $fecha[1] . '-' . $fecha[0] . "'";
    }
}

function restarfechasEscalafon($dfFechaInicio, $dfFechaTermino) {
    $anios = 0;
    $meses = 0;
    $dias = 0;
    if ($dfFechaTermino != '' && $dfFechaInicio != '' && $dfFechaTermino != null && $dfFechaInicio != null) {
        $tiempo = getTimeEscalafon($dfFechaTermino, -1) - getTimeEscalafon($dfFechaInicio, 0);

        if ($tiempo >= 0) {
            $diasTotales = $tiempo + 1;
            $anios = floor($diasTotales / 360);
            $meses = floor(($diasTotales % 360) / 30);
            $dias = ($diasTotales % 360) % 30;
        }
    }
    return array($anios, $meses, $dias);
}
function fechaintermedio($fechainicio,$fechatermino){
    $inicio = date_create(conviertefecha($fechainicio));
    $fin = date_create(conviertefecha($fechatermino));
    $actual = date_create('now');
    
    if($actual>=$inicio && $actual<=$fin){
        return true;
    }else{
        return false;
    }
}

function getTimeEscalafon($fecha, $dia31) {
    $inicio = preg_split("/[T.\-\/]+/", $fecha);
    //var_dump($inicio);
    if (strlen($inicio[0]) == 4) {
        $anios = $inicio[0];
        $meses = $inicio[1];
        $dias = ($inicio[2] == '31') ? (int) $inicio[2] + $dia31 : $inicio[2];
    } else if (strlen($inicio[2]) == 4) {
        $anios = $inicio[2];
        $meses = $inicio[1];
        $dias = ($inicio[0] == '31') ? (int) $inicio[0] + $dia31 : $inicio[0];
    }
    if ($meses == 2) {
        if ($dias == 28 && !esbiciesto($anios)) {
            $dias = 30;
        } else if ($dias == 29) {
            $dias = 30;
        }
    }
    //echo $anios.",".$meses.",",$dias.";";
    return (((int) $anios - 1800) * 360) + ((int) $meses * 30) + (int) $dias;
}

function esbiciesto($anio) {
    if ((($anio % 100 !== 0) && ($anio % 4 == 0)) || ($anio % 400 == 0)) {
        return true;
    } else {
        return false;
    }
}

function redondear_dos_decimal($valor) {
    $float_redondeado = round($valor * 100) / 100;
    return $float_redondeado;
}

function FechaFormateada($FechaStamp) {
    $ano = date('Y', $FechaStamp); //<-- Año
    $mes = date('m', $FechaStamp); //<-- nñmero de mes (01-31)
    $dia = date('d', $FechaStamp); //<-- Dña del mes (1-31)
    $dialetra = date('w', $FechaStamp);  //Dña de la semana(0-7)
    switch ($dialetra) {
        case 0: $dialetra = "Domingo";
            break;
        case 1: $dialetra = "Lunes";
            break;
        case 2: $dialetra = "Martes";
            break;
        case 3: $dialetra = "Miñrcoles";
            break;
        case 4: $dialetra = "Jueves";
            break;
        case 5: $dialetra = "Viernes";
            break;
        case 6: $dialetra = "Sñbado";
            break;
    }
    switch ($mes) {
        case '01': $mesletra = "Enero";
            break;
        case '02': $mesletra = "Febrero";
            break;
        case '03': $mesletra = "Marzo";
            break;
        case '04': $mesletra = "Abril";
            break;
        case '05': $mesletra = "Mayo";
            break;
        case '06': $mesletra = "Junio";
            break;
        case '07': $mesletra = "Julio";
            break;
        case '08': $mesletra = "Agosto";
            break;
        case '09': $mesletra = "Septiembre";
            break;
        case '10': $mesletra = "Octubre";
            break;
        case '11': $mesletra = "Noviembre";
            break;
        case '12': $mesletra = "Diciembre";
            break;
    }
    return "$dialetra, $dia de $mesletra del $ano";
}

function FechaFormateada1($FechaStamp) {

    list($dia_hoy, $mes, $anio_hoy) = split("[/.-]", $FechaStamp);

    switch ($mes) {
        case '01': $mesletra = "Enero";
            break;
        case '02': $mesletra = "Febrero";
            break;
        case '03': $mesletra = "Marzo";
            break;
        case '04': $mesletra = "Abril";
            break;
        case '05': $mesletra = "Mayo";
            break;
        case '06': $mesletra = "Junio";
            break;
        case '07': $mesletra = "Julio";
            break;
        case '08': $mesletra = "Agosto";
            break;
        case '09': $mesletra = "Septiembre";
            break;
        case '10': $mesletra = "Octubre";
            break;
        case '11': $mesletra = "Noviembre";
            break;
        case '12': $mesletra = "Diciembre";
            break;
    }
    return "$mesletra";
}

function VerMess($num) {


    switch ($num) {
        case '01': $mesletra = "Enero";
            break;
        case '02': $mesletra = "Febrero";
            break;
        case '03': $mesletra = "Marzo";
            break;
        case '04': $mesletra = "Abril";
            break;
        case '05': $mesletra = "Mayo";
            break;
        case '06': $mesletra = "Junio";
            break;
        case '07': $mesletra = "Julio";
            break;
        case '08': $mesletra = "Agosto";
            break;
        case '09': $mesletra = "Septiembre";
            break;
        case '10': $mesletra = "Octubre";
            break;
        case '11': $mesletra = "Noviembre";
            break;
        case '12': $mesletra = "Diciembre";
            break;
    }
    echo "$mesletra";
}

function VerMess1($num) {


    switch ($num) {
        case '01': $mesletra = "Enero";
            break;
        case '02': $mesletra = "Febrero";
            break;
        case '03': $mesletra = "Marzo";
            break;
        case '04': $mesletra = "Abril";
            break;
        case '05': $mesletra = "Mayo";
            break;
        case '06': $mesletra = "Junio";
            break;
        case '07': $mesletra = "Julio";
            break;
        case '08': $mesletra = "Agosto";
            break;
        case '09': $mesletra = "Septiembre";
            break;
        case '10': $mesletra = "Octubre";
            break;
        case '11': $mesletra = "Noviembre";
            break;
        case '12': $mesletra = "Diciembre";
            break;
    }
    return "$mesletra";
}

function VerMesss($num) {

    switch ($num) {
        case '1': $mesletra = "ENERO";
            break;
        case '2': $mesletra = "FEBRERO";
            break;
        case '3': $mesletra = "MARZO";
            break;
        case '4': $mesletra = "ABRIL";
            break;
        case '5': $mesletra = "MAYO";
            break;
        case '6': $mesletra = "JUNIO";
            break;
        case '7': $mesletra = "JULIO";
            break;
        case '8': $mesletra = "AGOSTO";
            break;
        case '9': $mesletra = "SEPTIEMBRE";
            break;
        case '10': $mesletra = "OCTUBRE";
            break;
        case '11': $mesletra = "NOVIEMBRE";
            break;
        case '12': $mesletra = "DICIEMBRE";
            break;
    }
    echo "$mesletra";
}

function VerMesss1($num) {

    switch ($num) {
        case '1': $mesletra = "ENERO";
            break;
        case '2': $mesletra = "FEBRERO";
            break;
        case '3': $mesletra = "MARZO";
            break;
        case '4': $mesletra = "ABRIL";
            break;
        case '5': $mesletra = "MAYO";
            break;
        case '6': $mesletra = "JUNIO";
            break;
        case '7': $mesletra = "JULIO";
            break;
        case '8': $mesletra = "AGOSTO";
            break;
        case '9': $mesletra = "SEPTIEMBRE";
            break;
        case '10': $mesletra = "OCTUBRE";
            break;
        case '11': $mesletra = "NOVIEMBRE";
            break;
        case '12': $mesletra = "DICIEMBRE";
            break;
    }
    return "$mesletra";
}

function VerDiass($dias) {

    switch ($dias) {
        case 'Lunes': $mesletra = "1";
            break;
        case 'Martes': $mesletra = "2";
            break;
        case 'Miercoles': $mesletra = "3";
            break;
        case 'Jueves': $mesletra = "4";
            break;
        case 'Viernes': $mesletra = "5";
            break;
        case 'Sabado': $mesletra = "6";
            break;
        case 'Domingo': $mesletra = "7";
            break;
    }
    return "$mesletra";
}

function VerDias($dias) {

    switch ($dias) {
        case '1': $mesletra = "Lunes";
            break;
        case '2': $mesletra = "Martes";
            break;
        case '3': $mesletra = "Miercoles";
            break;
        case '4': $mesletra = "Jueves";
            break;
        case '5': $mesletra = "Viernes";
            break;
        case '6': $mesletra = "Sabado";
            break;
        case '7': $mesletra = "Domingo";
            break;
    }
    return "$mesletra";
}

function reemplaza($letra) {
    $letra = str_replace('ñ', '&ntilde;', $letra);
    $letra = str_replace('ó', '&oacute;', $letra);
    $letra = str_replace('º', '&ordm;', $letra);
    $letra = str_replace('á', '&aacute;', $letra);
    $letra = str_replace('í', '&iacute;', $letra);
    $letra = str_replace('é', '&eacute;', $letra);
    $letra = str_replace('ú', '&uacute;', $letra);
    $letra = str_replace('Ó', '&Oacute;', $letra);
    $letra = str_replace('Ú', '&Uacute;', $letra);
    $letra = str_replace('Á', '&Aacute;', $letra);
    $letra = str_replace('Ñ', '&Ntilde;', $letra);
    $letra = str_replace('\"', '&quot;', $letra);
    $letra = str_replace('\'', '&#039;', $letra);
    return "$letra";
}

function reemp($letra) {
    $letra = str_replace('ñ', 'Ñ', $letra);
    return "$letra";
}

function reemplazap($letra) {
    $letra = str_replace('ñ', 'ñ', $letra);
    $letra = str_replace('\'', '&#039;', $letra);
    $letra = str_replace('Ñ', 'ñ', $letra);
    /* $letra = str_replace('ñ','&Ntilde;',$letra);	
      $letra = str_replace('ñ','&ntilde;',$letra); */
    return "$letra";
}

function reemplazas($letra) {
    $letra = str_replace('ñ', '&Ntilde;', $letra);
    $letra = str_replace('ñ', '&ntilde;', $letra);
    return "$letra";
}

function reemptas($letra) {
    $letra = str_replace('[', '', $letra);
    $letra = str_replace('\"', '', $letra);
    $letra = str_replace(']', '', $letra);
    $letra = str_replace('{', '{"', $letra);
    $letra = str_replace(':', '":', $letra);
    $letra = str_replace(',', ',"', $letra);

    return "$letra";
}

function formato_recibo($numero) {

    $cant = strlen($numero);

    $diferencia = 9 - $cant;

    for ($i = 0; $i < $diferencia; $i++) {
        $numero_con_ceros .= 0;
    }
    $numero_con_ceros .= $numero;

    return "$numero_con_ceros";
}

function conver_hora($hor) {
    list($horas, $min, $seg, $otr) = split(":", $hor);

    if ($hor != '' && $hor != '00:00:00:000') {
        if ($horas >= 12) {
            $horas = $horas - 12;
            $timer = "pm.";
        } else {
            $timer = "am.";
        }

        if ($horas == 0) {
            $horas = 12;
        }
        $val_h = $horas . ":" . $min . " " . $timer;
    }
    return $val_h;
}

function suma_fechas($fecha, $ndias) {
    if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/", $fecha))
        list($dia, $mes, $año) = split("/", $fecha);
    if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/", $fecha))
        list($dia, $mes, $año) = split("-", $fecha);
    $nueva = mktime(0, 0, 0, $mes, $dia, $año) + $ndias * 24 * 60 * 60;
    $nuevafecha = date("d/m/Y", $nueva);
    return ($nuevafecha);
}

function suma_fechass($fecha, $ndias) {
    if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/", $fecha))
        list($dia, $mes, $año) = split("/", $fecha);
    if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/", $fecha))
        list($dia, $mes, $año) = split("-", $fecha);
    $nueva = mktime(0, 0, 0, $mes, $dia, $año) + $ndias * 24 * 60 * 60;
    $nuevafecha = date("d-m-Y", $nueva);
    return ($nuevafecha);
}

function form_cabezera($tam, $titulo) {
    echo "<div style='width:" . $tam . "%;' >\n";
    echo "<div class='x-box-tl'>\n";
    echo " <div class='x-box-tr'>\n";
    echo "    <div class='x-box-tc'></div>\n";
    echo "    </div>\n";
    echo "  </div>\n";
    echo "  <div class='x-box-ml'>\n";
    echo "    <div class='x-box-mr'>\n";
    echo "      <div class='x-box-mc' >\n";
    echo " <h3 > " . $titulo . " </h3>\n";
//echo "</div>\n";
}

function form_salto($tam) {
    echo "<div style='background:#FFFFFF; padding: " . $tam . "px'></div>\n";
}

function form_define($option, $module) {
    echo "<form action=\"principal.php\" method=\"post\" id=\"form1\">\n";
    echo "<div>\n";
    echo "<input type=\"hidden\" name=\"option\" value=\"$option\" />\n";
    echo "<input type=\"hidden\" name=\"module\" value=\"$module\" />\n";
    echo "</div>\n";
}

function form_definess($option, $module) {
    echo "<form action=\"principal.php\" method=\"post\" id=\"form1\" target=\"_blank\" >\n";
    echo "<div>\n";
    echo "<input type=\"hidden\" name=\"option\" value=\"$option\" />\n";
    echo "<input type=\"hidden\" name=\"module\" value=\"$module\" />\n";
    echo "</div>\n";
}

function form_solo() {
    echo "<form action=\"principal.php\" id=\"form1\"  method=\"post\">";
}

function form_tabs($nombre, $id = false, $close = false) {
    echo $in = ($id) ? " <ul id=\"$nombre\" class=\"shadetabs\">\n " : "";
    echo $ro = ($close) ? " </ul>\n " : "";
}

function form_jstabs($nombre, $id) {
    echo "<script type=\"text/javascript\">\n";
    echo "var countries=new ddajaxtabs(\"$nombre\", \"$id\")\n";
    echo "countries.setpersist(true)\n";
    echo "countries.setselectedClassTarget(\"link\") \n";
    echo "countries.init()\n";
    echo "</script>\n";
}

function form_contabs($ref, $rel, $nombre, $class = false) {
    $ro = ($close) ? " class=\"selected\" " : "";
    echo "<li><a href=\"$ref\" rel=\"$rel\" $ro > $nombre </a></li>\n";
}

function form_div($nombre, $tama, $salto, $id = false, $close = false) {
    echo $in = ($id) ? " <div id=\"$nombre\" style=\"border:1px solid gray; width:" . $tama . "%; padding: " . $salto . "px\">\n " : "";
    echo $ro = ($close) ? " </div>\n " : "";
}

function form_close() {
    echo "</div>\n";
    echo "</div>\n";
    echo "</div>\n";
    echo "<div class=\"x-box-bl\">\n";
    echo "    <div class=\"x-box-br\">\n";
    echo "      <div class=\"x-box-bc\"></div>\n";
    echo "    </div>\n";
    echo "  </div>\n";
    echo "</div>\n";
    echo "</div>\n";
    echo "</form>\n";
}

function close_wind() {
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "<div class=\"x-box-bl\">";
    echo "<div class=\"x-box-br\">";
    echo "<div class=\"x-box-bc\"></div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
}

function td_no($co) {
    echo "<td class='style50' colspan=\"$co\" align=\"center\">No Hay Registros para Mostrar</td>\n";
}

function td_mira($co) {
    echo "<td colspan=\"$co\" align=\"center\">Ingresar Criterios de Busqueda</td>\n";
}

function mes_ini($nombre, $conta) {
    $meses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
    $v = "<select id=\"$nombre\" name=\"$nombre\"><option value='' selected=\"selected\">[Escoger]</option>\n";
    for ($mes_numero = $conta; $mes_numero <= 12; $mes_numero++) {
        if ($mes_numero == $mes) {
            $v.= "<option value='" . $mes_numero . "' >" . $meses[$mes_numero - 1] . "</option> \n";
        } else {
            $v.= "<option value='" . $mes_numero . "'>" . $meses[$mes_numero - 1] . "</option> \n";
        }
    }

    $v.= "</select>\n";

    return $v;
}

function mes_fin($nombre, $conta) {
    $meses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
    echo "<select id=\"$nombre\">\n";
    for ($mesn = 12; $mesn >= $conta; $mesn = $mesn - 1) {

        if ($mesn == $mes) {
            echo "<option value='" . $mesn . "' selected=\"selected\">" . $meses[$mesn - 1] . "</option> \n";
        } else {
            echo "<option value='" . $mesn . "'>" . $meses[$mesn - 1] . "</option> \n";
        }
    }
    echo "</select>\n";
}

function addSelect($name, $opts, $value = "", $more = "", $disable = false) {
    $ro = ($disable) ? "disabled=\"disabled\" " : "";
    if (count($opts) >= 1) {
        $code = "\n<select name=\"" . $name . "\" id=\"" . $name . "\" " . $more . " $ro>\n";
        for ($i = 0, $n = count($opts); $i < $n; $i++) {
            if ($opts[$i][0] == $value) {
                $code .= "\t<option value=\"" . $opts[$i][0] . "\" selected=\"selected\">" . $opts[$i][1] . "</option>\n";
            } else {
                $code .= "\t<option value=\"" . $opts[$i][0] . "\">" . $opts[$i][1] . "</option>\n";
            }
        }
        $code .= "</select>\n";
    } else {
        $code = "No existen opciones";
    }
    return $code;
}

function nocaracter($value) {
    $var = ereg_replace("[^A-Za-z0-9]", "", $value);
    return $var;
}

function anio_reg($nombre, $conta, $ini) {

    $v.= "<select id=\"$nombre\" name=\"$nombre\"><option value='0'>[Todos]</option> \n";
    for ($mes_numero = $ini; $mes_numero >= $conta; $mes_numero = $mes_numero - 1) {
        $v.= "<option value='" . $mes_numero . "' >" . $mes_numero . "</option> \n";
    }

    $v.= "</select>\n";

    return $v;
}

function anio_ini($nombre, $conta) {
    $hass = '2001';


    $v.= "<select id=\"$nombre\" name=\"$nombre\">\n";
    for ($mes_numero = $hass; $mes_numero <= $conta; $mes_numero++) {
        $v.= "<option value='" . $mes_numero . "' >" . $mes_numero . "</option> \n";
    }

    $v.= "</select>\n";

    return $v;
}

function anio_fin($nombre, $conta) {
    $hass = '2001';


    $v.= "<select id=\"$nombre\" name=\"$nombre\">\n";
    for ($mes_numero = $conta; $mes_numero >= $hass; $mes_numero--) {

        $v.= "<option value='" . $mes_numero . "' $vvv>" . $mes_numero . "</option> \n";
    }

    $v.= "</select>\n";

    return $v;
}

function anioss_fin($nombre, $conta) {
    $hass = $conta - 9;


    $v.= "<select id=\"$nombre\" name=\"$nombre\"><option value='0'>[Todos]</option> \n";
    for ($mes_numero = $hass; $mes_numero <= $conta; $mes_numero++) {
        $v.= "<option value='" . $mes_numero . "' >" . $mes_numero . "</option> \n";
    }

    $v.= "</select>\n";

    return $v;
}

function mes_actual($nombre, $conta) {
    $meses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
    echo "<select name=\"$nombre\" id=\"$nombre\">\n";
    for ($mes_numero = 1; $mes_numero <= 12; $mes_numero++) {
        if ($mes_numero == $conta) {
            echo "<option value='" . $mes_numero . "' selected=\"selected\">" . $meses[$mes_numero - 1] . "</option> \n";
        } else {
            echo "<option value='" . $mes_numero . "'>" . $meses[$mes_numero - 1] . "</option> \n";
        }
    }

    echo "</select>\n";
}

function mess_actual($nombre, $conta) {
    $meses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

    $vv = "<select name=\"$nombre\" id=\"$nombre\">\n";
    for ($mes_numero = 1; $mes_numero <= 12; $mes_numero++) {
        if ($mes_numero == $conta) {
            $vv.= "<option value='" . $mes_numero . "' selected=\"selected\">" . $meses[$mes_numero - 1] . "</option> \n";
        } else {
            $vv.= "<option value='" . $mes_numero . "'>" . $meses[$mes_numero - 1] . "</option> \n";
        }
    }

    $vv.= "</select>\n";

    return $vv;
}

function numdias($Month, $Year) {
    //Si la extensiñn que mencionñ estñ instalada, usamos esa. 
    if (is_callable("cal_days_in_month")) {
        return cal_days_in_month(CAL_GREGORIAN, $Month, $Year);
    } else {
        //Lo hacemos a mi manera. 
        return date("d", mktime(0, 0, 0, $Month + 1, 0, $Year));
    }
}

function compara_fechas($fecha1, $fecha2) {
    if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/", $fecha1))
        list($dia1, $mes1, $año1) = split("/", $fecha1);
    if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/", $fecha1))
        list($dia1, $mes1, $año1) = split("-", $fecha1);
    if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/", $fecha2))
        list($dia2, $mes2, $año2) = split("/", $fecha2);
    if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/", $fecha2))
        list($dia2, $mes2, $año2) = split("-", $fecha2);
    $dif = mktime(0, 0, 0, $mes1, $dia1, $año1) - mktime(0, 0, 0, $mes2, $dia2, $año2);
    return ($dif);
}

function getAnio($nro) {
    $year = array();
    $anio = date('Y');
    for ($i = 0; $i < $nro; $i++) {
        $year[$i][0] = $anio - $i;
        $year[$i][1] = $anio - $i;
    }
    return $year;
}

function completas($num_reg, $cant) {
    $var_n1 = array();
    $cadena_n1 = $num_reg;
    $longitud_n1 = strlen($cadena_n1);
    $n_para1 = "";
    if ($longitud_n1 < $cant) {
        $por_q1 = $cant - $longitud_n1;
        for ($i_n1 = 1; $i_n1 <= $por_q1; $i_n1++) {
            $var_n1[$i_n1] = "0";
        }
    }

    $n_para1 = implode('', $var_n1);
    return $n_canti = $n_para1 . "" . $num_reg;
}

function cortarpalabra($text, $num) {
    $var2 = array(); //estableces el array
    $cadena2 = $text; //cadena de texto que quieres separar en caracteres
    $longitud2 = strlen($cadena2); //nñmero de caracteres de la cadena

    for ($i2 = 1; $i2 <= $num; $i2++) {//bucle que se repite el mismo nñmero de veces que caracteres tiene la cadena
        $var2[$i2] = substr($cadena2, $i2 - 1, 1); //asigna un ñndice numñrico empezando por el uno y como valor un carñcter cada vez
    }
    $texto = implode('', $var2);
    return $texto;
}

function completas_p($num_reg, $cant) {
    $var_n1 = array();
    $cadena_n1 = $num_reg;
    $longitud_n1 = strlen($cadena_n1);
    $n_para1 = "";
    if ($longitud_n1 < $cant) {
        $por_q1 = $cant - $longitud_n1;
        for ($i_n1 = 1; $i_n1 <= $por_q1; $i_n1++) {
            $var_n1[$i_n1] = " ";
        }
    }
    $n_para1 = implode('', $var_n1);
    return $n_canti = $num_reg . "" . $n_para1;
}

function reemplaza_banc($letra) {
    $letra = str_replace('ñ', 'N', $letra);
    $letra = str_replace('ñ', 'n', $letra);
    $letra = str_replace('.', 'o', $letra);
    $letra = str_replace('"', ' ', $letra);
    $letra = str_replace('-', ' ', $letra);
    $letra = str_replace("'", ' ', $letra);
    $letra = str_replace('_', ' ', $letra);
    $letra = str_replace('&', 'Y', $letra);
    $letra = str_replace(',', ' ', $letra);
    $letra = str_replace('(', ' ', $letra);
    $letra = str_replace(')', ' ', $letra);
    $letra = str_replace(':', ' ', $letra);
    $letra = str_replace(';', ' ', $letra);
    $letra = str_replace('*', ' ', $letra);
    $letra = str_replace('+', ' ', $letra);
    $letra = str_replace(',', ' ', $letra);
    $letra = str_replace('/', ' ', $letra);
    $letra = str_replace('#', ' ', $letra);
    $letra = str_replace('ñ', ' ', $letra);
    $letra = str_replace('ñ', ' ', $letra);
    $letra = str_replace('%', '', $letra);
    $letra = str_replace('`', '', $letra);
    $letra = str_replace('ñ', 'O', $letra);
    return "$letra";
}

function cortacodigo($cod_c) {
    $var2 = array(); //estableces el array
    $cadena2 = $cod_c; //cadena de texto que quieres separar en caracteres
    $longitud2 = strlen($cadena2); //nñmero de caracteres de la cadena

    for ($i2 = 1; $i2 < $longitud2 + 1; $i2++) {//bucle que se repite el mismo nñmero de veces que caracteres tiene la cadena
        $var2[$i2] = substr($cadena2, $i2 - 1, 1); //asigna un ñndice numñrico empezando por el uno y como valor un carñcter cada vez
    }
    return $cod_c = $var2[3] . "" . $var2[4] . "" . $var2[5] . "" . $var2[6] . "" . $var2[7] . "" . $var2[8] . "" . $var2[9];
}

function comprimir($nom_arxiu) {
    $fptr = fopen($nom_arxiu, "rb");
    $dump = fread($fptr, filesize($nom_arxiu));
    fclose($fptr);

//Comprime al mñximo nivel, 9
    $gzbackupData = gzencode($dump, 9);

    $fptr = fopen($nom_arxiu . ".gz", "wb");
    fwrite($fptr, $gzbackupData);
    fclose($fptr);

//Devuelve el nombre del archivo comprimido
    return $nom_arxiu . ".gz";
}

function convertfecha($fech) {
    list($dia_hoy, $mes_hoy, $anio_hoy) = split("[/.-]", $fech);
    $fe_em = $anio_hoy . "" . $mes_hoy . "" . $dia_hoy;

    return $fe_em;
}

function input_hor($name, $hora = "") {
    $val = "<input type=\"text\" name=\"$name\" value=\"$hora\" onblur=\"CheckTime(this)\" size=\"8\" maxlength=\"5\" />";

    return $val;
}

function div_($name, $more = "") {
    echo "<div id=\"$name\" $more>\n";
}

function div_close($name, $more = "") {
    echo "<div id=\"$name\" $more></div>\n";
}

function form_cierra() {
    echo "</form>";
}

function div_cierra() {
    echo "</div>\n";
}

function div_tabs($name1, $name2, $name3) {
    echo "<div id=\"container\">\n";
    echo "<div id=\"banner\">&nbsp;</div>\n";
    echo "<div id=\"mainmenu\">\n";
    echo "<ul id=\"tabs\">\n";
    echo "<li>\n";
    echo "<a href=\"#tab1\">$name1</a>\n";
    echo "</li>\n";
    echo "<li>\n";
    echo "<a href=\"#tab2\">$name2</a>\n";
    echo "</li>\n";
    echo "<li>\n";
    echo "<a href=\"#tab3\">$name3</a>\n";
    echo "</li>\n";
    echo "</ul>\n";
    echo "<div>\n";
    echo "<div class=\"bar\">&nbsp;</div>\n";
}

function close_tabs() {
    echo " </fieldset></div>";
}

function close_t() {
    echo " </fieldset>";
}

function cab_tabs($name, $id) {
    echo "<div class=\"panel\" id=\"$id\">\n";
    echo "<fieldset>\n";
    echo "<legend>$name</legend>\n";
}

class sTable {

    var $code = "";
    var $nroColumns = 0;
    var $openTr = 0;

    function simpleTable($class, $more = "") {
        $code = "\n<table class=\"" . $class . "\" " . $more . " border=\"0\" cellspacing=\"0\" cellpadding=\"0\" >\n";
        echo $code;
    }

    function addRow($class = "", $more = "", $vv = "") {
        if ($vv == 1) {
            $code = "</tr>\n";
        } else {
            $code = "<tr" . ($class == "" ? "" : " class=\"" . $class . "\"") . " " . ($more == "" ? "" : $more) . ">\n\t";
        }
        echo $code;
    }

    function addCell($value, $more = "") {
        $code = "<td" . ($more == "" ? "" : " " . $more . " ") . ">" . $value . "</td>";
        echo $code;
    }

    function addCellth($value, $more = "") {
        $code = "<th" . ($more == "" ? "" : " " . $more . " ") . ">" . $value . "</th>";
        echo $code;
    }

    function addVacio() {
        $v = "<tr><td colspan='50'>&nbsp;</td></tr>";
        echo $v;
    }

    function Obliga($v) {
        $v = "<tr class=\"obli\"><td class='obli' colspan=\"$v\">* Son Obligatorios</td></tr>";
        echo $v;
    }

    function show() {
        $code = "</table>\n";
        echo $code;
    }

    function setHead($class, $vector) {
        $code .= "<tr>\n\t";
        for ($i = 0, $n = count($vector); $i < $n; $i++) {
            $code .= "<th>" . $vector[$i] . "</th> ";
        }
        $nroColumns = $n;
        $code .= "\n</tr>\n";
        echo $code;
    }

    function Vacio($co) {
        $code = "<tr><td colspan=\"$co\" align=\"center\">No Hay Registros para Mostrar</td></tr>\n";
        echo $code;
    }

}

function setBody($title = "") {
    echo "<fieldset>\n";
    echo $title != "" ? (" <legend>" . $title . "</legend>\n") : "";
}

function _muni() {
    $v = "MUNICIPALIDAD DISTRITAL DE V. LARCO H.";
    return $v;
}

function _webmuni() {
    $v = "http://www.google.com.pe/";
    return $v;
}

function _logomuni() {
    $v = "<img src=\"images/escudo1.gif\" width=\"41\" height=\"51\" alt=\"MUNI\"/>";
    return $v;
}

function _poplogmuni() {
    $c = "<img src=\"../../images/escudo1.gif\" width=\"41\" height=\"51\" alt=\"MUNI\"/>";
    return $c;
}

function _nombsistema() {
    $v = "Sistema Integrado de Gobierno Electronico Local";
    return $v;
}

function _nomsis() {
    $v = "ATENEO SIGOBEL v. 1.0";
    return $v;
}

function _random() {
    $codigo = "";
    $longitud = 20;
    for ($i = 1; $i <= $longitud; $i++) {
        $letra = chr(rand(97, 122));
        $codigo .= $letra;
    }

    return $codigo;
}

function nrodias_mes($Month, $Year) {
    //Si la extensiñn que mencionñ estñ instalada, usamos esa. 
    if (is_callable("cal_days_in_month")) {
        return cal_days_in_month(CAL_GREGORIAN, $Month, $Year);
    } else {
        //Lo hacemos a mi manera. 
        return date("d", mktime(0, 0, 0, $Month + 1, 0, $Year));
    }
}

function dia_semana($dia, $mes, $ano) {
    $dias = array('DOMINGO', 'LUNES', 'MARTES', 'MIERCOLES', 'JUEVES', 'VIERNES', 'SABADO');
    return $dias[date("w", mktime(0, 0, 0, $mes, $dia, $ano))];
}

function adTextarea($name, $value = "", $size = 255, $more = "", $class = "texto") {
    $code = "<textarea rows=\"2\" class=\"" . $class . "\" cols=\"50\" name=\"" . $name . "\" id=\"" . $name . "\" onkeydown=\"textCounter(this.form." . $name . ", this.form.size" . $name . ", " . $size . ");\" onkeyup=\"textCounter(this.form." . $name . ", this.form.size" . $name . ", " . $size . ");\" " . $more . ">" . $value . "</textarea>\n";
    $code .= "<input type=\"text\" class=\"" . $class . "\" name=\"size" . $name . "\" size=\"2\" maxlength=\"3\" value=\"" . $size . "\" readonly=\"readonly\" /> caracteres";
    return $code;
}

function adTextareas($name, $value = "", $size = "", $more = "", $class = "texto") {
    $code = "<textarea  class=\"" . $class . "\"  name=\"" . $name . "\" id=\"" . $name . "\" onkeydown=\"textCounter(this.form." . $name . ", this.form.size" . $name . ", " . $size . ");\" onkeyup=\"textCounter(this.form." . $name . ", this.form.size" . $name . ", " . $size . ");\" " . $more . ">" . $value . "</textarea>\n";
    $code .= "<input type=\"text\" class=\"" . $class . "\" name=\"size" . $name . "\" size=\"2\" maxlength=\"3\" value=\"" . $size . "\" readonly=\"readonly\" /> caracteres";
    return $code;
}

function camb_tr() {
    $vv = "onMouseOver=\"uno(this,'#99CCCC');\" onMouseOut=\"dos(this,'#FFFFFF');\" bgcolor=\"#FFFFFF\"";
    return $vv;
}

function input_person() {
    $v = "<input type=\"hidden\" id=\"codigo\"  name=\"codigo\" size='8' />
		<input type=\"hidden\" id=\"codvalue\"  name=\"codvalue\"/>
  <input type=\"text\" id=\"input\" onkeypress=\"javascript:autocompletar('lista',this.value);\" name=\"pers_concep\" size=\"50\" /> 
		<span id=\"reloj\"><img src='images/image.gif' alt='Persona'/></span>
		<br />
		<div id=\"lista\" class=\"suggestionsBox\"></div>";
    return $v;
}

function input_person1() {
    $v = "<input type=\"hidden\" id=\"codigo\" name=\"codigo\" size='8' />
		<input type=\"hidden\" id=\"codvalue\" name=\"codvalue\"/>
		<input type=\"text\" id=\"input\" onkeypress=\"javascript:autocompletar('lista',this.value);\" name=\"pers_concep\" size=\"30\" autocomplete=\"off\" /> 
		<span id=\"reloj\">&nbsp;</span>
		<br />
		<div id=\"lista\" class=\"suggestionsBox\"></div>";
    return $v;
}

function busq_person($nombre, $codigo, $value, $list, $imput, $busq, $server) {
    $v = "<input type=\"hidden\" id=\"$codigo\"  name=\"$codigo\" size='8' />
		<input type=\"hidden\" id=\"$value\"  name=\"$value\"/>

  <input type=\"text\" id=\"$imput\" onkeypress=\"javascript:autocompletar('$list',this.value,'$busq','$server');\" name=\"$nombre\" size=\"50\" /> 
		<span id=\"$busq\"><img src='images/image.gif' alt='Persona'/></span>
		<br />
		<div id=\"$list\" class=\"suggestionsBox\"></div>";
    return $v;
}

function rep_usuario($fech, $usu, $hor) {

    $v = "<table width=\"20%\" border=\"0\">
<tr><td class=\"p2008\">Emitido D&iacute;a:</td><td align=\"left\" class=\"p2008\">$fech</td></tr>
<tr><td class=\"p2008\">Usuario:</td><td align=\"left\" class=\"p2008\">$usu</td></tr>
<tr><td class=\"p2008\">Hora:</td><td align=\"left\" class=\"p2008\">$hor</td></tr>
</table>";

    echo $v;
}

function hora_titulo($titulo) {
    $v = "<TABLE width=\"100%\" border=\"0\" style=\"color: #3140C1;\">
		<TR><th><h2>" . $titulo . "</h2></th></TR></TABLE>";
    echo $v;
}

function conver_fecha($fecha) {
    $dias = array('', 'L', 'Ma', 'Mi', 'J', 'V', 'S', 'D');
    $fecha12 = $dias[date('N', strtotime($fecha))];

    return $fecha12;
}

function _obli() {
    $v = "<span class=\"obliga\">*</span>";
    return $v;
}

function frm_checkbox_no($nombre, $valor, $extra = "") {
    return "<input type=\"checkbox\" name=\"$nombre\" value=\"$valor\" $extra/>";
}

function stado_($est) {

    if ($est == 1) {
        $v = "<img src='images/icons/dentro.png' alt='Dentro'/>";
    } else {
        $v = "<img src='images/icons/fuera.png' alt='Fuera'/>";
    }

    return $v;
}

function ipp() {
    $ip = $_SERVER['REMOTE_ADDR'];
    return $ip;
}

?>