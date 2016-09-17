<?php $this->load->view('layout/header');?>
<div class="w" id="content">
	<div class="u_top">
	   <?php $this->load->view('layout/menu');?>
	</div>

	<div class="ubgwn">
		<ul class="u_q clearfix">
			<li class="first <?php if(empty($this->input->get('status'))) echo 'on';?>"><a href="<?php echo site_url('order/index');?>">全部订单</a></li>
			<li class="<?php if($this->input->get('status')==2) echo 'on';?>"><a href="<?php echo site_url('order/index?status=2');?>">等付款</a></li>
			<li class="<?php if($this->input->get('status')==4) echo 'on';?>"><a href="<?php echo site_url('order/index?status=4');?>">查物流</a></li>
			<li class="<?php if($this->input->get('status')==5) echo 'on';?>"><a href="<?php echo site_url('order/index?status=5');?>">待评价</a></li>
			<li class="<?php if($this->input->get('status')==6) echo 'on';?>"><a href="<?php echo site_url('ucenter/user_reviews?status=6');?>">已评价</a></li>
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