<?php $this->load->view('layout/header');?>

	<div class="w" id="content">
		<div class="u_top">
			<?php $this->load->view('layout/menu');?>
		</div>


		<div class="ubgw">
			<div class="over">
				<h2 class="lr_bl left">订单<?php echo $order_main_sn;?>的物流信息</h2>
				<a href="<?php echo site_url('order/order_detail/'.$order_id);?>" class="blue right">《返回订单</a>
			</div>
			<div class="wuliu_bg lh25" id="wuliu">
			<?php if(!empty($deliver_order)) :?>
			
			<?php else :?>
			暂时没有查询到相关信息！
			<?php endif;?>
			</div>
			<p class="lh30">&nbsp;</p>
			<p class="mt10 c9">
				本页面物流查询信息由快递公司提供<br>物流快递信息有可能存在延迟，可能会导致您的物流信息长时间没有更新，敬请耐心等待。（延迟时间可能从1天到3天不等，EMS快递的物流配送信息可能最多可能有1周左右延迟）
			</p>
		</div>

	</div>

<?php $this->load->view('layout/footer');?>