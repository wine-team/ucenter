<?php $this->load->view('layout/header');?>
<style>
.black_tp {
	height: 48px;
	line-height: 48px;
	width: 100%;
	overflow: hidden;
	zoom: 1;
	background-color: #31302f;
	padding: 10px 0;
}

.ga_a {
	color: #959494;
	padding-left: 15px;
	font-size: 14px;
}

.ts_bg {
	background: url(http://s.qw.cc/themes/v4/css/ft/t_l.jpg) 0 50% no-repeat;
	height: 260px;
	padding: 120px 0 150px 520px;
	position: relative;
	overflow: hidden;
}

.t_warn {
	background: url(http://s.qw.cc/themes/v4/css/ft/t_t.png) 0 50% no-repeat;
	padding-left: 60px;
	line-height: 44px;
	height: 44px;
	color: #c40000;
	font-size: 40px;
}

.t_wo {
	font-size: 20px;
	color: #333;
	line-height: 25px;
	margin-top: 25px;
}

.ts_r {
	border-left: 1px solid #e5e5e5;
	padding: 30px 0 0 30px;
	position: relative;
}

.ft_ma {
	position: absolute;
	left: -160px;
}

.ft_rr {
	position: absolute;
	top: 0;
	left: 400px;
}

.t_link a {
	height: 42px;
	line-height: 42px;
	color: #fff;
	float: left;
	font-size: 14px;
	background-color: #00c148;
	padding: 0 30px;
	display: inline;
	margin: 20px 10px 0 0;
}

.t_link a.bblue {
	background-color: #31a5ef;
}

.t_link a:hover {
	background-color: #c40000;
	text-decoration: none;
}
</style>


	<div class="bgf2">
		<div class="w" id="content">
			<div class="ts_bg yahei">
				<div class="ts_r">
					<!--<img src="http://s.qw.cc/themes/v4/css/ft/t_r.png" width="209" height="110" class="ft_rr">-->
					<h1 class="t_warn">WARNING</h1>
					<div class="t_wo">您的个人资料已经成功修改！</div>
					<div class="t_link over">
						<a href="<?php echo $this->config->main_base_url;?>" class="bblue">回首页</a> <a
							href="<?php echo base_url('Ucenter/user_info');?>">返回上一页</a>
					</div>
				</div>
			</div>
		</div>
	</div>


<?php $this->load->view('layout/footer');?>			