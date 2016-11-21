<?php $this->load->view('layout/header');?>
<div class="w" id="content">
	<div class="u_top">
	    <?php $this->load->view('layout/menu');?>
	</div>
	<div class="ubgwn">
		<ul class="u_q clearfix">
			<li class="first <?php if(!$this->input->get('order_status')):?>on<?php endif;?>">
				<a href="<?php echo site_url('order/index');?>">全部订单</a>
			</li>
			<li class="<?php if($this->input->get('order_status')==2):?>on<?php endif;?>">
				<a href="<?php echo site_url('order/index?order_status=2');?>">待付款</a>
			</li>
			<li class="<?php if($this->input->get('order_status')==3):?>on<?php endif;?>">
				<a href="<?php echo site_url('order/index?order_status=3');?>">待发货</a>
		    </li>
			<li class="<?php if($this->input->get('order_status')==4):?>on<?php endif;?>">
				<a href="<?php echo site_url('order/index?order_status=4');?>">待收货</a>
		    </li>
			<li class="<?php if($this->input->get('order_status')==5):?>on<?php endif;?>">
				<a href="<?php echo site_url('order/index?order_status=5');?>">待评价</a>
			</li>
			<li class="<?php if($this->input->get('order_status')==6):?>on<?php endif;?>">
				<a href="<?php echo site_url('order/user_reviews?order_status=6');?>">已评价</a>
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
						   <a title="<?php echo $product->goods_name;?>" target="_blank" href="<?php echo $this->config->main_base_url.'goods/detail/'.$product->goods_id.'.html';?>"> 
						       <?php $img_arr = array_filter(explode('|',$product->goods_img));?>
						       <img class="lazy" src="miaow/images/load.jpg" width="60" height="60" data-original="<?php echo $this->config->show_image_thumb_url('mall',$img_arr[0],60);?>">
		                   </a>
	                       <?php $i ++;?>
                       <?php endif;?>
                       <?php if($i > 1) break;?>
                   <?php endforeach;?>
				</td>
				<td><?php echo $o->pay_id;?></td>
				<td><em class="c9"><?php echo $o->created_at?></em></td>
				<td>
					<p class="c9">￥<?php echo $o->actual_price;?>（邮费：￥<?php echo $o->deliver_price;?>）</br>共<?php echo $i;?>件</p>
				</td>
				<td><b <?php if($o->order_status==4):?>class="green"<?php else :?>class="c9"<?php endif;?>>
				    <?php echo $status_arr[$o->order_status];?></b>
				    <?php if($o->order_status>=4):?>
				    <p><a class="red" href="<?php echo site_url('order/check_deliver/'.$o->order_id.'?pay_id='.$o->pay_id);?>">查询物流</a></p>
				    <?php endif;?>
				</td>
				<td>
				    <a class="rw_btn" href="<?php echo site_url('order/order_detail/'.$o->order_id);?>">查看订单</a>
				    <?php if($o->order_status==2) :?><p class="mt5"><a class="gw_btn" href="<?php echo site_url('order/order_cancel/'.$o->order_id);?>" onclick="return confirm('是否确认取消订单？');">取消订单</a></p><?php endif;?>
    				<?php if($o->order_status==5) :?><p class="mt5"><a class="gw_btn" href="<?php echo site_url('order/order_reviews/'.$o->order_id);?>">去评价</a></p><?php endif;?>
    				<?php if($o->order_status==6) :?><p class="mt5"><a class="hw_btn" href="javascript:void(0);">已评价</a></p><?php endif;?>
				</td>
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
			    <a href="<?php echo $this->config->main_base_url.'goods/detail/'.$val->goods_id.'.html';?>" target="_blank" title="<?php echo $val->goods_name;?>" class="dn_au">
					<?php $img = array_filter(explode('|',$val->goods_img));?>
					<img width="200" height="200" src="<?php echo $this->config->show_image_thumb_url('mall',$img[0],360);?>" />
					<p><?php echo $val->goods_name;?></p>
					<?php if( !empty($val->promote_price) && !empty($val->promote_start_date) && !empty($val->promote_end_date) && ($val->promote_start_date<=time()) && ($val->promote_end_date>=time())):?>
    					<?php $shop_price = $val->promote_price;?>
    				<?php else:?>
    					<?php $shop_price = $val->shop_price;?>
    				<?php endif;?>
					<p class="xj">¥<?php echo $shop_price;?></p>
				</a>
			<?php endforeach;?>
		</div>
	</div>
	<?php endif;?>
</div>
<?php $this->load->view('layout/footer');?>