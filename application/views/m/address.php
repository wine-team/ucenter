<?php $this->load->view('m/layout/header');?>
<div id="top">
	<div class="header">
		<a href="javascript:goback();" class="b_l"></a>
		<h2>设置</h2>
		<a href="<?php echo site_url('m/Address/add');?>"  class="b_r">添加地址</a>
	</div>
</div>
<div class="pageauto">
	<div class="min-h">
		<ul class="s_h">
		    <?php foreach ($res as $r) :?>
			<li>
				<a href="<?php echo site_url('m/Address/edit/'.$r->address_id);?>">
					<h3>
						<?php if ($r->is_default==2) :?><b class="red pr5">默认</b><?php endif;?>
						<b><?php echo $r->receiver_name;?></b> 
						<?php echo $r->province_name.' '.$r->city_name.' '.$r->district_name;?>
					</h3>
				    <p><?php echo $r->detailed;?></p>
				</a>
			</li>
			<?php endforeach;?>
		</ul>
	</div>
</div>
<?php $this->load->view('m/layout/smallfooter');?>
<?php $this->load->view('m/layout/footer');?>