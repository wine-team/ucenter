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
				<li class="first <?php if(empty($this->input->get('status'))) echo 'on';?>"><a href="<?php echo base_url('Ucenter/index');?>">全部订单</a></li>
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
					<th width="200">商品</th>
					<th>评论内容</th>
					<th width="120">评论时间</th>
					<th width="60">状态</th>
				</tr>
				<?php foreach($user_reviews as $reviews) :?>
				<tr>
				    <td><?php echo $reviews->goods_name;?></td>
				    <td><?php echo $reviews->content;?></td>
				    <td><?php echo $reviews->created_at;?></td>
				    <td><?php echo $reviews_status[$reviews->status];?></td>
				</tr>
				<?php endforeach;?>
			</table>
			<div class="page" id="pager"></div>
		</div>

	</div>


<?php $this->load->view('layout/footer');?>	