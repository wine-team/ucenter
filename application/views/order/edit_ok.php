<?php $this->load->view('layout/header');?>
<div class="bgf2">
	<div class="w" id="content">
		<div class="ts_bg yahei">
			<div class="ts_r">
				<!--<img src="http://s.qw.cc/themes/v4/css/ft/t_r.png" width="209" height="110" class="ft_rr">-->
				<h1 class="t_warn">WARNING</h1>
				<div class="t_wo">您的个人资料已经成功修改！</div>
				<div class="t_link over">
					<a href="<?php echo $this->config->main_base_url;?>" class="bblue">回首页</a> 
					<a href="<?php echo site_url('Ucenter/user_info');?>">返回上一页</a>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('layout/footer');?>			