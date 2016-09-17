<?php $this->load->view('layout/header');?>
<div class="w" id="content">
	<div class="u_top">
	   <?php $this->load->view('layout/menu');?>
	</div>
	<div class="ubgw">
		<div class="lr_bl over">
			<em class="left">我的积分</em><a class="gray f12 right" href="<?php echo $this->config->help_url;?>" target="_blank">怎么获得积分,积分规则？</a>
		</div>
		<p class="bb_line"></p>
		<p class="lh30">&nbsp;</p>
		<div class="yu_bg f14">
			<p>
				剩余消费积分:<b class="c3"><?php echo $user_info->pay_points;?></b>, 
				<a href="<?php echo $this->config->main_base_url;?>" class="blue" target="_blank">去妙处网看看呗</a>
			</p>
			<!-- 
			<p>
				再获得500积分即可升级为V2，可享受全场<b class="red">9.5</b>折
			</p>
			 -->
		</div>

		<p class="lh30">&nbsp;</p>
		<div class="lr_bl over">
			<em class="left">积分记录</em><em class="c9 f12 right">总计 <?php echo $points_num;?> 个记录</em>
		</div>
		<p class="bb_line"></p>
		<table width="100%" border="0" class="u_otb mt15">
			<tr>
			    <th>订单号</th>
				<th>消费积分</th>
				<th>消费日期</th>
				<th>详细说明</th>
			</tr>
			<?php foreach($points_list->result() as $list) :?>
			<tr>
			    <td><?php echo $list->order_id;?></td>
			    <td><?php echo $list->amount;?></td>
			    <td><?php echo $list->created_at;?></td>
			    <td><?php echo $list->note;?></td>
			</tr>
			<?php endforeach;?>
		</table>
		<div class="page" id="pager"></div>
		<!--  
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
		-->
	</div>
</div>
<?php $this->load->view('layout/footer');?>	