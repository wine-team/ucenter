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
				<li class="on"><a href="<?php echo base_url('Enshrine/index');?>">收藏夹<em class="c9">(<?php echo $user_info->num_list['enshrine_num']?>)</em></a></li>
				<li><a href="<?php echo base_url('Coupon/index');?>">优惠券<em class="c9">(<?php echo $user_info->num_list['coupon_num']?>)</em></a></li>
				<li><a href="<?php echo base_url('Address/index');?>">收货地址</a></li>
				<li><a href="<?php echo base_url('Ucenter/pay_points');?>">我的积分<em class="c9">(<?php echo $user_info->num_list['pay_points_num']?>)</em></a></li>
				<li><a href="<?php echo base_url('Ucenter/user_info');?>">帐户信息</a></li>
			</ul>
		</div>
		<div class="ubgw">
			<h2 class="lr_bl">我的收藏(<?php echo $user_info->num_list['enshrine_num']?>)</h2>
			<ul class="fav_a">
                <?php foreach($goods as $g) :?>
				<li>
				    <a href="<?php $g->goods_id;?>" class="dn_au" target="_blank">
				        <?php $img_arr=explode('|', $g->goods_img);?>
						<img src="<?php echo $this->config->images_url.$img_arr[0];?>" width="200" height="200">
						<p><?php echo $g->goods_name;?></p>
						<p>
							<b class="red f14">¥<?php echo $g->promote_price;?></b>
							<del class="ml10"><?php echo $g->market_price;?></del>
						</p>
    				</a>
    				<a href="javascript:;" class="del_fava" onClick="delfav(<?php $g->goods_id;?>)">删除</a>
				</li>
                <?php endforeach;?>
			</ul>
			<div class="page" id="pager">
				<span class="yemr">总计<b><?php echo $user_info->num_list['enshrine_num']?></b> 条记录
				</span>
			</div>
		</div>

	</div>


<?php $this->load->view('layout/footer');?>		