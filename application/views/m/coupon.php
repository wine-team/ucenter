<?php $this->load->view('m/layout/header');?>
<div id="top">
	<div class="header">
		<a href="javascript:goback();" onClick="" class="b_l"></a>
		<h2>我的优惠卷</h2>
		<a href="javascript:gtns();" id="gdor" class="b_r">导航</a>
	</div>
</div>
<div class="gtn" id="gtn">
	<ul class="gt_a">
		<li><a href="javascript:;" class="gta">所有商品分类</a></li>
		<li><a href="javascript:;" class="gta">购物车</a></li>
		<li><a href="javascript:;" class="gta">浏览历史</a></li>
		<li><a href="javascript:;" class="gta">回首页</a></li>
		<li><a href="javascript:;" class="gta">在线客服咨询</a></li>
	</ul>
</div>
<div class="pageauto">
	<div class="lh25 gbgw">
		<div class="lr10 y_hj">
			<table width="100%" border="0">
			  <tr>
			    <td width="100">
			    	<p class="hbo">¥10.00元</p>
			    </td>
			    <td>
			    	<p>新注册送10元优惠券</p><p>有效期：2015-05-26 至 2027-07-09 </p>
			    	<p>
			        	<a href="<?php echo site_url('sex/home/goods');?>" class="bun">立即使用</a>
			    	</p>
			    </td>
			  </tr>
			</table>
		</div>
	</div>
	<div class="lh25 gbgw">
		<div class="lr10">
			<h2 class="t"><em class="brl">添加优惠券</em></h2>
			<p class="line"></p>
			<p class="lh18">&nbsp;</p>
			<form onSubmit="return addBonus()" method="post" action="" name="addBouns">
				<table width="100%" border="0">
				  <tr>
				    <td width="90">优惠券序列号:</td></tr>
				    <tr>
				    <td><input type="text" class="pt" size="30" name="bonus_sn"/></td>
				  </tr>
				</table>
				<p class="lh18">&nbsp;</p>
				<input type="hidden" class="inputTx" value="act_add_bonus" name="act"/>
				<input type="submit" value="添加优惠券" class="bbt"/>
				<p class="lh18">&nbsp;</p>
			</form>
		</div>
	</div>
	<p class="lh20">&nbsp;</p>
	<div class="pd10 gbgw">
		<div class="lh25">
			<p>优惠劵是妙处网为回馈老客户推出的优惠，可抵等额现金使用。</p>
			<p>优惠劵有什么用？</p>
			<p>1. 订单满一定金额，可使用一定额度的优惠劵。如“满100元可使用8元优惠券”</p>
			<p>2. 活动中使用，按照活动的具体说明使用。</p>
			<p>如何获得优惠劵？</p>
			<p>1. 网站注册新用户可送8元优惠劵</p>
			<p>2.满赠优惠劵，确认收货交易完成后生效。如“订单满100元，可送8元优惠劵”</p>
		</div>
	</div>
</div>
<script>
function addBonus(){
  var frm= document.forms['addBouns'];
  var bonus_sn =frm.elements['bonus_sn'].value;
  if(bonus_sn.length == 0){
    alert('请输入的你的优惠券序列号！');
    return false;
  }
  else{
    var reg = /^[0-9]{10}$/;
    if ( ! reg.test(bonus_sn)){
      alert('你输入的优惠券格式不正确！');
      return false;
    }
  }
  return true;
}

function gtns(){
	$("#gtn").toggle();
}

$("#gtn").bind("click",function(){
	$(this).hide();
});
</script>
<?php $this->load->view('m/layout/smallfooter');?>
<?php $this->load->view('m/layout/footer');?>
