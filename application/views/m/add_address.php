<?php $this->load->view('m/layout/header');?>
<div id="top">
	<div class="header">
		<a href="javascript:goback();" class="b_l"></a>
		<h2>新增收货地址</h2>
		<a href="<?php echo site_url('qingqu/home/index');?>"  class="b_r">首页</a>
	</div>
</div>
<div class="pageauto">
	<div class="lr10 bgw">
		<form onsubmit="return checkCon(this)" name="theForm" method="post" action="<?php echo site_url('m/Address/addPost')?>" id="con">
		    <table width="100%" border="0" class="ftable" id="car">
		      <tbody>
			        <tr>
			          <td width="22%"><b class="red pr5">*</b>收件人：</td>
			          <td><input type="text" value="" id="consignee" class="pt" name="receiver_name"/></td>
			        </tr>
			        <tr>
			          <td><b class="red pr5">*</b>手机：</td>
			          <td><input type="text" value="" id="mobile" class="pt" name="tel"/></td>
			        </tr>
		        	<tr>
		          	  <td><b class="red pr5">*</b>省市区：</td>
		              <td>
		                <?php $this->load->view('m/layout/districtSelect');?>
		             </td>
		        </tr>
		        <tr>
			          <td><b class="red pr5">*</b>街道地址：</td>
			          <td><input type="text" value="" id="address" class="pt" size="80" name="detailed"/></td>
		        </tr>
		        <tr>
			          <td>邮编：</td>
			          <td><input type="text" value="" id="code" class="pt" name="code"/></td>
			        </tr>
		        <tr>
		       		  <td></td>
		       		  <td><label class="f14 c3"><input name="is_default" type="checkbox" class="checkb" value="2" maxlength=10/> 设置为默认收货地址</label></td>
		        </tr>
		        <tr>
			          <td colspan="2">
			            <input type="submit" value="确认" class="gbtn"/>
			            <p class="lh30">&nbsp;</p>
			          </td>
		        </tr>
		      </tbody>
		    </table>
		  </form>
	</div>
</div>
<script>


function checkCon(frm) {
    var n1 = $("#consignee").val();
    var n5 = $("#address").val();
    var n6 = $("#mobile").val();
    if (n1.length < 2) {
        alert("收货人姓名不得少于2个字");
        return false;
    }
    if (frm.elements['province'] && frm.elements['province'].value == 0 && frm.elements['province'].length > 1) {
        alert("请选择省份");
        return false;
    }
    if (frm.elements['city'] && frm.elements['city'].value == 0 && frm.elements['city'].length > 1) {
        alert("请选择城市");
        return false;
    }
    if (frm.elements['district'] && frm.elements['district'].length > 1) {
        if (frm.elements['district'].value == 0) {
            alert("请选择区域");
            return false;
        }
    }
    if (n5.length < 4 || n5.length > 60) {
        alert("请填写收货地址4-60个字");
        return false;
    }
    if (!Validator.isMobile(n6)) {console.log(Validator.isMobile(n6));
        alert("请填写正确的手机号码！");
        return false;
    }
}
</script>
<?php $this->load->view('m/layout/smallfooter');?>
<?php $this->load->view('m/layout/footer');?>