<?php $this->load->view('layout/header');?>
<div class="w" id="content">
	<div class="u_top">
	   <?php $this->load->view('layout/menu');?>
	</div>
	<div class="ubgw">
		<h2 class="lr_bl">新增收货地址</h2>
		<p class="bb_line"></p>
		<form class="address-form">
			<table width="100%" border="0" class="td_p">
				<tbody>
					<tr>
						<td align="right" width="100"><b class="red pr5">*</b>收货人姓名：</td>
						<td>
						    <input type="hidden" name="address_id" value="<?php echo isset($res->address_id) ? $res->address_id : '';?>">
						    <input type="text" value="<?php echo isset($res->receiver_name) ? $res->receiver_name : '';?>" id="consignee" class="ipt" name="receiver_name" required="required" maxlength=20 />
						</td>
					</tr>
					<tr>
						<td align="right"><b class="red pr5">*</b>省市区：</td>
						<td id="district"><?php $this->load->view('layout/districtSelect');?> </td>
					</tr>
					<tr>
						<td align="right"><b class="red pr5">*</b>详细地址：</td>
						<td>
						    <input type="text" value="<?php echo isset($res->detailed) ? $res->detailed : '';?>" id="address" class="ipt" size="80" name="detailed" placeholder="镇、街道、小区名、门牌号" required="required" maxlength=50 />
						</td>
					</tr>
					<tr>
						<td align="right"><b class="red pr5">*</b>手机：</td>
						<td>
						    <input type="text" value="<?php echo isset($res->tel) ? $res->tel : '';?>" id="mobile" class="ipt" name="tel" required="required" maxlength=11 />
						</td>
					</tr>
					<tr>
						<td align="right" class="c9">邮政编码：</td>
						<td>
						    <input type="text" value="<?php echo isset($res->code) ? $res->code : '';?>" id="zipcode" class="ipt" name="code" />
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>
						    <label><input name="is_default" type="checkbox" value="2" <?php if(isset($res->is_default) && $res->is_default==2)echo 'checked="checked"';?>/> 设置为默认收货地址</label>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>
							<input type="submit" value="确认提交" class="b_sub hand"/>
							<p class="lh30">&nbsp;</p>
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
    <?php if($address->num_rows()>0):?>
	<div class="ubgw">
		<div class="lr_bl over">
			<em class="left">全部收货地址</em>
		</div>
		<p class="bb_line"></p>
		<table width="100%" border="0" class="u_otb mt15">
			<tr>
				<th>收货人</th>
				<th>详细地址</th>
				<th>电话/手机</th>
				<th>操作</th>
			</tr>
			<?php foreach($address->result() as $a) :?>
			<tr>
				<td><em class="f14"><?php echo $a->receiver_name;?></em></td>
				<td><?php echo $a->province_name.' '.$a->city_name.' '.$a->district_name.' '.$a->detailed;?></td>
				<td><?php echo $a->tel;?></td>
				<td>
				    <a href="<?php echo site_url('Address/index?address_id='.$a->address_id);?>" title="修改当前记录" class="blue">修改</a> 
					<span class="vline">|</span>
					<a href="<?php echo site_url('Address/delete?address_id='.$a->address_id);?>" class="blue" onclick="return confirm('你确认要删除该收货地址吗？');">删除</a>
					<?php if($a->is_default==1) :?>
					<a class="rw_btn ml5" onclick="return confirm('你确认要设置为默认收货地址吗？');" href="<?php echo site_url('Address/setDefault?address_id='.$a->address_id);?>">设为默认</a>
					<?php else:?>
					<b class="red pl5">当前默认地址</b>
					<?php endif;?>
				</td>
			</tr>
			<?php endforeach;?>
		</table>
	</div>
	<?php endif;?>
</div>
<?php $this->load->view('layout/footer');?>	