<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>BUG管理系统</title>
	<link rel="stylesheet" type="text/css" href="/public/layui/css/layui.css">
	<script type="text/javascript" src="/public/js/jquery.js"></script>
	<script type="text/javascript" src="/public/layui/layui.js"></script>
	<script type="text/javascript">
		function setPageSize(p){
			var str = location.href;
			if(str.indexOf('pageSize=')!=-1){
				str = str.replace(/pageSize=(\d+)/,"pageSize="+p);
			}else if(str.indexOf('?')!=-1){
		        str = str + '&pageSize='+p;
			}else{
				str = str + '?pageSize='+p;
			}
			location.href = str;
		}
	</script>

	<style type="text/css">
	 .kh5{height: 5px;line-height: 5px;clear: both;}
     .kh10{height: 10px;line-height: 10px;clear: both;}
     .kh16{height: 16px;line-height: 16px;clear: both;}
     .Pagination{width:100%;margin:10px 0;height:30px;line-height:30px;text-align:center;clear:both;}
     .Pagination a,.Pagination select{border:1px solid #e2e2e2;height: 28px;line-height: 28px;}
     .Pagination a{
     	    display: inline-block;
		    vertical-align: middle;
		    padding: 0 12px;
		    margin: 0 -1px 5px 0;
		    background-color: #fff;
		    color: #333;
		    font-size: 12px;
		    text-decoration: none;
     }
     .Pagination a.current{background-color: #009688;color: #FFF;}
     .red{color: red;}
     .blue{color: blue;}
     .orange{color: orange;}
     .black{color: black;}
     .green{color: green;}
     .gray{color: gray;}
     .yellow{color: yellow;}
     .white{color: white;}

     .center{text-align: center;}
     .td-title a:visited{color: #343434;}
     .td-title a:hover{color: blue;}
     /* .content img{width: 100%;} */
	</style>

</head>
<body>
<div class="kh10"></div>
<div class="layui-fluid">  
	<div class="layui-row">
		<div class="layui-col-md2">

			<ul class="layui-nav layui-nav-tree" lay-filter="test">
			<!-- 侧边导航: <ul class="layui-nav layui-nav-tree layui-nav-side"> -->
			  <li class="layui-nav-item layui-nav-itemed">
			    <a href="javascript:;">MEIXINFU</a>
			    <dl class="layui-nav-child">
			      <dd data-sid="1"><a href="/bug/index/sid/1">商户</a></dd>
			      <dd data-sid="2"><a href="/bug/index/sid/2">后台</a></dd>
			    </dl>
			  </li>

			</ul>
            
            <div class="kh10"></div>
			<ul class="layui-nav layui-nav-tree" lay-filter="test">
			  <li class="layui-nav-item"><a href="/user/index">用户</a></li>
			</ul>

			<div class="kh16"></div>

			<div style="margin-left:63px;"><a href="/site/logout" class="layui-btn layui-btn-normal">退出</a></div>
		</div>
		<!-- end nav -->
		<div class="layui-col-md10">
			<?php echo $content; ?>
		</div>
	</div>
</div>
<script type="text/javascript">
	var sid = parseInt('<?php echo $sid; ?>');
	$("dl.layui-nav-child dd").each(function(idx,obj){
		if($(this).data('sid')==sid){
			$(this).addClass('layui-this');
		}else{
			$(this).removeClass('layui-this');
		}
	});
</script>
</body>
</html>