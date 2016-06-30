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
				<li><a href="<?php echo base_url('User_coupon/index');?>">优惠券<em class="c9">(<?php echo $user_info->num_list['coupon_num']?>)</em></a></li>
				<li><a href="<?php echo base_url('Address/index');?>">收货地址</a></li>
				<li><a href="<?php echo base_url('Ucenter/pay_points');?>">我的积分<em class="c9">(<?php echo $user_info->num_list['pay_points_num']?>)</em></a></li>
				<li><a href="<?php echo base_url('Ucenter/user_info');?>">帐户信息</a></li>
			</ul>
		</div>

		<div class="ubgwn">
			<ul class="u_q clearfix">
				<li class="first <?php if(!$this->input->get('status')) echo 'on';?>"><a href="<?php echo base_url('Ucenter/index');?>">全部订单</a></li>
				<li class="<?php if($this->input->get('status')==2) echo 'on';?>"><a href="<?php echo base_url('Ucenter/index?status=2');?>">等付款</a></li>
				<li class="<?php if($this->input->get('status')==4) echo 'on';?>"><a href="<?php echo base_url('Ucenter/index?status=4');?>">查物流</a></li>
				<li class="<?php if($this->input->get('status')==5) echo 'on';?>"><a href="<?php echo base_url('Ucenter/index?status=5');?>">待评价</a></li>
				<li class="<?php if($this->input->get('status')==6) echo 'on';?>"><a href="<?php echo base_url('Ucenter/user_reviews?status=6');?>">已评价</a></li>
				<li class="last"><em class="f12 c9">共<?php echo $user_info->num_list['order_num']?>个订单</em></li>
			</ul>
		</div>
		<div class="ubgw">
			<table width="100%" border="0" class="u_otb mt15">
				<tr>
					<th>订单商品</th>
					<th>订单编号</th>
					<th>下单日期</th>
					<th>总金额/数量</th>
					<th>订单状态</th>
					<th>操作</th>
				</tr>
				<?php foreach($order as $o) :?>
				<tr>
					<td>
					   <?php $i=0;?>
					   <?php foreach ($order_product as $product) :?>
					   <?php if ($product->order_id == $o->order_id) :?>
					   <a title="<?php echo $product->goods_name?>" target="_blank" href="<?php echo $product->goods_id?>"> 
					       <img class="mr5" width="60" height="60" src="<?php echo $this->config->images_url.$product->goods_img;?>">
                       </a>
                       <?php $i ++;?>
                       <?php endif;?>
                       <?php if($i > 1) break;?>
                       <?php endforeach;?>
					</td>
					<td><?php echo $o->order_id;?></td>
					<td><em class="c9"><?php echo $o->created_at?></em></td>
					<td>
						<p>
						<p class="c9">￥<?php echo $o->actual_price;?>（邮费：￥<?php echo $o->deliver_price;?>）</br>共<?php echo count($order_product);?>件</p>
					</td>
					<td><b class="green"><?php echo $status_arr[$o->status];?></b></td>
					<td><a class="rw_btn" href="<?php echo base_url('Ucenter/order_detail/'.$o->order_id);?>">查看订单</a></td>
				</tr>
				<?php endforeach;?>
			</table>
			<div class="page" id="pager"></div>
		</div>

		<div class="ubgw">
			<h2 class="lr_bl">根据浏览，猜您喜欢</h2>
			<p class="bline"></p>
			<div class="over dn_aw">
				<a href="goods-9181.html" target="_blank" title="MOVO 冰爽型夫妻情趣男女用润滑液100ml" class="dn_au">
				    <img width="200" height="200" src="http://s.qw.cc/images/201605/thumb_img/9181_thumb_P220_1462353389936.jpg" />
				    <p>MOVO 冰爽型夫妻情趣男女用润滑液100ml</p>
					<p class="xj"> ¥145.04</span></p>
				</a> 
				<a href="goods-9131.html" target="_blank" title="MOVO 女用欲望型情趣润滑液100ml" class="dn_au">
					<img width="200" height="200" src="http://s.qw.cc/images/201604/thumb_img/9131_thumb_P220_1459842728266.jpg" />
				    <p>MOVO 女用欲望型情趣润滑液100ml</p>
					<p class="xj"> ¥125.44</span></p>
				</a> 
				<a href="goods-9118.html" target="_blank" title="韩国ZINI 御雪红而天然嫩美乳霜 35ml" class="dn_au">
					<img width="200" height="200" src="http://s.qw.cc/images/201603/thumb_img/9118_thumb_P220_1456997332734.jpg" />
				    <p>韩国ZINI 御雪红而天然嫩美乳霜 35ml</p>
					<p class="xj"> ¥292.04</span></p>
				</a> 
				<a href="goods-9108.html" target="_blank" title="雅迪克 华夏古方秘制延时喷剂 15ml" class="dn_au">
					<img width="200" height="200" src="http://s.qw.cc/images/201602/thumb_img/9108_thumb_P220_1456304222764.jpg" />
				    <p>雅迪克 华夏古方秘制延时喷剂 15ml</p>
					<p class="xj">¥194.04</span></p>
				</a> 
				<a href="goods-9038.html" target="_blank" title="恰然国际SECWELL 二代可儿7种语音互动式智能触感飞机杯" class="dn_au">
					<img width="200" height="200" src="http://s.qw.cc/images/201601/thumb_img/9038_thumb_P220_1453109333349.jpg" />
				    <p>恰然国际SECWELL 二代可儿7种语音互动式智能触感飞机杯</p>
					<p class="xj">¥293.02</span></p>
				</a>
			</div>
		</div>

	</div>

<?php $this->load->view('layout/footer');?>