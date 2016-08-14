
<div class="u_zone over url" base-href="<?php echo $this->config->main_base_url;?>">
	<a href="<?php echo site_url('Ucenter/user_info');?>" class="u_ava">
	    <img src="<?php echo $this->config->show_image_url('common/touxiang',$user_info->photo);?>" width="70" height="70" class="left" />
		<div class="over pt10">
			<b class="left"><?php echo $user_info->alias_name;?></b>
			<!-- <em class="vip v1"></em> -->
		</div>
		<!--<p>享受全场<i class="red">9.8</i>折优惠</p>-->
	</a> 
</div>
<ul id="u_nav" class="over yahei">
    <?php $action = $this->router->fetch_class();?>
    <?php $method = $this->router->fetch_method();?>
    <?php $url = ($action.'/'.$method);?>
    <li <?php if($url=="Ucenter/index"):?>class="on"<?php endif;?>>
    	<a href="<?php echo site_url('Ucenter/index');?>">全部订单<em class="c9">(<?php echo $user_info->num_list['order_num']?>)</em></a>
    </li>
	<li <?php if($url=="Enshrine/index"):?>class="on"<?php endif;?>>
		<a href="<?php echo site_url('Enshrine/index');?>">收藏夹<em class="c9">(<?php echo $user_info->num_list['enshrine_num']?>)</em></a>
	</li>
	<li <?php if($url=="User_coupon/index"):?>class="on"<?php endif;?>>
		<a href="<?php echo site_url('User_coupon/index');?>">优惠券<em class="c9">(<?php echo $user_info->num_list['coupon_num']?>)</em></a>
	</li>
	<li <?php if($url=="Ucenter/pay_points"):?>class="on"<?php endif;?>>
		<a href="<?php echo site_url('Ucenter/pay_points');?>">我的积分<em class="c9">(<?php echo $user_info->num_list['pay_points_num']?>)</em></a>
	</li>
	<li <?php if($url=="Address/index"):?>class="on"<?php endif;?>>
		<a href="<?php echo site_url('Address/index');?>">收货地址</a>
	</li>
	<li <?php if($url=="Ucenter/user_info"):?>class="on"<?php endif;?>>
		<a href="<?php echo site_url('Ucenter/user_info');?>">帐户信息</a>
	</li>
</ul>
