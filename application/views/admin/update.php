
<form class="layui-form" action="" method="post">
  <div class="layui-form-item">
    <label class="layui-form-label">管理员账号</label>
    <div class="layui-input-inline">
      <input type="text" name="username" value="<?=$model->username?>" readonly required  lay-verify="required" placeholder="" autocomplete="off" class="layui-input">
    </div>
  </div>

  <div class="layui-form-item">
    <label class="layui-form-label">管理员密码</label>
    <div class="layui-input-inline">
      <input type="password" name="pwd" placeholder="" autocomplete="off" class="layui-input">
    </div>
  </div>

  <div class="layui-form-item">
    <label class="layui-form-label">状态</label>
    <div class="layui-input-block">
      <input type="radio" name="state" value="0" title="停用" <?php echo $model->state==0?'checked':''; ?>>
      <input type="radio" name="state" value="1" title="启用" <?php echo $model->state==1?'checked':''; ?>>
    </div>
  </div>

  <div class="layui-form-item">
    <div class="layui-input-block">
      <button class="layui-btn" lay-submit lay-filter="formDemo">确认修改</button>
      <button class="layui-btn layui-btn-primary" onclick="window.history.go(-1);return false;" >返回</button>
    </div>
  </div>
</form>
 
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