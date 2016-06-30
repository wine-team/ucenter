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
				<li class="on"><a href="<?php echo base_url('User_coupon/index');?>">优惠券<em class="c9">(<?php echo $user_info->num_list['coupon_num']?>)</em></a></li>
				<li><a href="<?php echo base_url('Address/index');?>">收货地址</a></li>
				<li><a href="<?php echo base_url('Ucenter/pay_points');?>">我的积分<em class="c9">(<?php echo $user_info->num_list['pay_points_num']?>)</em></a></li>
				<li><a href="<?php echo base_url('Ucenter/user_info');?>">帐户信息</a></li>
			</ul>
		</div>
		<div class="ubgwn">
			<ul class="u_q clearfix">
				<li class="first <?php if(!$this->input->get('status')) echo 'on';?>"><a href="<?php echo base_url('User_coupon/index');?>">全部</a></li>
				<li class="<?php if($this->input->get('status')==1) echo 'on';?>"><a href="<?php echo base_url('User_coupon/index?status=1');?>">可使用</a></li>
				<li class="<?php if($this->input->get('status')==2) echo 'on';?>"><a href="<?php echo base_url('User_coupon/index?status=2');?>">已使用</a></li>
				<li class="<?php if($this->input->get('status')==3) echo 'on';?>"><a href="<?php echo base_url('User_coupon/index?status=3');?>">过期</a></li>
			</ul>
		</div>

		<div class="ubgw">
			<div class="over">
                <?php foreach($user_coupon as $coupon) :?>
				<div class="u_bone <?php if($coupon->status > 1)echo 'u_old';?>">
					<div class="over u_btp">
						<div class="left">
							￥<b class="f30"><?php echo $coupon->amount;?></b>
						</div>
						<em class="right"><?php echo $coupon_status[$coupon->status];?></em>
					</div>
					<p>活动名称：<?php echo $coupon->coupon_name;?></p>
					<p>使用条件：购物满<?php echo $coupon->condition;?></p>
					<p>有效时间：<?php echo $coupon->start_time;?> - <?php echo $coupon->end_time;?></p>
				</div>
				<?php endforeach;?>
			</div>


			<div class="page" id="pager">
				<span class="yemr">总计<b><?php echo count($user_coupon);?></b> 条记录
				</span>
			</div>

			<div class="lh20">
				<p class="bline"></p>
				<p>&nbsp;</p>
				<b>温馨提示：</b>
				<p>1.订单商品金额满足优惠劵要求即可使用；</p>
				<p>2.优惠劵不兑现金、不可赠送；</p>
				<p>3.请在优惠劵期限内使用，过期无效；</p>
				<p>4.优惠券在购物车结算时，用作现金抵扣。不同类型的优惠券的使用范围也不同，结算金额必须达到“最小订单金额”才可以使用。</p>
			</div>

			<form onsubmit="return addBonus()" method="post" action="user.php" name="addBouns" class="hid">
				<span class="pr10 left mt5">优惠券序列号:</span> 
				<input type="text" class="inputTx left mr10" size="30" name="bonus_sn" /> 
				<input type="hidden" class="inputTx" value="act_add_bonus" name="act" /> 
				<input type="submit" value="添加优惠券" class="redb left" style="margin-top: 2px;" />
		
		  </form>

	</div>


<?php $this->load->view('layout/footer');?>		