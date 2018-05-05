

<form class="layui-form" action="" method="post">
	<input type="hidden" name="sid" value="<?=$sid?>">
  <div class="layui-form-item">
    <label class="layui-form-label">标题</label>
    <div class="layui-input-block">
      <input type="text" name="title" required  lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input">
    </div>
  </div>

  <div class="layui-form-item">
    <label class="layui-form-label">优先级</label>
    <div class="layui-input-block">
      <input type="radio" name="priority" value="1" title="紧急">
      <input type="radio" name="priority" value="2" title="急" checked>
      <input type="radio" name="priority" value="3" title="一般">
    </div>
  </div>


  <div class="layui-form-item">
    <label class="layui-form-label">解决者</label>
    <div class="layui-input-inline">
      <select name="touid" lay-verify="required">
        <option value="0"></option>
        <?php foreach ($user as $k => $v): ?>
        	<option value="<?=$v->id?>"><?=$v->username?></option>
        <?php endforeach ?>
      </select>
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">状态</label>
    <div class="layui-input-block">
      <input type="radio" name="state" value="1" title="打开" checked>
      <input type="radio" name="state" value="2" title="已解决">
      <input type="radio" name="state" value="3" title="关闭">
    </div>
  </div>

  <div class="layui-form-item layui-form-text">
    <label class="layui-form-label">内容</label>
    <div class="layui-input-block">
      <textarea  name="content" style="width:100%;height:300px;visibility:hidden;"></textarea>
    </div>
  </div>
  

  <div class="layui-form-item">
    <div class="layui-input-block">
      <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
      <button class="layui-btn layui-btn-primary" onclick="window.history.go(-1);return false;" >返回</button>
    </div>
  </div>
</form>

<link rel="stylesheet" href="/public/kindeditor/themes/default/default.css" />
<script charset="utf-8" src="/public/kindeditor/kindeditor-all-min.js"></script>
<script charset="utf-8" src="/public/kindeditor/lang/zh-CN.js"></script>
 
<script>
//Demo
layui.use(['form'], function(){
  var form = layui.form;
  //监听提交
  form.on('submit(formDemo)', function(data){
    return true;
  });
});

var editor;
KindEditor.ready(function(K) {
	editor = K.create('textarea[name="content"]', {
		resizeType : 1,
		uploadJson : '/bug/upload',
        fileManagerJson : '/file_manager_json.php',
        allowImageUpload : true,
		allowFileManager : true,
		items : [
			'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
			'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
			'insertunorderedlist', '|', 'emoticons', 'image', 'link']
	});
});

</script>