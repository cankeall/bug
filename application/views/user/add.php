
<form class="layui-form" action="" method="post">
  <div class="layui-form-item">
    <label class="layui-form-label">管理员账号</label>
    <div class="layui-input-inline">
      <input type="text" name="username" required  lay-verify="required" placeholder="" autocomplete="off" class="layui-input">
    </div>
  </div>

  <div class="layui-form-item">
    <label class="layui-form-label">管理员密码</label>
    <div class="layui-input-inline">
      <input type="password" name="pwd" required  lay-verify="required" placeholder="" autocomplete="off" class="layui-input">
    </div>
  </div>

  <div class="layui-form-item">
    <div class="layui-input-block">
      <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
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