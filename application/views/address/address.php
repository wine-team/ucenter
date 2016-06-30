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
				<li><a href="<?php echo base_url('User_coupon/index');?>">优惠券<em class="c9">(<?php echo $user_info->num_list['coupon_num']?>)</em></a></li>
				<li class="on"><a href="<?php echo base_url('Address/index');?>">收货地址</a></li>
				<li><a href="<?php echo base_url('Ucenter/pay_points');?>">我的积分<em class="c9">(<?php echo $user_info->num_list['pay_points_num']?>)</em></a></li>
				<li><a href="<?php echo base_url('Ucenter/user_info');?>">帐户信息</a></li>
			</ul>
		</div>


		<div class="ubgw">
			<h2 class="lr_bl">新增收货地址</h2>
			<p class="bb_line"></p>
			<form name="theForm" method="post" action="<?php echo base_url('Address/addPost');?>" id="con">
				<table width="100%" border="0" class="td_p">
					<tbody>
						<tr>
							<td align="right" width="100"><b class="red pr5">*</b>收货人姓名：</td>
							<td>
							    <input type="text" value="" id="consignee" class="ipt" name="receiver_name" required="required" maxlength=20 />
							</td>
						</tr>
						<tr>
							<td align="right"><b class="red pr5">*</b>省市区：</td>
							<td id="district"><?php $this->load->view('layout/districtSelect');?> </td>
						</tr>
						<tr>
							<td align="right"><b class="red pr5">*</b>详细地址：</td>
							<td>
							    <input type="text" value="" id="address" class="ipt" size="80" name="detailed" placeholder="镇、街道、小区名、门牌号" required="required" maxlength=50/>
							</td>
						</tr>
						<tr>
							<td align="right"><b class="red pr5">*</b>手机：</td>
							<td>
							    <input type="text" value="" id="mobile" class="ipt" name="tel" required="required" maxlength=11/>
							</td>
						</tr>
						<tr>
							<td align="right" class="c9">邮政编码：</td>
							<td>
							    <input type="text" value="" id="zipcode" class="ipt" name="code" />
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
							    <label><input name="is_default" type="checkbox" value="2" /> 设置为默认收货地址</label>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<?php if(count($address)<5) :?><input type="submit" value="确认提交" class="b_sub hand" name="submit" /><?php endif;?>
								<p class="lh30">&nbsp;</p>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>

		<div class="ubgw">
			<div class="lr_bl over">
				<em class="left">全部收货地址</em><em class="gray f12">收货人信息最多可添加五个订单的收货地址!</em>
			</div>
			<p class="bb_line"></p>
			<table width="100%" border="0" class="u_otb mt15">
				<tr>
					<th>收货人</th>
					<th>详细地址</th>
					<th>电话/手机</th>
					<th>操作</th>
				</tr>
				<?php foreach($address as $a) :?>
				<tr>
					<td><em class="f14"><?php echo $a->receiver_name;?></em></td>
					<td>中国  <?php echo $a->province_name.' '.$a->city_name.' '.$a->district_name;?></td>
					<td><?php echo $a->tel;?></td>
					<td>
					    <a href="<?php echo base_url('Address/edit?address_id='.$a->address_id);?>" title="修改当前记录" class="blue">修改</a> 
						<span class="vline">|</span>
						<a href="javascript:;" class="blue" onclick="del_address(<?php echo $a->address_id?>)">删除</a>
						<?php if($a->is_default==1) :?><a class="rw_btn ml5" onclick="set_default(<?php echo $a->address_id?>)" href="javascript:;">设为默认</a><?php endif;?>
						<?php if($a->is_default==2) :?><b class="red pl5">当前默认地址</b><?php endif;?>
					</td>
				</tr>
				<?php endforeach;?>
			</table>
		</div>

		<script> 
    		function del_address(id) {
    			if (confirm('你确认要删除该收货地址吗？')) {
    				location.href = url() +"/Address/delete?address_id="+ id;
    			}
    		}
    		function set_default(id) {
    			if (confirm('你确认要设置为默认收货地址吗？')) {
    				location.href = url() +"/Address/setDefault?address_id="+ id;
    			}
    		}
    		
    		$('form#con').submit(function(){
    			address.checkCon(this); 
        	});

    		
			
			
		</script>

	</div>


<?php $this->load->view('layout/footer');?>	