<?php $this->load->view('m/layout/header');?>
<div id="top">
	<div class="header hfix">
		<a href="javascript:goback();" class="b_l"></a>
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
	<div class="o_t">
		<table width="100%" border="0">
		  <tr>
		    <td>收货人：蒋主席<b class="hid">，15988173722</b></td>
		    <td rowspan="2" width="70"></td>
		  </tr>
		  <tr>
		    <td>台湾省高雄市</td>
		    </tr>
		</table>
	</div>
	<ul class="w_l">
	</ul>
	<ul class="od">
		<li>
			<a href="goods-5415.html">
				<div class="lr10">
					<img src="http://s.qw.cc/images/201604/thumb_img/5415_thumb_P220_1460455530090.jpg" width="60"  height="60" class="left"/>藏帝 高原植物延时喷剂 不麻木无依赖 15ml套餐:买二送一,加赠藏帝延时湿巾10片[198] 
					<p><span class="red">392.04</span> X 1</p>
				</div>
			</a>
		</li>
		<li>
			<p class="lr10">
				<b>订单号：</b>
				<em class="red">2016050523200156755</em>
			</p>
		</li>
		<li>
			<p class="lr10"><b>状  态：</b>(	待付款            )
			</p>
		</li>
		<li>
			<p class="lr10">订单金额: <b class="red f16 mr5">¥392.04</b>(邮费:<b class="red">¥0.00</b>)</p>
		</li>
	</ul>
	<div class="lr10 mt10">
		<form name="pay" id="pay" action="http://wappaygw.alipay.com/service/rest.htm?_input_charset=utf-8" method="get" target="_blank">
			<input type="hidden" name="_input_charset" value="utf-8"/>
			<input type="hidden" name="format" value="xml"/>
			<input type="hidden" name="partner" value="2088211707337241"/>
			<input type="hidden" name="req_data" value="<auth_and_execute_req><request_token>201605075aa94ca47e935777c9520cdf9fe5a17f</request_token></auth_and_execute_req>" />
			<input type="hidden" name="req_id" value="1462579025"/>
			<input type="hidden" name="sec_id" value="MD5"/>
			<input type="hidden" name="service" value="alipay.wap.auth.authAndExecute"/>
			<input type="hidden" name="v" value="2.0"/>
			<input type="hidden" name="sign" value="e86d9c45d5e0d936f2fb01819aaa6996"/>
			<input type="submit" class="bigsee" value="立即使用支付宝支付">
		</form>
	</div>
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
