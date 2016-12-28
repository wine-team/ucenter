<?php $this->load->view('m/layout/header');?>
<div id="top">
	<div class="header hfix">
		<a href="javascript:goback();"  class="b_l"></a>
		<h2>我的订单</h2>
		<a href="javascript:gtns();"  id="gdor" class="b_r">导航</a>
	</div>
</div>
<div class="gtn" id="gtn">
	<ul class="gt_a">
		<li><a href="fenlei.html" class="gta">所有商品分类</a></li>
		<li><a href="car.php" class="gta">购物车</a></li>
		<li><a href="history.php" class="gta">浏览历史</a></li>
		<li><a href="" class="gta">回首页</a></li>
		<li><a href="chat.php" class="gta">在线客服咨询</a></li>
	</ul>
</div>
<div class="pageauto">
	<ul class="uorder mt10">
		<li>
			<a href="<?php echo site_url('sex/home/orderdetail');?>"  class="arr">
				<img src="http://s.qw.cc/images/201604/thumb_img/5415_thumb_P220_1460455530090.jpg" class="omg"/>
				<p><em class="gray">订单号: </em><em class="red">2016050523200156755</em></p>
				<p>价格:<em class="red">¥392.04</em></p>
				<p><em class="gray">下单时间:</em> 2016-05-06 07:20:06</p>
				<p><em class="gray">订单状态:</em>待发货</p>
			</a>
			<p class="btline">
				<a href="<?php echo site_url('sex/home/orderdetail');?>" class="bun">详情</a>
			</p>
		</li>
		<li>
			<a href="<?php echo site_url('sex/home/orderdetail');?>"  class="arr"><img src="http://s.qw.cc/images/201604/thumb_img/5415_thumb_P220_1460455530090.jpg" class="omg"/>
				<p><em class="gray">订单号: </em><em class="red">2016050523025332453</em></p>
				<p>价格:<em class="red">¥392.04</em></p>
				<p><em class="gray">下单时间:</em> 2016-05-06 07:02:06</p>
				<p><em class="gray">订单状态:</em>待发货</p>
			</a>
			<p class="btline">
			<a href="<?php echo site_url('sex/home/orderdetail');?>" class="bun">详情</a>
			</p>
		</li>
		<li>
			<a href="order.php?act=detail&order_sn=2016050514383693803"  class="arr"><img src="http://s.qw.cc/images/201512/thumb_img/6197_thumb_P220_1449128855593.jpg" class="omg"/>
				<p><em class="gray">订单号: </em><em class="red">2016050514383693803</em></p>
				<p>价格:<em class="red">¥5231.24</em></p>
				<p><em class="gray">下单时间:</em> 2016-05-05 22:38:05</p>
				<p><em class="gray">订单状态:</em>待发货</p>
			</a>
			<p class="btline">
				<a href="order.php?act=detail&order_sn=2016050514383693803" class="bun">详情</a>
			</p>
		</li>
		<li>
			<a href="order.php?act=detail&order_sn=2016050514383693803"  class="arr"><img src="http://s.qw.cc/images/201511/thumb_img/4971_thumb_P220_1446530875302.jpg" class="omg"/>
				<p><em class="gray">订单号: </em><em class="red">2016050514383693803</em></p>
				<p>价格:<em class="red">¥5231.24</em></p>
				<p><em class="gray">下单时间:</em> 2016-05-05 22:38:05</p>
				<p><em class="gray">订单状态:</em>待发货</p>
			</a>
			<p class="btline">
				<a href="order.php?act=detail&order_sn=2016050514383693803" class="bun">详情</a>
			</p>
		</li>
		<li>
			<a href="order.php?act=detail&order_sn=2016050514383693803"  class="arr"><img src="http://s.qw.cc/images/201601/thumb_img/7577_thumb_P220_1453100833465.jpg" class="omg"/>
				<p><em class="gray">订单号: </em><em class="red">2016050514383693803</em></p>
				<p>价格:<em class="red">¥5231.24</em></p>
				<p><em class="gray">下单时间:</em> 2016-05-05 22:38:05</p>
				<p><em class="gray">订单状态:</em>待发货</p>
			</a>
			<p class="btline">
				<a href="order.php?act=detail&order_sn=2016050514383693803" class="bun">详情</a>
			</p>
		</li>
	</ul>
	<div class="bgw ye pd10 alC"><p>3 条记录 1/1 页</p></div>
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
