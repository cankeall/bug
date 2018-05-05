<?php
class Image{
	
	public $f = array();
	public $type = array('jpg','png','gif');
	public $up_size_limit = 1024000;
	public $up_dir = '';
	
	function __construct(){
		//$this->up_dir = SITE_PATH.'/upload';
	}
    /**
     * @todo 上传
     * @param array  $f   $_FILES
     * @param string $dir
     * @return string
     */
	function upload($f,$dir = 'upload'){
		$this->up_dir = ROOT_PATH.'/'.$dir;
		if($f['size']<0){
			$this->halt(0);
		}
		if($f['size']>$this->up_size_limit){
			$this->halt(1);
		}
		$tmp = explode('.',$f['name']);
		$type = $tmp[1];
		if(!in_array($type,$this->type)){
			$this->halt(2);
		}
		if(!is_dir($this->up_dir))@mkdir($this->up_dir,0777,true);
		$new_name = time().rand(100,999).'.'.$type;
		if(!move_uploaded_file($f['tmp_name'],$this->up_dir.'/'.$new_name)){
			$this->halt('3');
		}else{
			return [
					'path'=>$dir.'/'.$new_name,
					'name'=>$tmp[0]
			];
		}
	}
	/**
	 * @todo  缩略图
	 * @param string $src  大图路径
	 * @param string $to   小图路径
	 * @param int $to_w    小图宽度
	 * @param int $to_h    小图高度
	 * @return boolean|string
	 */
	function smallImg($src,$to,$to_w,$to_h){
		$data = getimagesize($src);//0为宽，1为高，2为类型
		$srcW=$data[0];
		$srcH=$data[1];
		switch ($data[2]){
			case 1: //图片类型，1是GIF图
				$im = @ImageCreateFromGIF($src);
				break;
			case 2: //图片类型，2是JPG图
				$im = @imagecreatefromjpeg($src);
				break;
			case 3: //图片类型，3是PNG图
				$im = @ImageCreateFromPNG($src);
				break;
		}
		if(empty($im)) return false;
		$to_w = ($to_w > $srcW) ? $srcW : $to_w;
		$to_h = ($to_h > $srcH) ? $srcH: $to_h;
		if ($srcW * $to_w > $srcH * $to_h) {
			$to_h = round($srcH * $to_w / $srcW);
		} else {
			$to_w = round($srcW * $to_h / $srcH);
		}
		if (function_exists("imagecreatetruecolor")) {
			$newImg = imagecreatetruecolor($to_w, $to_h);
			ImageCopyResampled($newImg, $im, 0, 0, 0, 0, $to_w, $to_h, $srcW, $srcH);
		} else {
			$newImg = imagecreate($to_w, $to_h);
			ImageCopyResized($newImg, $im, 0, 0, 0, 0,  $to_w, $to_h, $srcW, $srcH);
		}
		$todir = dirname($to);
		if(!is_dir($todir))@mkdir($todir,0777,true);
		imagejpeg($newImg,$to);
		imagedestroy($newImg);
		imagedestroy($im);
		return $to;
	}
	/**
	 * @todo  error handler
	 * @param errorno $i
	 */
	function halt($i){
		$msg=array(
		        0=>'img can not be empty',
				1=>'img is too big,1M limited',
				2=>'img type need jpg|gif|png',
				3=>'img move-upload error'		
		);
		exit(json_encode(array('succ'=>0,'msg'=>$msg[$i])));
	}	
}
?>