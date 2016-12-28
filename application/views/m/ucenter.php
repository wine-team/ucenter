<?php $this->load->view('m/layout/header');?>
<div id="top">
	<div class="header hfix">
		<a href="javascript:goback();" class="b_l"></a>
		<h2>会员中心</h2>
		<a href="javascript:gtns();" id="gdor" class="b_r">导航</a>
	</div>
</div>
<div class="gtn" id="gtn">
	<ul class="gt_a">
		<li><a href=<?php echo site_url('m/category');?> class="gta">所有商品分类</a></li>
		<li><a href="<?php echo site_url('m/cart');?>" class="gta">购物车</a></li>
		<li><a href="<?php echo site_url('m/history');?>" class="gta">浏览历史</a></li>
		<li><a href="<?php echo site_url('m/index');?>" class="gta">回首页</a></li>
		<li><a href="chat.php" class="gta">在线客服咨询</a></li>
	</ul>
</div>
<div class="pageauto">
	<div class="g_tss alC" style="display:none;">
		<a href="profile.php?step=bangding" class="pl10" title="点击这里认证">点击认证送积分</a>
	</div>

	<div class="bgw pd10 mt10">
		<a href="<?php echo site_url('m/Ucenter/setting');?>" class="av_a">
			<img src="http://s.qw.cc/" class="uava left"/>
			<h3 class="f16 c3">15988173723<em class="vip">V1</em></h3>
			<p class="gray">享受全场<b class="c3">9.8</b>折优惠</p>
			<p class="gray f10">0积分</p>
		</a>
	</div>

	<ul class="bul mt10">
		<li>
			<a href="<?php echo site_url('m/Order/grid');?>">
				<img src="m/images/u1.png" class="uiu">全部订单(0)
			</a>
		</li>
		<li>
			<a href="<?php echo site_url('m/Coupon/index');?>">
				<img src="m/images/u2.png" class="uiu">优惠券</a>
			</li>
		<!--<li><a href="yao.php">摇一摇</a></li>-->
	</ul>
	<ul class="bul mt10">
		<li>
			<a href="<?php echo site_url('m/Enshrine/index')?>">
				<img src="m/images/u3.png" class="uiu">我的收藏(0)
			</a>
		</li>
		<li>
			<a href="<?php echo site_url('m/history')?>">
				<img src="m/images/u4.png" class="uiu">浏览历史
			</a>
		</li>
	</ul>
	<ul class="bul mt10">
		<li>
			<a href="<?php echo site_url('m/shophelp')?>">
				<img src="m/images/u5.png" class="uiu">购物帮助
			</a>
		</li>
		<li>
			<a href="javascript:;">
				<img src="m/images/u6.png" class="uiu">在线客服
			</a>
		</li>
		<li>
			<a href="<?php echo site_url('m/Ucenter/load_app');?>">
				<img src="m/images/u7.png" class="uiu">APP下载(送好礼)
			</a>
		</li>
		<li>
			<a href="<?php echo site_url('m/index');?>">
				<img src="m/images/u8.png" class="uiu">注销登录
			</a>
		</li>
	</ul>
	<div id="weix" class="wxfix mt10">
		<div class="page ov">
			<img src="m/images/quba96.jpg" class="wx_av">
			<p>查询物流、售后服务、学习新姿势请关注</p>
			<p>微信公众号：<em class="wx_txt">妙处网</em> ←长按可以复制</p>
		</div>
	</div>
</div>
<div class="bgw pd10 mt10">
	<form action="search.php" class="search ov" onsubmit="return se(this)">
		<input type="search" value="" class="sl left" name="keyword" id="word" placeholder="关键词..." />
		<input class="sr left" type="submit" value="" />
	</form>
</div>
<script>
function gtns(){
	$("#gtn").toggle();
}
$("#gtn").bind("click",function(){
	$(this).hide();
});
</script>
<?php $this->load->view('m/layout/smallfooter');?>
<?php $this->load->view('m/layout/footer');?>
