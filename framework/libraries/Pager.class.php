<?php

class Pager {
	private $pageSize;
	private $pageIndex;
	private $totalNum;

	private $totalPagesCount;
	
	private $pageUrl;
    
	public function __construct($p_totalNum, $p_pageSize=10,$p_initNum=3,$p_initMaxNum=5) {

		
		$this->totalNum       = $p_totalNum;
		$this->pageSize       = $p_pageSize;
        $this->initNum        = $p_initNum;
		$this->initMaxNum     =    $p_initMaxNum;
		$this->totalPagesCount= ceil($p_totalNum / $p_pageSize);

		$page = isset($_REQUEST['page'])?intval($_REQUEST['page']):1;
		
		$page = min($page,$this->totalPagesCount);
		$page = max($page,1);

		$this->pageIndex = $page;

		$this->getUrl();
	}

	public function offset(){
        return ($this->pageIndex -1 ) * $this->pageSize;
    }

    public function getUrl() {
	    //获取当前页面的文件位置
    	$url = $_SERVER['REQUEST_URI'];
	    //将url参数解析成数组
    	$parse = parse_url($url);
	    //获得域名地址
    	$path  = $parse['path'];
	    //获取参数
    	$query = isset($parse['query']) ? $parse['query'] : false;
	    //如果有参数，把page这个参数先给干掉，因为我们要重新拼接
    	if($query)
    	{
    		parse_str($query,$query);
	        //干掉page参数，保留其他参数
    		unset($query['page']);
	        //http_build_query拼将参数拼接成请求
    		$uri = $parse['path'].'?'.http_build_query($query);
    	} else {
    		$uri = rtrim($parse['path'],'?').'?';
    	}

	    //智能识别https和http协议和端口号
    	$protocal = (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
    	switch ($_SERVER['SERVER_PORT']) {
    		case 80:
    		case 443:
    		$uri = $protocal.$_SERVER['SERVER_NAME'].$uri;
    		break;
    		default:
    		$uri = $protocal.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].$uri;
    		break;
    	}
    	$this->pageUrl = $uri;
	}
	

//$this->pageUrl}={$i}
//{$this->CurrentUrl}={$this->TotalPages}
	public function GetPagerContent($url=null) {

		//$this->pageUrl = isset($url)?$url.'?page':'?page';
		//
		if(strpos($this->pageUrl,'?')===FALSE)
			$this->pageUrl = $this->pageUrl.'?page';
		else
			$this->pageUrl = $this->pageUrl.'&page';


		$str = '<div class="Pagination">';
		//首页 上一页
		if($this->pageIndex==1)
		{
			$str .="<a href='javascript:void(0)' class='tips' title='首页'>首页</a> "."\n";
			$str .="<a href='javascript:void(0)' class='tips' title='上一页'>上一页</a> "."\n"."\n";
		}else
		{
			$str .="<a href='{$this->pageUrl}=1' class='tips' title='首页'>首页</a> "."\n";
					$str .="<a href='{$this->pageUrl}=".($this->pageIndex-1)."' class='tips' title='上一页'>上一页</a> "."\n"."\n";
		}
		
		/*
		除首末后 页面分页逻辑
		
		*/
         //10页（含）以下
		 $currnt="";
		 if($this->totalPagesCount<=10)
		 {

			for($i=1;$i<=$this->totalPagesCount;$i++)
			
			{
				       if($i==$this->pageIndex)
					   {    $currnt=" class='current'";}
					   else
					   {    $currnt="";    }
						$str .="<a href='{$this->pageUrl}={$i} ' {$currnt}>$i</a>"."\n" ;
			}
		 }else                                //10页以上
		 {   if($this->pageIndex<3)  //当前页小于3
		     {
				 	 for($i=1;$i<=3;$i++)
					 {
						 if($i==$this->pageIndex)
						   {    $currnt=" class='current'";}
						 else
						 {    $currnt="";    }
						$str .="<a href='{$this->pageUrl}={$i} ' {$currnt}>$i</a>"."\n" ;
					 }
					 
		             $str.="<span class=\"dot\">……</span>"."\n";
					 
				 for($i=$this->totalPagesCount-3+1;$i<=$this->totalPagesCount;$i++)//功能1
				 {
					  $str .="<a href='{$this->pageUrl}={$i}' >$i</a>"."\n" ;
					 
				 }
		     }elseif($this->pageIndex<=5)   //   5 >= 当前页 >= 3
			 {
				 for($i=1;$i<=($this->pageIndex+1);$i++)
				 {
					  if($i==$this->pageIndex)
					   {    $currnt=" class='current'";}
					   else
					   {    $currnt="";    }
						$str .="<a href='{$this->pageUrl}={$i} ' {$currnt}>$i</a>"."\n" ;
					 
				 }
				 $str.="<span class=\"dot\">……</span>"."\n";
				 
				 for($i=$this->totalPagesCount-3+1;$i<=$this->totalPagesCount;$i++)//功能1
				 {
					  $str .="<a href='{$this->pageUrl}={$i}' >$i</a>"."\n" ;
					 
				 }
				  
			 }elseif(5<$this->pageIndex  &&  $this->pageIndex<=$this->totalPagesCount-5 )             //当前页大于5，同时小于总页数-5
			 
			 {
				 
				 for($i=1;$i<=3;$i++)
				 {
					 $str .="<a href='{$this->pageUrl}={$i}' >$i</a>"."\n" ;
				 }
                  $str.="<span class=\"dot\">……</span>";			 
				 for($i=$this->pageIndex-1 ;$i<=$this->pageIndex+1 && $i<=$this->totalPagesCount-5+1;$i++)
				 {
					   if($i==$this->pageIndex)
					   {    $currnt=" class='current'";}
					   else
					   {    $currnt="";    }
						$str .="<a href='{$this->pageUrl}={$i} ' {$currnt}>$i</a>"."\n" ;
				 }
				 $str.="<span class=\"dot\">……</span>";
				 
				 for($i=$this->totalPagesCount-3+1;$i<=$this->totalPagesCount;$i++)
				 {
					  $str .="<a href='{$this->pageUrl}={$i}' >$i</a>"."\n" ;
					 
				 }
			 }else
			 {
				 
				  for($i=1;$i<=3;$i++)
				 {
					 $str .="<a href='{$this->pageUrl}={$i}' >$i</a>"."\n" ;
				 }
                  $str.="<span class=\"dot\">……</span>"."\n";
				  
				  for($i=$this->totalPagesCount-5;$i<=$this->totalPagesCount;$i++)//功能1
				 {
					   if($i==$this->pageIndex)
					   {    $currnt=" class='current'";}
					   else
					   {    $currnt="";    }
						$str .="<a href='{$this->pageUrl}={$i} ' {$currnt}>$i</a>"."\n" ;
					 
				 }
			}		
			 
		 }
		 
		 
		 
		 
		/*
		
		除首末后 页面分页逻辑结束
		
		*/
		
		//下一页 末页
		if($this->pageIndex==$this->totalPagesCount)
		{	
		    $str .="\n"."<a href='javascript:void(0)' class='tips' title='下一页'>下一页</a>"."\n" ;
			//$str .="<a href='javascript:void(0)' class='tips' title='末页'>末页</a>"."\n";

			
		}else
		{
		 	$str .="\n"."<a href='{$this->pageUrl}=".($this->pageIndex+1)."' class='tips' title='下一页'>下一页</a> "."\n";
			//$str .="<a href='{$this->pageUrl}={$this->totalPagesCount}' class='tips' title='末页'>末页</a> "."\n" ;
		}	
		
		$str .='&nbsp;每页&nbsp;<select name="pageSize" onchange="setPageSize(this.value)">';
		if($this->pageSize==10){
			$str .='<option value="10" selected="selected">10</option>';
		}else{
			$str .='<option value="10">10</option>';
		}
		
		if($this->pageSize==20){
			$str .='<option value="20" selected="selected">20</option>';
		}else{
			$str .='<option value="20">20</option>';
		}
		
		if($this->pageSize==50){
			$str .='<option value="50" selected="selected">50</option>';
		}else{
			$str .='<option value="50">50</option>';
		}
		$str .='</select>&nbsp;条';

		return $str.'&nbsp;&nbsp;共&nbsp;'.$this->totalNum.'&nbsp;条</div>';
	}

}
?>
 
