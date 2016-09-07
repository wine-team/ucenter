<?php $this->load->view('layout/header');?>
<div class="w" id="content">
	<div class="u_top">
	    <?php $this->load->view('layout/menu');?>
	</div>
	<div class="ubgwn">
		<ul class="u_q clearfix">
			<li class="first <?php if(!$this->input->get('status')):?>on<?php endif;?>">
				<a href="<?php echo site_url('ucenter/index');?>">全部订单</a>
			</li>
			<li class="<?php if($this->input->get('status')==2):?>on<?php endif;?>">
				<a href="<?php echo site_url('ucenter/index?status=2');?>">待付款</a>
			</li>
			<li class="<?php if($this->input->get('status')==4):?>on<?php endif;?>">
				<a href="<?php echo site_url('ucenter/index?status=4');?>">查物流</a>
		    </li>
			<li class="<?php if($this->input->get('status')==5):?>on<?php endif;?>">
				<a href="<?php echo site_url('ucenter/index?status=5');?>">待评价</a>
			</li>
			<li class="<?php if($this->input->get('status')==6):?>on<?php endif;?>">
				<a href="<?php echo site_url('ucenter/user_reviews?status=6');?>">已评价</a>
			</li>
			<li class="last">
				<em class="f12 c9">共<?php echo $user_info->num_list['order_num']?>个订单</em>
			</li>
		</ul>
	</div>
	<div class="ubgw">
		<table width="100%" border="0" class="u_otb mt15">
			<tr>
				<th>订单商品</th>
				<th>订单编号</th>
				<th>下单日期</th>
				<th>总金额/数量</th>
				<th>订单状态</th>
				<th>操作</th>
			</tr>
			<?php foreach($order as $o) :?>
			<tr>
				<td>
				   <?php $i=0;?>
				   <?php foreach ($order_product as $product) :?>
					   <?php if ($product->order_id == $o->order_id):?>
						   <a title="<?php echo $product->goods_name;?>" target="_blank" href="<?php echo $this->config->main_base_url.'goods/detail.html?goods_id='.$product->goods_id;?>"> 
						       <img class="mr5" width="60" height="60" src="<?php echo $this->config->show_image_thumb_url('mall',$product->goods_img,60);?>">
		                   </a>
	                       <?php $i ++;?>
                       <?php endif;?>
                       <?php if($i > 1) break;?>
                   <?php endforeach;?>
				</td>
				<td><?php echo $o->order_sn;?></td>
				<td><em class="c9"><?php echo $o->created_at?></em></td>
				<td>
					<p class="c9">￥<?php echo $o->actual_price;?>（邮费：￥<?php echo $o->deliver_price;?>）</br>共<?php echo count($order_product);?>件</p>
				</td>
				<td><b <?php if($o->status>2):?>class="green"<?php else :?>class="c9"<?php endif;?>>
				    <?php echo $status_arr[$o->status];?></b>
				    <?php if($o->status>2):?><p><a class="red" href="<?php echo site_url('ucenter/check_deliver/'.$o->order_id.'?order_main_sn='.$o->order_main_sn);?>">查询物流</a></p><?php endif;?>
				</td>
				<td><a class="rw_btn" href="<?php echo site_url('ucenter/order_detail/'.$o->order_id);?>">查看订单</a></td>
			</tr>
			<?php endforeach;?>
		</table>
		<div class="page" id="pager">
		    <span class="yemr">总计<b><?php echo $sum;?></b>条记录</span>
            <?php echo $link;?>
		</div>
	</div>
	
	<?php if (!empty($like)&&($like->num_rows()>0)):?>
	<div class="ubgw guess-like">
		<h2 class="lr_bl">根据浏览，猜您喜欢</h2>
		<p class="bline"></p>
		<div class="over dn_aw">
		    <?php foreach ($like->result() as $val):?>
			    <a href="<?php echo $this->config->main_base_url.'goods/detail.html?goods_id='.$val->goods_id;?>" target="_blank" title="<?php echo $val->goods_name;?>" class="dn_au">
					<?php $img = array_filter(explode('|',$val->goods_img));?>
					<img width="200" height="200" src="<?php echo $this->config->show_image_thumb_url('mall',$img[0],360);?>" />
					<p><?php echo $val->goods_name;?></p>
					<p class="xj">¥<?php echo $val->promote_price;?></p>
				</a>
			<?php endforeach;?>
		</div>
	</div>
	<?php endif;?>
</div>
<?php $this->load->view('layout/footer');?>