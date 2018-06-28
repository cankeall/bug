<style type="text/css">
	.tb-bug{margin-left:10px;margin-bottom: 10px;font-size: 11px;}
	.viewbug .content{padding:5px 16px 0;}

	ul{padding-left: 40px;}
	li{list-style: disc;}
</style>
<div class="layui-main viewbug">
	<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
		<legend>bug # <?=$model->id?></legend>
	</fieldset>

	<blockquote class="layui-elem-quote layui-text">
		<?php echo $model->title; ?>
	</blockquote>

    <?php 
	    $priorArr = ['1'=>'<span class="red">紧急</span>','2'=>'<span class="orange">急</span>','3'=>'一般'];
	    $stateArr = ['1'=>'<span class="blue">打开</span>','2'=>'<span class="green">已解决</span>','3'=>'关闭'];
	    $userArr = key2value($user,'id','username');
    ?>

	<table class="tb-bug">
		<tr>
			<td align="right">报告者：</td>
			<td><?=$userArr[$model->uid]?></td>
		</tr>
		<tr>
			<td align="right">优先级：</td>
			<td><?=$priorArr[$model->priority]?></td>
		</tr>
		<tr>
			<td align="right">状态：</td>
			<td><?=$stateArr[$model->state]?></td>
		</tr>
		<tr>
			<td align="right">解决者：</td>
			<td><?=$userArr[$model->touid]?></td>
		</tr>
		<tr>
			<td align="right">更新时间：</td>
			<td><?=date('Y-m-d H:i',$model->updatetime)?></td>
		</tr>
	</table>

	<div class="content"><?php echo htmlspecialchars_decode($model->content);?></div>
</div>