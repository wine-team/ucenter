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
				<li><a href="<?php echo base_url('Ucenter/index');?>">全部订单<em class="c9">(<?php echo $user_info->num_list['order_num']?>)</em></a></li>
				<li><a href="<?php echo base_url('Enshrine/index');?>">收藏夹<em class="c9">(<?php echo $user_info->num_list['enshrine_num']?>)</em></a></li>
				<li><a href="<?php echo base_url('Coupon/index');?>">优惠券<em class="c9">(<?php echo $user_info->num_list['coupon_num']?>)</em></a></li>
				<li><a href="<?php echo base_url('Address/index');?>">收货地址</a></li>
				<li class="on"><a href="<?php echo base_url('Ucenter/pay_points');?>">我的积分<em class="c9">(<?php echo $user_info->num_list['pay_points_num']?>)</em></a></li>
				<li><a href="<?php echo base_url('Ucenter/user_info');?>">帐户信息</a></li>
			</ul>
		</div>



		<div class="ubgw">
			<div class="lr_bl over">
				<em class="left">我的积分/等级</em><a class="gray f12 right" href="/article-9.html" target="_blank">怎么获得积分？积分及会员等级规则!</a>
			</div>
			<p class="bb_line"></p>
			<p class="lh30">&nbsp;</p>
			<div class="yu_bg f14">
				<p>
					剩余消费积分:<b class="c3"><?php echo $user_info->pay_points;?></b>, <a href="/exchange.php" class="blue">去积分商城看看</a>
				</p>
				<p>
					再获得500积分即可升级为V2，可享受全场<b class="red">9.5</b>折
				</p>
			</div>

			<p class="lh30">&nbsp;</p>
			<div class="lr_bl over">
				<em class="left">积分记录</em><em class="c9 f12 right">总计 <?php echo $points_num;?>个记录</em>
			</div>
			<p class="bb_line"></p>
			<table width="100%" border="0" class="u_otb mt15">
				<tr>
					<th>等级积分</th>
					<th>消费积分</th>
					<th>获得日期</th>
					<th>详细说明</th>
				</tr>
				<?php foreach($points_list as $list) :?>
				<tr>
				    <td></td>
				    <td><?php echo $list->amount;?></td>
				    <td><?php echo $list->created_at;?></td>
				    <td><?php echo $list->note;?></td>
				</tr>
				<?php endforeach;?>
			</table>

			<div class="page" id="pager"></div>
			<p class="lh30">&nbsp;</p>
			<p class="lr_bl">会员等级说明</p>
			<table width="600" border="0" class="td_p">
				<tr>
					<td>V1会员</td>
					<td><em class="c9">累积积分：</em>1-499</td>
					<td>享受全场<b class="red">9.8</b>折优惠
					</td>
					<td>邮费：15元</td>
				</tr>
				<tr>
					<td>V2会员</td>
					<td><em class="c9">累积积分：</em>500-1999</td>
					<td>享受全场<b class="red">9.5</b>折优惠
					</td>
					<td>邮费：12元</td>
				</tr>
				<tr>
					<td>V3会员</td>
					<td><em class="c9">累积积分：</em>2000-9999</td>
					<td>享受全场<b class="red">9.2</b>折优惠
					</td>
					<td>邮费：8元</td>
				</tr>
				<tr>
					<td>V4会员</td>
					<td><em class="c9">累积积分：</em>10000以上</td>
					<td>享受全场<b class="red">8.8</b>折优惠
					</td>
					<td>邮费：<b class="red">免费</b></td>
				</tr>
			</table>
		</div>




	</div>

<?php $this->load->view('layout/footer');?>	