<?php $this->load->view('layout/header');?>
	<div class="w" id="content">
		<div class="u_top">
			<div class="u_zone over">
				<a href="<?php echo base_url('Ucenter/index');?>" class="u_ava">
				    <img src="<?php echo $this->config->images_url.$user_info->photo;?>" width="70" height="70" class="left" />
					<div class="over pt10">
						<b class="left"><?php echo $user_info->alias_name;?></b><em class="vip v1"></em>
					</div>
					<p>享受全场<i class="red">9.8</i>折优惠</p>
				</a> 
				<a href="javascript:;" onClick="jieshou()" class="right mt15" title="点击咨询在线客服">
				    <img src="http://s.qw.cc/themes/v4/css/ft/rkefu.png" width="234" height="45">
			    </a>
			</div>
			<ul id="u_nav" class="over yahei">
				<li class="on"><a href="<?php echo base_url('Ucenter/index');?>">全部订单<em class="c9">(<?php echo $user_info->num_list['order_num']?>)</em></a></li>
				<li><a href="<?php echo base_url('Enshrine/index');?>">收藏夹<em class="c9">(<?php echo $user_info->num_list['enshrine_num']?>)</em></a></li>
				<li><a href="<?php echo base_url('Coupon/index');?>">优惠券<em class="c9">(<?php echo $user_info->num_list['coupon_num']?>)</em></a></li>
				<li><a href="<?php echo base_url('Address/index');?>">收货地址</a></li>
				<li><a href="<?php echo base_url('Ucenter/pay_points');?>">我的积分<em class="c9">(<?php echo $user_info->num_list['pay_points_num']?>)</em></a></li>
				<li><a href="<?php echo base_url('Ucenter/user_info');?>">帐户信息</a></li>
			</ul>
		</div>



		<div class="ubgw">
			<div class="over">
				<h2 class="lr_bl left">订单详情</h2>
				<a href="<?php echo base_url('Ucenter/index');?>" class="blue right">《返回订单列表</a>
			</div>

			<div class="yu_bg f14">
				<p>订单号：<?php echo $order->order_id;?>( <?php echo $order->pay_method;?>)</p>
				<p>
					状态： <b class="red"><?php echo $status_arr[$order->status];?></b>
				</p>
				<p>下单时间: <?php echo $order->created_at;?></p>
			</div>


			<div id="weixinzhifu"
				style="background: #fff url(http://s.qw.cc/themes/v4/css/ft/weipay.png) 320px 52px no-repeat; padding: 80px 0; height: 300px;">
				<h3 class="c3 lh30 f16">请使用微信扫一扫，扫描二维码支付</h3>
				<div id="codeimg">二维码生成中请稍等</div>
			</div>
			<script type="text/javascript" src="themes/v4/js/pay.js"></script>
			<script type="text/javascript">
				$(function() {
					var order_sn = "2016050514383693803";
					var ip = "127.0.0.1";
					var total = "5231.24";
					total = total * 100;
					$.ajax({
								url : "wxpay/request.php",
								data : {
									'out_trade_no' : order_sn,
									'body' : "趣网商城",
									'total_fee' : total,
									'mch_create_ip' : ip
								},
								dataType : "json",
								type : "POST",
								success : function(res) {
									//                        doWftPay(data);
									if (typeof (res) === 'string') {
										res = JSON.parse(res);
									}
									if (res.status === 500) {
										_content = res.msg;
										$('#codeimg').popUpWin({
											content : res.msg
										});
									} else {
										$('#codeimg').html('');
										$('#codeimg').popUpWin({
											content : function() {
												return '<img width="230" src="'+res.code_img_url+'" />';
											},
											closeCallback : function() {
												self.popWin = undefined;
												self.opts.qrCodeClose = true;
											}
										});
									}
								}
							});
				});
			</script>

			<p class="lh20">&nbsp;</p>
			<p class="s_h3 yahei">付款/收货人信息</p>
			<div class="lh25 f14">
				<p>联系人：<?php echo $order->user_name;?></p>
				<p>收货地址：<?php echo json_decode($order->delivery_address);?></p>
				<p>
					手机号码：<?php echo substr_replace($user_info->phone, '****', 3,4)?><em class="c9 pl5 f12">(已加密)</em>
				</p>
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