<?php $this->load->view('layout/header');?>

	<div class="w" id="content">
		<div class="u_top">
			<?php $this->load->view('layout/menu');?>
		</div>



		<div class="ubgw">
			<div class="over">
				<h2 class="lr_bl left">
					评论 <a href="<?php echo empty($goods_id) ? site_url('order/order_detail/'.$order_id) : $this->config->main_base_url.'goods/detail?goods_id='.$goods_id;?>" target="_blank"><?php echo $product;?></a>
				</h2>
				<a href="javascript:;" onclick="window.history.go(-1)" class="blue right">《返回</a>
			</div>
			<form action="<?php echo site_url('order/reviews_add')?>" id="myform" method="post" enctype="multipart/form-data">
				<div class="lh35">
					<table class="td_p" border="0" cellpadding="0" cellspacing="0" width="100%">
						<tbody>
							<tr>
								<td colspan="2"><p class="c9">评论会自动匿名，仅评论送20积分，评论并晒单(确认收货后可晒单)送30积分，审核通过后生效，您的建议是我们改进的动力！</p></td>
							</tr>
							<tr>
								<td valign="top" width="80">商品评分：</td>
								<td class="lh20 c9">
    								<label class="left mr10">
    								    <input name="score" value="1" id="comment_rank1" class="left" type="radio">
    									<div class="left px px1">
    										<p></p>
    									</div> <br>1星失误
    								</label> 
									<label class="left mr10">
    									<input name="score" value="2" id="comment_rank2" class="left" type="radio">
    									<div class="left px px2">
    										<p></p>
    									</div> <br>2星不满
									</label> 
									<label class="left mr10">
    									<input name="score" value="3" id="comment_rank3" class="left" type="radio">
    									<div class="left px px3">
    										<p></p>
    									</div> <br>3星一般
									</label> 
									<label class="left mr10">
    									<input name="score" value="4" id="comment_rank4" class="left" type="radio">
    									<div class="left px px4">
    										<p></p>
    									</div> <br>4星满意
									</label> 
									<label class="left mr10">
    									<input name="score" value="5" checked="checked" id="comment_rank5" class="left" type="radio">
    									<div class="left px px5">
    										<p></p>
    									</div> <br>5星惊喜
									</label>
								</td>
							</tr>
							<tr>
								<td valign="top"><p>&nbsp;</p>晒图片：</td>
								<td id="shai">
									<p>&nbsp;</p>
									<div class="uu_p">
										<p class="img_uv" id="p1">+</p>
										<input name="slide_show1" value="" class="mup" data-id="1" id="f1" autocomplete="off" type="file">
										<p class="alC">
											<a href="javascript:;" class="red hid">删除X</a>
										</p>
									</div>
									<div class="uu_p">
										<p class="img_uv" id="p2">+</p>
										<input name="slide_show2" value="" class="mup" data-id="2" id="f2" autocomplete="off" type="file">
										<p class="alC">
											<a href="javascript:;" class="red hid">删除X</a>
										</p>
									</div>
									<div class="uu_p">
										<p class="img_uv" id="p3">+</p>
										<input name="slide_show3" value="" class="mup" data-id="3" id="f3" autocomplete="off" type="file">
										<p class="alC">
											<a href="javascript:;" class="red hid">删除X</a>
										</p>
									</div>
									<div class="uu_p">
										<p class="img_uv" id="p4">+</p>
										<input name="slide_show4" value="" class="mup" data-id="4" id="f4" autocomplete="off" type="file">
										<p class="alC">
											<a href="javascript:;" class="red hid">删除X</a>
										</p>
									</div>
									<div class="uu_p">
										<p class="img_uv" id="p5">+</p>
										<input name="slide_show5" value="" class="mup" data-id="5" id="f5" autocomplete="off" type="file">
										<p class="alC">
											<a href="javascript:;" class="red hid">删除X</a>
										</p>
									</div>
									<div class="clear"></div>
								</td>
							</tr>
							<tr>
								<td>商品评价：</td>
								<td><textarea name="content" id="sd_des" class="area" cols="80" rows="6" autocomplete="off"></textarea></td>
							</tr>

							<tr>
								<td>&nbsp;</td>
								<td><input name="goods_id" value="<?php echo $goods_id;?>" type="hidden">
									<input name="order_id" value="<?php echo $order_id;?>" type="hidden"> 
									<input class="green_btn" value="确认提交" type="submit">
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</form>
		</div>

	</div>


<?php $this->load->view('layout/footer');?><?php echo alert_message();?>	