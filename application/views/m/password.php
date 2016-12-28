<?php $this->load->view('m/layout/header');?>
<div id="top">
	<div class="header">
		<a href="javascript:goback();" class="b_l"></a>
		<h2>修改密码</h2>
		<a href="javascript:gtns();" id="gdor" class="b_r">导航</a>
	</div>
</div>
<div class="gtn" id="gtn">
	<ul class="gt_a">
		<li><a href="javascript:;" class="gta">所有商品分类</a></li>
		<li><a href="javascript:;" class="gta">购物车</a></li>
		<li><a href="javascript:;" class="gta">浏览历史</a></li>
		<li><a href="javascript:;" class="gta">回首页</a></li>
		<li><a href="javascript:;" class="gta">在线客服咨询</a></li>
	</ul>
</div>
<div class="pageauto">
	<div class="pd10">
		<form action="" method="POST" id="car" onSubmit="return chp()">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="ftable">
				<tbody>
					  <tr>
					      <td width="20%">原始密码:</td>
					      <td><input type="password" name="original" id="original" value="" maxlength="20" class="pt" /></td>
					  </tr>
					  <tr>
					      <td>新密码:</td>
					      <td><input type="password" name="password" id="password" value="" maxlength="20" class="pt" /></td>
					  </tr>
					  <tr>
						  <td>确认密码:</td>
						  <td><input type="password" name="retype" id="retype" value="" maxlength="20" class="pt" /></td>
					  </tr>
				</tbody>
			</table>
			<input type="submit" value="提交修改" class="bbt"/>
			<p class="lh16">&nbsp;</p>
		</form>
	</div>	
</div>
<?php $this->load->view('m/layout/smallfooter');?>
<?php $this->load->view('m/layout/footer');?>