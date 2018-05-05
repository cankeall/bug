<?php
//核心函数库
function d($args) {
	echo '<br/>---------------------debug info.---------------------<pre>';
	if(is_array($args))
		print_r($args);
	else
		var_dump($args);
	echo '</pre>---------------------debug end.---------------------';
}
// 组合
function combination($a, $m) {
	$r = array();
	$n = count($a);
	if ($m <= 0 || $m > $n) {
		return $r;
	}
	for ($i=0; $i<$n; $i++) {
		$t = array($a[$i]);
		if ($m == 1) {
			$r[] = $t;
		} else {
			$b = array_slice($a, $i+1);
			$c = combination($b, $m-1);
			foreach ($c as $v) {
				$r[] = array_merge($t, $v);
			}
		}
	}
	return $r;
}
function get_db($group='default'){
	static $_db = [];
	if(!isset($_db[$group])){
		$conf = $GLOBALS['conf']['db'][$group];

		$_db[$group]  = @new mysqli($conf['host'],$conf['user'],$conf['pwd'],$conf['database']);
		if(mysqli_connect_errno())
		{
			//echo mysqli_connect_error();
			die('Database access denied!');
		}
		$_db[$group]->query('set names '.$conf['charset']);
	}
	return $_db[$group];
}

function DB($group='default'){
	static $_maps = [];
	if(!isset($_maps[$group])){
		if(!class_exists('Database')){
			include FRAMEWORK_PATH.'/core/Database.class.php';
		}
		$_maps[$group] = new Database($group);
	}
    return $_maps[$group] ;
}


function message($value,$url=null){
	$js  = '<script type="text/javascript">';

    if($value) $js .= 'alert("'.$value.'");';
    
	if($url)
		$js .= 'window.location.href="'.$url.'";';
	else
		$js .= 'window.history.go(-1);';
	$js .= '</script>';
	echo $js;
	exit(0);
}

function ajax_success($data=[])
{
	$data['error'] = false;
	exit(json_encode($data));
}

function ajax_error($data=[])
{
	$data['error'] = true;
    exit(json_encode($data));
}

function request_method(){
    if(ajax_request()){
        return 'ajax';
    }else{
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
}

function ajax_request()
{
    return isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest";
}
function is_cli(){
    return preg_match("/cli/i", php_sapi_name()) ? true : false;
}
function is_mobile()
{ 
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
    {
        return true;
    } 
    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA']))
    { 
        // 找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    } 
    // 脑残法，判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT']))
    {
        $clientkeywords = array ('nokia',
            'sony',
            'ericsson',
            'mot',
            'samsung',
            'htc',
            'sgh',
            'lg',
            'sharp',
            'philips',
            'panasonic',
            'alcatel',
            'lenovo',
            'iphone',
            'ipod',
            'blackberry',
            'meizu',
            'android',
            'netfront',
            'symbian',
            'ucweb',
            'windowsce',
            'palm',
            'operamini',
            'operamobi',
            'openwave',
            'nexusone',
            'cldc',
            'midp',
            'wap',
            'mobile'
            ); 
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
        {
            return true;
        } 
    } 
    // 协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT']))
    { 
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
        {
            return true;
        } 
    } 
    return false;
} 

//密码加密
function md6($username,$pwd,$salt='331122'){
    return md5($username.md5($pwd.$salt));
}

function get_ip(){
   if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
       $ip = getenv("HTTP_CLIENT_IP");
   else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
       $ip = getenv("HTTP_X_FORWARDED_FOR");
   else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
       $ip = getenv("REMOTE_ADDR");
   else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
       $ip = $_SERVER['REMOTE_ADDR'];
   else
       $ip = "unknown";
   return $ip;
}
//生成流水号
function create_lsh(){
    return date('ymdHis').rand(1000,9999);
}

function C($name,$value=null){
	if($value){
		$GLOBALS['conf'][$name] = $value;
		return true;
	}
	return $GLOBALS['conf'][$name];
}

function I($k,$default=null,$filter=false){
     $v = isset($_REQUEST[$k])?$_REQUEST[$k]:$default;
     if($filter){
          $v = $filter($v);
     }else{
          $v = xss_filter($v);
     }
     return $v;
}

function xss_filter($data){
    if(is_array($data)){
        foreach($data as $k=>$v){
            $data[$k] = xss_filter($v);
        }
    }else{
        $data = strip_tags(trim($data));
        $data = htmlspecialchars($data,ENT_QUOTES);
    }
    return $data;
}

function html_filter($val) {  
   // remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed  
   // this prevents some character re-spacing such as <java\0script>  
   // note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs  
   $val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);  
     
   // straight replacements, the user should never need these since they're normal characters  
   // this prevents like <IMG SRC=@avascript:alert('XSS')>  
   $search = 'abcdefghijklmnopqrstuvwxyz'; 
   $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';  
   $search .= '1234567890!@#$%^&*()'; 
   $search .= '~`";:?+/={}[]-_|\'\\'; 
   for ($i = 0; $i < strlen($search); $i++) { 
      // ;? matches the ;, which is optional 
      // 0{0,7} matches any padded zeros, which are optional and go up to 8 chars 
    
      // @ @ search for the hex values 
      $val = preg_replace('/(&#[xX]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ; 
      // @ @ 0{0,7} matches '0' zero to seven times  
      $val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ; 
   } 
    
   // now the only remaining whitespace attacks are \t, \n, and \r 
   $ra1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base'); 
   $ra2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload'); 
   $ra = array_merge($ra1, $ra2); 
    
   $found = true; // keep replacing as long as the previous round replaced something 
   while ($found == true) { 
      $val_before = $val; 
      for ($i = 0; $i < sizeof($ra); $i++) { 
         $pattern = '/'; 
         for ($j = 0; $j < strlen($ra[$i]); $j++) { 
            if ($j > 0) { 
               $pattern .= '(';  
               $pattern .= '(&#[xX]0{0,8}([9ab]);)'; 
               $pattern .= '|';  
               $pattern .= '|(&#0{0,8}([9|10|13]);)'; 
               $pattern .= ')*'; 
            } 
            $pattern .= $ra[$i][$j]; 
         } 
         $pattern .= '/i';  
         $replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2); // add in <> to nerf the tag  
         $val = preg_replace($pattern, $replacement, $val); // filter out the hex tags  
         if ($val_before == $val) {  
            // no replacements were made, so exit the loop  
            $found = false;  
         }  
      }  
   }  
   return $val;  
}   

function key2value($data,$key='id',$value='title'){
    $tmp = array();
    if(is_array($data)){
        foreach($data as $v){
            if(is_object($v))
                $tmp[$v->$key] = $v->$value;
            else
                $tmp[$v[$key]] = $v[$value];
        }
    }
    return $tmp;
}

function key2data($data,$field){
    $tmp = [];
    if(is_array($data)){
        foreach($data as $v){
             if(is_object($v)) 
                $tmp[$v->$field][] = $v;
             else
                $tmp[$v[$field]][] = $v;
        }
    }
    return $tmp;
}

function url($route,$params=array()){
    if(empty($params)){
        return BASE_URL.'/'.$route.$GLOBALS['conf']['url_suffix'];
    }else{
        $query_string = '';
        foreach($params as $k=>$v){
            $query_string .= '/'.$k.'/'.$v;
        }
        //return BASE_URL.'/'.$route.$GLOBALS['conf']['url_suffix'].'?'.http_build_query($params);
        return BASE_URL.'/'.$route.$query_string.$GLOBALS['conf']['url_suffix'];
    }
}

function parse_route(){
    $conf = $GLOBALS['conf'];
    if($_SERVER['REQUEST_URI']==='/'){
        $controller = $conf['default_controller'];//默认控制器
        $action = $conf['default_action'];//默认方法
    }else{
        //解析url
        if($conf['url_mode']==1){
            $controller = $_GET['c'];//控制器
            $action = $_GET['a'];//方法
        }else{
            
            $uri_path = parse_url($_SERVER['REQUEST_URI'])['path'];

            if($conf['url_suffix']) $uri_path = str_replace($conf['url_suffix'],'',$uri_path);
            
            if(strpos($uri_path,'index.php')!==false){
                $uri_path = str_replace('/index.php','',$uri_path);
            }
            if($uri_path){
                $route = ltrim($uri_path,'/');
                $routeMap = explode('/',$route);

                $controller = $routeMap[0];//控制器
                $action = isset($routeMap[1])?$routeMap[1]:'index';//方法

                $count = count($routeMap);
                if($count>2){
                    for($i=2;$i<$count;$i+=2){
                        $_GET[$routeMap[$i]] = $routeMap[$i+1];
                        $_REQUEST[$routeMap[$i]] = $routeMap[$i+1];
                    }
                }

            }else{
                $controller = $conf['default_controller'];//默认控制器
                $action = $conf['default_action'];//默认方法
            }
        }
    }
    return array($controller,$action);
}

function getCache($name){
	$data=[];
	$file = ROOT_PATH.'/cache/'.$name.'.c';
	if(file_exists($file)){
		$data = file_get_contents($file);
        $data = json_decode($data,true);
	}
	return $data;
}
function setCache($name,$values){
	$file = ROOT_PATH.'/cache/'.$name.'.c';
	//$content = "<?php\r\n return ".var_export($values).";\r\n? >";
	return file_put_contents($file, json_encode($values));
}

function html_cut($string, $length, $dot = '...') {  
    $strlen = strlen($string);  
    if($strlen <= $length) return $string;  
    $string = str_replace(  
        array(' ','&nbsp;', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'),  
        array('∵',' ', '&', '"', "'", '“', '”', '—', '<.', '.>', '·', '…'),     //<.和.>是为了保证不与HTML的尖括号冲突  
        $string);  
    $strcut = '';  
    if(strtolower(CHARSET) == 'utf-8') {  
        $length = intval($length-strlen($dot)-$length/3);  
        $n = $tn = $noc = 0;  
        while($n < strlen($string)) {  
            $t = ord($string[$n]);  
            if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {  
                $tn = 1; $n++; $noc++;  
            } elseif(194 <= $t && $t <= 223) {  
                $tn = 2; $n += 2; $noc += 2;  
            } elseif(224 <= $t && $t <= 239) {  
                $tn = 3; $n += 3; $noc += 2;  
            } elseif(240 <= $t && $t <= 247) {  
                $tn = 4; $n += 4; $noc += 2;  
            } elseif(248 <= $t && $t <= 251) {  
                $tn = 5; $n += 5; $noc += 2;  
            } elseif($t == 252 || $t == 253) {  
                $tn = 6; $n += 6; $noc += 2;  
            } else {  
                $n++;  
            }  
            if($noc >= $length) {  
                break;  
            }  
        }  
        if($noc > $length) {  
            $n -= $tn;  
        }  
        if($n + 1 <= strlen($string)) {  
            $cross_word = substr($string, $n - 1, 2);  
            if($cross_word == '<.' || $cross_word == '.>') {  
                $n += 1;    //确保截断后包含完整的<.和.>  
            }  
        }  
        $strcut = substr($string, 0, $n);  
        $strcut = str_replace(  
            array('∵', '&', '"', "'", '“', '”', '—', '<.', '.>', '·', '…'),  
            array(' ', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'),  
            $strcut);  
    } else {  
        $dotlen = strlen($dot);  
        $maxi = $length - $dotlen - 1;  
        $current_str = '';  
        $search_arr = array('&',' ', '"', "'", '“', '”', '—', '<.', '.>', '·', '…','∵');  
        $replace_arr = array('&amp;','&nbsp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;',' ');  
        $search_flip = array_flip($search_arr);  
        for ($i = 0; $i < $maxi; $i++) {  
            $current_str = ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];  
            if($i + 1 < strlen($string)) {  
                $cross_word = substr($string, $i, 2);  
                if($cross_word == '<.' || $cross_word == '.>') {  
                    $current_str .= $string[++$i];    //确保截断后包含完整的<.和.>  
                }  
            }  
            if (in_array($current_str, $search_arr)) {  
                $key = $search_flip[$current_str];  
                $current_str = str_replace($search_arr[$key], $replace_arr[$key], $current_str);  
            }  
            $strcut .= $current_str;  
        }  
    }  
    return $strcut.$dot;  
 }