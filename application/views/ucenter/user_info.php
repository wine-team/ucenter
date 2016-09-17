<?php $this->load->view('layout/header');?>
<div class="w" id="content">
	<div class="u_top">
	   <?php $this->load->view('layout/menu');?>
	</div>
	<div class="ubgw">
		<div class="lr_bl">基本资料</div>
		<p class="bb_line"></p>
		<p class="lh30">&nbsp;</p>
		<div id="avatar" class="yu_bg hid mb20">
			<form  enctype="multipart/form-data" action="<?php echo site_url('ucenter/edit_photo');?>" method="post" class="lh35">
				<table width="500" border="0">
					<tr>
						<td width="50"><b class="c3">选择照片：</b></td>
						<td width="150"><input type="file" name="photo" size="30" class="ft" /></td>
					</tr>
				</table>
				<h2 class="c3 cmca">或者选择现有头像</h2>
				<ul class="imgUl" id="mgul">
				    <?php foreach (user_photo() as $photo) :?>
						<li>
							<img src="<?php echo $this->config->show_image_url('common/touxiang',$photo);?>" path='<?php echo $photo;?>' width="50" height="50" />
						</li>
					<?php endforeach;?>
				</ul>
				<input type="hidden" name="user_photo" value="<?php echo $user_info->photo;?>"/>
				<input type="button" class="mt10 redb togava" value="取消" /> 
				<input type="submit" name="upload" class="mt10 redb" value="保存" />
			</form>
		</div>

		<form  class="user-info">
			<table width="100%" class="td_p" border="0">
				<tbody>
					<tr>
						<td width="80">头像</td>
						<td class="lh20" valign="top">
						    <img width="70" height="70" src="<?php echo $this->config->show_image_url('common/touxiang',$user_info->photo);?>" />
						    <a href="javascript:;" class="c3 pl10 togava">修改头像</a>
					    </td>
					</tr>
					<tr>
						<td><b class="red pr5">*</b>用户名：</td>
						<td><input type="text" name="alias_name" required="required" maxlength=20 id="user_name" value="<?php echo $user_info->alias_name;?>" class="ipt" size="25" /></td>
					</tr>
					<tr>
						<td><b class="red pr5">*</b>生日：</td>
						<td><input type="text" name="birthday" value="<?php echo $user_info->birthday;?>" class="ipt birthday" size="25" /></td>
					</tr>
					<tr>
						<td><b class="red pr5">*</b>性别：</td>
						<td>
						    <input type="radio" name="sex" value="0" required="required" <?php if($user_info->sex==0) echo 'checked="checked"';?> />保密&nbsp;&nbsp;
							<input type="radio" name="sex" value="1" required="required" <?php if($user_info->sex==1) echo 'checked="checked"';?>/>男&nbsp;&nbsp; 
							<input type="radio" name="sex" value="2" required="required" <?php if($user_info->sex==2) echo 'checked="checked"';?>/>女&nbsp;&nbsp;
						</td>
					</tr>
					<tr>
						<td><b class="red pr5">*</b>邮箱:</td>
						<td><input type="text" name="email" required="required" maxlength=50 id="email" value="<?php echo $user_info->email;?>" class="ipt" size="25" /></td>
					</tr>
					<tr>
						<td><b class="red pr5">*</b>手机：</td>
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
		<form  class="formPassword">
			<table width="100%" class="td_p" border="0">
				<tbody>
					<tr>
						<td width="80"><b class="red pr5">*</b>原密码：</td>
						<td><input type="password" id="pas1" class="ipt" size="25" name="old_password" /></td>
					</tr>
					<tr>
						<td><b class="red pr5">*</b>新密码：</td>
						<td><input type="password" id="pas2" class="ipt" size="25" name="new_password" maxlenght=20 /></td>
					</tr>
					<tr>
						<td><b class="red pr5">*</b>确认密码：</td>
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
</div>
<?php $this->load->view('layout/footer');?>	