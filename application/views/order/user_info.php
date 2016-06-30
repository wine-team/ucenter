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
				<li><a href="<?php echo base_url('Ucenter/pay_points');?>">我的积分<em class="c9">(<?php echo $user_info->num_list['pay_points_num']?>)</em></a></li>
				<li class="on"><a href="<?php echo base_url('Ucenter/user_info');?>">帐户信息</a></li>
			</ul>
		</div>
		<div class="ubgw">

			<div class="lr_bl">基本资料</div>
			<p class="bb_line"></p>
			<p class="lh30">&nbsp;</p>
			<div id="avatar" class="yu_bg hid mb20">
				<form name="photo" enctype="multipart/form-data" action="<?php echo base_url('Ucenter/edit_photo');?>" method="post" class="lh35">
					<table width="500" border="0">
						<tr>
							<td width="50"><b class="c3">选择照片：</b></td>
							<td width="150"><input type="file" name="photo" size="30" class="ft" /></td>
						</tr>
					</table>
					<h2 class="c3 cmca">或者选择现有头像</h2>
					<ul class="imgUl" id="mgul">
					    <?php foreach (user_photo() as $photo) :?>
						<li><img src="<?php echo $this->config->images_url.$photo?>" path='<?php echo $photo;?>' width="50" height="50"></li>
						<?php endforeach;?>
					</ul>
					<input type="hidden" name="user_photo" value="" id="avatarImg">
					<input type="button" class="mt10 redb" value="取消" style="background-color: #999; padding: 0 30px;" onClick="togava()" /> 
					<input type="submit" name="upload" class="mt10 redb" value="保存" style="padding: 0 30px;" />
				</form>
			</div>

			<form method="post" action="<?php echo base_url('Ucenter/edit_user_info');?>" name="formEdit" id="user_info">
				<table width="100%" class="td_p" border="0">
					<tbody>
						<tr>
							<td width="80">头像</td>
							<td class="lh20" valign="top">
							    <img width="70" height="70" src="<?php echo $this->config->images_url.$user_info->photo;?>" />
							    <a href="javascript:;" class="c3 pl10" onClick="togava()">修改头像</a>
						    </td>
						</tr>
						<tr>
							<td>用户名：</td>
							<td><input type="text" name="alias_name" required="required" maxlength=20 id="user_name" value="<?php echo $user_info->alias_name;?>" class="ipt" size="25" /></td>
						</tr>
						<tr>
							<td>生日：</td>
							<td><input type="text" name="birthday" id="birthday" value="<?php echo $user_info->birthday;?>" class="ipt" size="25" /></td>
						</tr>
						<tr>
							<td>性别：</td>
							<td>
							    <input type="radio" name="sex" value="0" required="required" <?php if($user_info->sex==0) echo 'checked="checked"';?> />保密&nbsp;&nbsp;
								<input type="radio" name="sex" value="1" required="required" <?php if($user_info->sex==1) echo 'checked="checked"';?>/>男&nbsp;&nbsp; 
								<input type="radio" name="sex" value="2" required="required" <?php if($user_info->sex==2) echo 'checked="checked"';?>/>女&nbsp;&nbsp;
							</td>
						</tr>
						<tr>
							<td>邮箱:</td>
							<td><input type="text" name="email" required="required" maxlength=50 id="email" value="<?php echo $user_info->email;?>" class="ipt" size="25" /></td>
						</tr>
						<tr>
							<td>手机：</td>
							<td><input type="text" name="phone" required="required" maxlength=11 id="mobile"value="<?php echo $user_info->phone;?>" class="ipt" size="25" /></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<input type="submit" class="b_sub b_green" value="确认修改" name="submit" />
							</td>
						</tr>
					</tbody>
				</table>
			</form>

			<p class="lh30">&nbsp;</p>
			<p class="lh30">&nbsp;</p>

			<div class="lr_bl">修改密码</div>
			<p class="bb_line"></p>
			<p class="lh30">&nbsp;</p>

			<form method="post" action="<?php echo base_url('Ucenter/reset_password');?>" id="formPassword">
				<table width="100%" class="td_p" border="0">
					<tbody>
						<tr>
							<td width="80">原密码：</td>
							<td><input type="password" id="pas1" class="ipt" size="25" name="old_password" /></td>
						</tr>
						<tr>
							<td>新密码：</td>
							<td><input type="password" id="pas2" class="ipt" size="25" name="new_password" /></td>
						</tr>
						<tr>
							<td>确认密码：</td>
							<td><input type="password" id="pas3" class="ipt" size="25" name="comfirm_password" /></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<input type="submit" value="确认修改" class="b_sub b_green" name="submit" />
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>

		
		<script>
			
			$("#birthday").date_input();
			function togava() {
				$("#avatar").stop().slideToggle(300);
			}
			$("#mgul").delegate("li", "click", function() {
				if ($(this).hasClass("on")) {
					$(this).removeClass("on");
					$("#avatarImg").val("mobile");
					return;
				}
				$(this).addClass("on").siblings("li").removeClass("on");
				var v = $(this).find("img").attr("path");
				$("#avatarImg").val(v);
			});
			
			function epd() {
				var n1 = $("#pas1").val();
				var n2 = $("#pas2").val();
				var n3 = $("#pas3").val();
				if (n1.length < 5 || n2.length < 5 || n3.length < 5) {
					alert("原始密码、新密码及确认密码都不得少于5位");
					return false;
				}
				if (n2 != n3) {
					alert("两次输入的密码不一致，请仔细检查。");
					return false;
				}
			}
		</script>
	</div>




<?php $this->load->view('layout/footer');?>	