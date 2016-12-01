<?php $this->load->view('layout/header');?>
<div class="w" id="content">
	<div class="u_top">
	   <?php $this->load->view('layout/menu');?>
	</div>
	<div class="ubgw">
		<div class="over">
			<h2 class="lr_bl left">订单详情</h2>
			<a href="<?php echo site_url('order/index');?>" class="blue right">《返回订单列表</a>
		</div>

		<div class="yu_bg f14">
			<p>订单号：<?php echo $order->pay_id;?>
			
			( <?php echo $pay_method[$order->pay_bank]?>支付)
			
			</p>
			<p>
				状态： <b class="red"><?php echo $status_arr[$order->order_status];?></b>
			</p>
			<p>下单时间: <?php echo $order->created_at;?></p>
		</div>
        <?php if($order->order_status==2 && $order->pay_bank == 2) :?>
		<div id="weixinzhifu" data-pay_id="<?php echo base64_encode($order->pay_id);?>" data-total="<?php echo $order->actual_price;?>" style="background: #fff url(http://s.qw.cc/themes/v4/css/ft/weipay.png) 320px 52px no-repeat; padding: 80px 0; height: 300px;">
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
			<?php if($order->order_status>2) :?>
			<a class="green_btn mt15" href="<?php echo site_url('order/check_deliver/'.$order->order_id.'?pay_id='.$order->pay_id);?>">查看物流</a>
			<?php endif;?>
			<?php if($order->order_status>2 && $order->order_status<6) :?>
			<?php if($had_refund>0):?>
			<a class="green_btn mt15" style="background-color:#c40000;" href="javascript:;">已申请退款</a>
			<?php else :?>
			<a class="green_btn mt15" onclick="layer.confirm('是否确认申请退款？',function(){window.location.href='<?php echo site_url('order/order_refund/'.$order->order_id.'?pay_id='.$order->pay_id);?>';})"   href="javascript:;">申请退款</a>
			<?php endif;?>
			<?php endif;?>
			<?php if($order->order_status==2 && $order->pay_bank != 2) :?>
				<div class="mt15" id="zhifubao">
                    <form action="<?php echo $this->config->main_base_url.'pay/grid.html';?>" method="post" class="pay">
            		    <input type="hidden" name="pay_id" value="<?php echo $order->pay_id;?>"/>
            		    <input type="hidden" name="pay_bank" value="<?php echo $order->pay_bank;?>" />
            			<input type="submit" class="bigsee" value="立即使用<?php echo $pay_method[$order->pay_bank]?>支付" />
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
				   <a href="<?php echo $this->config->main_base_url.'goods/detail/'.$product->goods_id.'.html';?>" target="_blank">
				       <?php $img_arr = array_filter(explode('|',$product->goods_img));?>
				       <img class="lazy mr5" src="miaow/images/load.jpg" data-original="<?php echo $this->config->show_image_thumb_url('mall',$img_arr[0],60);?>" width="60" height="60" ><?php echo $product->goods_name;?>
				       <b class="c3 pl5">(<?php echo $product->goods_id;?>)</b>
				   </a>
				</td>
				<td><?php echo $product->number;?></td>
				<td>¥<?php echo $product->pay_amount;?></td>
				<td>¥<?php echo $product->pay_amount*$product->number;?></td>
				<td> 
				<?php if ($order->order_status==6) :?>
				    <?php if(in_array($product->goods_id, $order_product_review)):?>
				    <a class="gray" href="javascript:void(0);">已评价</a>
				    <?php else :?>
				    <a class="gw_btn" href="<?php echo site_url('order/order_reviews/'.$order->order_id.'?goods_id='.$product->goods_id);?>">去评价</a>
				    <?php endif;?>
				<?php elseif ($order->order_status==5) :?><a class="gw_btn" href="<?php echo site_url('order/order_reviews/'.$order->order_id.'?goods_id='.$product->goods_id);?>">去评价</a>
				<?php else :?>--
				<?php endif;?>
				</td>
			</tr>
			<?php endforeach;?>
		</table>
		<p class="lh20">&nbsp;</p>
		<div class="alR lh25 f14 c3">
			<p>总商品金额：¥<?php echo $order->order_shop_price;?></p>
			<p>- 优惠：¥<?php echo $order->coupon_price;?></p>
			<p>+ 运费：¥<?php echo $order->deliver_price;?></p>
			<!--  <p>- 已支付金额：¥0.00</p>-->
			<p>
				应付总额：<b class="red">¥<?php echo $order->actual_price;?></b>
			</p>
		</div>
	</div>
</div>
<?php $this->load->view('layout/footer');?>