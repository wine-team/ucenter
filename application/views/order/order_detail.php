<?php $this->load->view('layout/header');?>
<div class="w" id="content">
	<div class="u_top">
		<?php $this->load->view('layout/menu');?>
	</div>
	<div class="ubgw">
		<div class="over">
			<h2 class="lr_bl left">订单详情</h2>
			<a href="<?php echo site_url('Ucenter/index');?>" class="blue right">《返回订单列表</a>
		</div>

		<div class="yu_bg f14">
			<p>订单号：<?php echo $order->order_id;?>( <?php echo $order->pay_method;?>)</p>
			<p>
				状态： <b class="red"><?php echo $status_arr[$order->status];?></b>
			</p>
			<p>下单时间: <?php echo $order->created_at;?></p>
			</div>
            <?php if($order->pay_method !== '微信') :?>
		<div id="weixinzhifu" data-order_id="<?php echo $order->order_id;?>" data-total="<?php echo $order->actual_price;?>" style="background: #fff url(http://s.qw.cc/themes/v4/css/ft/weipay.png) 320px 52px no-repeat; padding: 80px 0; height: 300px;">
			<h3 class="c3 lh30 f16">请使用微信扫一扫，扫描二维码支付</h3>
			<div id="codeimg">二维码生成中请稍等</div>
		</div>
		<?php endif;?>
		<p class="lh20">&nbsp;</p>
		<p class="s_h3 yahei">付款/收货人信息</p>
		<div class="lh25 f14">
			<p>联系人：<?php echo $order->user_name;?></p>
			<p>收货地址：<?php echo json_decode($order->delivery_address);?></p>
			<p>手机号码：<?php echo substr_replace($user_info->phone, '****', 3,4)?><em class="c9 pl5 f12">(已加密)</em></p>
			<?php if($order->pay_method == '支付宝') :?>
				<div class="mt15" id="zhifubao">
                    <form id="pay" target="_blank" method="post" action="https://mapi.alipay.com/gateway.do?_input_charset=utf-8" name="pay">
                        <input type="hidden" value="utf-8" name="_input_charset">
                        <input type="hidden" value="http://www.qu.cn/notify/alipay.php" name="notify_url">
                        <input type="hidden" value="2016071914342779181-2308998" name="out_trade_no">
                        <input type="hidden" value="2088211707337241" name="partner">
                        <input type="hidden" value="1" name="payment_type">
                        <input type="hidden" value="http://www.qu.cn/respond.php?code=alipay" name="return_url">
                        <input type="hidden" value="vip@hongju.cc" name="seller_email">
                        <input type="hidden" value="create_direct_pay_by_user" name="service">
                        <input type="hidden" value="2016071914342779181" name="subject">
                        <input type="hidden" value="479.02" name="total_fee">
                        <input type="hidden" value="8d99d31b36904c80ce602d3e373c0cf6" name="sign">
                        <input type="hidden" value="MD5" name="sign_type">
                        <input class="bigsee" type="submit" value="立即使用支付宝支付">
                    </form>
                </div>
                <?php endif;?>
		</div>

		<p class="lh20">&nbsp;</p>
		<p class="s_h3 yahei">订单商品</p>
		<table width="100%" border="0" cellspacing="0" cellpadding="0"
			class="u_otb mt15" id="order_good_list">
			<tr>
				<th>商品信息</th>
				<th>数量</th>
				<th>单价</th>
				<th>小计</th>
				<th width="120">操作</th>
			</tr>
			<?php foreach($order_product as $product) :?>
			<tr>
				<td>
				   <a href="<?php echo $product->goods_id;?>" target="_blank">
				       <img src="<?php echo $this->config->images_url.$product->goods_img;?>" width="60" height="60" class="mr5"><?php echo $product->goods_name;?>
				       <b class="c3 pl5">(<?php echo $product->goods_id;?>)</b>
				   </a>
				</td>
				<td><?php echo $product->number;?></td>
				<td>¥<?php echo $product->pay_amount;?></td>
				<td>¥<?php echo $product->pay_amount*$product->number;?></td>
				<td>--</td>
			</tr>
			<?php endforeach;?>
		</table>
		<p class="lh20">&nbsp;</p>
		<div class="alR lh25 f14 c3">
			<p>总商品金额：¥<?php echo $order->order_supply_price;?></p>
			<p>- 优惠：¥<?php echo $order->coupon_price;?></p>
			<p>+ 运费：¥<?php echo $order->deliver_price;?></p>
			<p>- 已支付金额：¥0.00</p>
			<p>
				应付总额：<b class="red">¥<?php echo $order->actual_price;?></b>
			</p>
		</div>
	</div>
</div>
<?php $this->load->view('layout/footer');?>