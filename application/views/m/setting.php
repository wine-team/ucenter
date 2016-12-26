<?php $this->load->view('m/layout/header');?>
<div id="top">
	<div class="header">
		<a href="javascript:goback();" class="b_l"></a>
		<h2>设置</h2>
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
	<div style="min-height:400px;">
		<ul class="bul mb10">
			<li><a href="<?php echo site_url('m/Address/grid');?>">收货地址</a></li>
			<li><a href="<?php echo site_url('m/Ucenter/profile');?>">个人资料</a></li>
			<li><a href="<?php echo site_url('m/Ucenter/password');?>">修改密码</a></li>
		</ul>
	</div>
</div>
<?php $this->load->view('m/layout/smallfooter');?>
<?php $this->load->view('m/layout/footer');?>