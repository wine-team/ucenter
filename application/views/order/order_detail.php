<?php $this->load->view('layout/header');?>
<div class="w" id="content">
	<div class="u_top">
	   <?php $this->load->view('layout/menu');?>
	</div>
	<div class="ubgw">
		<div class="over">
			<h2 class="lr_bl left">订单详情</h2>
			<a href="<?php echo site_url('ucenter/index');?>" class="blue right">《返回订单列表</a>
		</div>

		<div class="yu_bg f14">
			<p>订单号：<?php echo $order->order_main_sn;?>
			
			( <?php if($order->pay_bank==2){echo '微信支付';}elseif($order->pay_bank==3){echo '支付宝支付';}else{echo '银联支付';}?>)
			
			</p>
			<p>
				状态： <b class="red"><?php echo $status_arr[$order->status];?></b>
			</p>
			<p>下单时间: <?php echo $order->created_at;?></p>
		</div>
        <?php if($order->status==2 && $order->pay_bank == 2) :?>
		<div id="weixinzhifu" data-order_id="<?php echo $order->order_id;?>" data-total="<?php echo $order->actual_price;?>" style="background: #fff url(http://s.qw.cc/themes/v4/css/ft/weipay.png) 320px 52px no-repeat; padding: 80px 0; height: 300px;">
			<h3 class="c3 lh30 f16">请使用微信扫一扫，扫描二维码支付</h3>
			<div id="codeimg">二维码生成中请稍等</div>
		</div>
		<?php endif;?>
		<p class="lh20">&nbsp;</p>
		<p class="s_h3 yahei">付款/收货人信息</p>
		<div class="lh25 f14">
			<p>联系人：<?php echo $order->user_name;?></p>
			<p>收货地址：<?php echo json_decode($order->delivery_address)->detailed;?></p>
			<p>手机号码：<?php echo substr_replace($user_info->phone, '****', 3,4)?><em class="c9 pl5 f12">(已加密)</em></p>
			<?php if($order->status>2) :?><a class="green_btn mt15" href="<?php echo site_url('ucenter/check_deliver/'.$order->order_id.'?order_main_sn='.$order->order_main_sn);?>">查看物流</a><?php endif;?>
			<?php if($order->status==2 && $order->pay_bank == 3) :?>
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
            <?php if($order->status==2 && $order->pay_bank!=2 && $order->pay_bank!=3) :?>
                <div class="mt15">
                    <form id="pay" target="_blank" method="post" action="https://gateway.95516.com/gateway/api/frontTransReq.do" name="pay">
                        <input type="hidden" value="5.0.0" name="version">
                        <input type="hidden" value="utf-8" name="encoding">
                        <input type="hidden" value="01" name="txnType">
                        <input type="hidden" value="01" name="txnSubType">
                        <input type="hidden" value="000201" name="bizType">
                        <input type="hidden" value="01" name="signMethod">
                        <input type="hidden" value="07" name="channelType">
                        <input type="hidden" value="0" name="accessType">
                        <input type="hidden" value="156" name="currencyCode">
                        <input type="hidden" value="http://www.qu.cn/respond.php?code=unionpay" name="frontUrl">
                        <input type="hidden" value="http://www.qu.cn/notify/unionpay.php" name="backUrl">
                        <input type="hidden" value="802500048160537" name="merId">
                        <input type="hidden" value="2399778I3374743" name="orderId">
                        <input type="hidden" value="20160907221047" name="txnTime">
                        <input type="hidden" value="4342" name="txnAmt">
                        <input type="hidden" value="69645719176" name="certId">
                        <input type="hidden" value="r2Tny99+YQuOkHvDeBOH9lvopfTrkI4stjJAbQoBXiD1qfWY6kAjx/OqIf63uKf/5znFqVfVZs95m7CxPAP/nMkvo1UzZD0/La/Dw1FQ81Tae8EjcIGya9oAwJO94sjyH87IWqz0DowFNfT9DgYmDdK4wUZJNS0r7Y2TtyMVRl377teJxdxSN6Od0fJvTs25xxi+XAS5O/V9xspY2mFHZEpQRD0rRZwuRA/D3Wl0PQFrk1yMyMZunhxfFWUy2Qj32BKDl+Lo7cnDl4diHx0AwkKKO+tlnQmGrR3acGFSpztZU92NXTSS50fHOvRutCkJnR4TBcxfj6L4DT7+4jqjHA==" name="signature">
                        <input class="bigsee" type="submit" value="立即使用银联支付">
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