<form class="layui-form" action="" method="get">
	<div class="layui-inline">
		<input type="text" name="q" value="<?=$q?>" placeholder="关键字" autocomplete="off" class="layui-input">
	</div>		
	<div class="layui-inline">
		<button class="layui-btn" lay-submit="" lay-filter="formDemoPane">搜索</button>
	</div>
</form>

<div class="kh10"></div>

<div class="layui-row">
<a class="layui-btn" href="/admin/add">
  <i class="layui-icon">&#xe608;</i> 添加
</a>
</div>


<table class="layui-table" class="center">
  <colgroup>
    <col width="150">
    <col width="200">
    <col>
  </colgroup>
  <thead>
    <tr>
      <th width="6%">#</th>
      <th width="30%">管理员账号</th>
      <th width="30%">状态</th>
      <th>操作</th>
    </tr> 
  </thead>

  <?php 
    $stateArr = ['0'=>'<span class="gray">停用</span>','1'=>'<span class="green">启用</span>'];
  ?>

  <tbody>
  	<?php if(!empty($rows)): ?>
  		<?php foreach ($rows as $k => $v): ?>
  			<tr>
		      <td><?=$v->id?></td>
		      <td class="td-title"><?=$v->username?></td>
          <td><?=$stateArr[$v->state]?></td>
		      <td>
					<a class="layui-btn layui-btn-xs" href="<?php echo url('admin/update',['id'=>$v->id]); ?>">编辑</a>
					<a class="layui-btn layui-btn-danger layui-btn-xs" href="<?php echo url('admin/delete',['id'=>$v->id]); ?>">删除</a>
		      </td>
		    </tr>
  		<?php endforeach ?>
	<?php endif; ?>
  </tbody>
</table>

<?php echo $pageHtml; ?>

<script>
//Demo
layui.use(['form'], function(){
  var form = layui.form;
  //监听提交
  form.on('submit(formDemo)', function(data){
    return true;
  });
});
</script>