<?php $this->load->view('layout/header');?>
<div class="w" id="content">
	<div class="u_top">
	   <?php $this->load->view('layout/menu');?>
	</div>
	<div class="ubgw enshrine">
		<h2 class="lr_bl">我的收藏(<?php echo $user_info->num_list['enshrine_num'];?>)</h2>
		<ul class="fav_a">
            <?php foreach($goods as $g) :?>
				<li>
			   		<a href="<?php echo $this->config->main_base_url.'goods/detail.html?goods_id='.$g->goods_id;?>" class="dn_au" target="_blank">
				        <?php $img = array_filter(explode('|', $g->goods_img));?>
						<img src="<?php echo $this->config->show_image_thumb_url('mall',$img[0],360);?>" width="200" height="200">
						<p><?php echo $g->goods_name;?></p>
						<p>
							<b class="red f14">¥<?php echo $g->promote_price;?></b>
							<del class="ml10"><?php echo $g->market_price;?></del>
						</p>
	    			</a>
	    			<a href="<?php echo site_url('enshrine/delete?goods_id='.$g->goods_id);?>" class="del_fava">删除</a>
				</li>
            <?php endforeach;?>
		</ul>
		<div class="page" id="pager">
			<span class="yemr">总计<b><?php echo $sum;?></b> 条记录</span>
			<?php echo $link;?>
		</div>
	</div>
</div>
<?php $this->load->view('layout/footer');?>		