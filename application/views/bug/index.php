<form class="layui-form" action="/bug/index/sid/<?=$sid?>" method="get">
	<div class="layui-inline">
		<select name="uid" lay-verify="">
			<option value="">报告者</option>
			<?php foreach ($user as $k => $v): ?>
	        	<option value="<?=$v->id?>" <?php echo $v->id==$uid?'selected="selected"':'' ?>><?=$v->username?></option>
	        <?php endforeach ?>
		</select> 
	</div>
	<div class="layui-inline">
		<select name="priority" lay-verify="">
			<option value="">优先级</option>
			<option value="1" <?php echo 1==$priority?'selected="selected"':'' ?>>紧急</option>
			<option value="2" <?php echo 2==$priority?'selected="selected"':'' ?>>急</option>
			<option value="3" <?php echo 3==$priority?'selected="selected"':'' ?>>一般</option>
		</select> 
	</div>
	<div class="layui-inline">
		<select name="state" lay-verify="">
			<option value="">状态</option>
			<option value="1" <?php echo 1==$state?'selected="selected"':'' ?>>打开</option>
			<option value="2" <?php echo 2==$state?'selected="selected"':'' ?>>已解决</option>
			<option value="3" <?php echo 3==$state?'selected="selected"':'' ?>>关闭</option>
		</select> 
	</div>
	<div class="layui-inline">
		<select name="touid" lay-verify="">
			<option value="">解决者</option>
			<?php foreach ($user as $k => $v): ?>
	        	<option value="<?=$v->id?>" <?php echo $v->id==$touid?'selected="selected"':'' ?>><?=$v->username?></option>
	        <?php endforeach ?>
		</select> 
	</div>
	<div class="layui-inline">
		<input type="text" name="q" value="<?=$q?>" placeholder="关键字" autocomplete="off" class="layui-input">
	</div>		
	<div class="layui-inline">
		<button class="layui-btn" lay-submit="" lay-filter="formDemoPane">搜索</button>
	</div>
</form>

<div class="kh10"></div>

<div class="layui-row">
<a class="layui-btn" href="/bug/add/sid/<?=$sid?>">
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
      <th width="30%">标题</th>
      <th>优先级</th>
      <th>状态</th>
      <th>报告者</th>
      <th>报告时间</th>
      <th>解决者</th>
      <th>更新时间</th>
      <th>操作</th>
    </tr> 
  </thead>
  <?php 
  $priorArr = ['1'=>'<span class="red">紧急</span>','2'=>'<span class="orange">急</span>','3'=>'一般'];
  $stateArr = ['1'=>'<span class="blue">打开</span>','2'=>'<span class="green">已解决</span>','3'=>'关闭'];
  $userArr = key2value($user,'id','username');
   ?>
  <tbody>
  	<?php if(!empty($bugs)): ?>
  		<?php foreach ($bugs as $k => $v): ?>
  			<tr>
		      <td><?=$v->id?></td>
		      <td class="td-title">
		      	<a href="<?=url('bug/view',['sid'=>$sid,'id'=>$v->id])?>" target="_blank" class="blue"><?=$v->title?></a>
		      </td>
		      <td><?=$priorArr[$v->priority]?></td>
		      <td><?=$stateArr[$v->state]?></td>
		      <td><?=$userArr[$v->uid]?></td>
		      <td><?=date('Y-m-d H:i',$v->addtime)?></td>
		      <td><?=$userArr[$v->touid]?></td>
		      <td><?=date('Y-m-d H:i',$v->updatetime)?></td>
		      <td>
					  <a class="layui-btn layui-btn-xs" href="<?php echo url('bug/update',['sid'=>$sid,'id'=>$v->id]); ?>">编辑</a>
					  <a class="layui-btn layui-btn-danger layui-btn-xs" href="<?php echo url('bug/delete',['sid'=>$sid,'id'=>$v->id]); ?>">删除</a>
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