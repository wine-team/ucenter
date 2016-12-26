<?php $this->load->view('m/layout/header');?>
<div id="top">
	<div class="header">
		<a href="javascript:goback();" class="b_l"></a>
		<h2>修改资料</h2>
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
<div class="pageauto ucenter-infor">
	<ul class="xul mt10">
		<li onClick="fmx(0)">
			<b class="mt10">头像</b>
			<img src="http://s.qw.cc/mobile/css/noav.png" width="40" height="40"/>
		</li>
		<li><b>用户名</b><i>15988173722</i></li>
		<li onClick="fmx(1)"><b>论坛昵称</b><i class="c9">点击填写昵称</i></li>
		<li onClick="fmx(2)"><b>性别</b><i>男</i></li>
		<li onClick="fmx(3)"><b>邮箱</b><i>点击填写邮箱</i></li>
		<li onClick="fmx(4)"><b>手机</b><i>15988173722</i></li>
	</ul>
	<ul class="xul mt10">
		<li onClick="fmx(5)"><b>点击绑定手机号</b></li>
	</ul>
</div>

<div class="msk ucenter-infor-msk" id="msk">
	<div id="box" class="prbox">
		<div class="pd10" id="forms">
			<form action="profile.php" method="POST" onSubmit="return ckav()" enctype="multipart/form-data" class="hid">
				<h2 class="t">
					<b class="brl">
						<em class="f14">修改头像</em>
					</b>
				</h2>
				<input type="file" name="avatar" id="avatar" class="avatar" />
				<input type="hidden" name="act" value="update_avatar" />
				<a href="javascript:" onclick="xpx(0)" class="lbtn left">取消</a>
				<input type="submit" value="修改" class="rbtn right"/>
				<div class="clear"></div>
			</form>
		
			<form action="profile.php" method="POST" id="lt_form" class="hid">
				<h2 class="t"><b class="brl"><em class="f14">论坛昵称</em></b></h2>
				<p>
					<input type="text" name="other_name" id="other_name" value=""  maxlength="60" class="pt" placeholder="论坛昵称"/>
				</p>
				<a href="javascript:" onclick="xpx(0)" class="lbtn left">取消</a>
				<input type="button" value="修改" class="rbtn right" onClick="ckf1()"/>
				<div class="clear"></div>
			</form>
		
			<form action="profile.php" method="POST" id="sex_form" class="hid">
				<h2 class="t"><b class="brl"><em class="f14">修改性别</em></b></h2>
				<div class="mt10 mb10"><input type="radio" name="sex" value="0"  /> 保密 <input type="radio" name="sex" value="1" checked="true" /> 男 <input type="radio" name="sex" value="2" /> 女</div>
				<a href="javascript:" onclick="xpx(0)" class="lbtn left">取消</a>
				<input type="button" value="修改" class="rbtn right" onClick="ckf2()"/>
				<div class="clear"></div>
			</form>
		
			<form action="profile.php" method="POST" id="email_form" class="hid">
				<h2 class="t"><b class="brl"><em class="f14">修改邮箱</em></b></h2>
				<div><input type="text" name="email" id="email" value="" maxlength="60" class="pt" placeholder="电子邮箱地址" /></div>
				<div class="ov mt10"><a href="javascript:" onclick="xpx(0)" class="lbtn left">取消</a>
				<input type="button" value="修改" class="rbtn right" onClick="ckf3()"/>
				</div>
			</form>
		
		
			<form action="profile.php" method="POST" id="mobile_form">
				<h2 class="t"><b class="brl"><em class="f14">手机号码</em></b></h2>
				<input type="text" name="mobile_phone" id="mobile_phone" value="15988173722" maxlength="11" class="pt" placeholder="请输入你的手机号码" />
				<div class="ov mt10"><a href="javascript:" onclick="xpx(0)" class="lbtn left">取消</a>
				<input type="button" value="修改" class="rbtn right" onClick="ckf4()" id="xgmob" />
				</div>
			</form>
		
			<form action="profile.php" method="POST" id="mobile_form">
				<h2 class="t"><b class="brl"><em class="f14">绑定手机号码</em></b></h2>
				<p>绑定号码：15988173722</p>
				<input type="button" value="点击发送短信验证码" id="dx" class="dx"/>
				<div class="hid" id="sms_box" class="sms_box">
					<p>验证码:</p>
					<input type="text" name="code" id="code" value=""  onChange="yz()" maxlength="6" class="pt" placeholder="请输入短信中的验证码(纯数字)"/>
				</div>
				<input type="hidden" name="act" value="update" />
				<a href="javascript:" onclick="xpx(0)" class="lbtn left">取消</a>
				<input type="button" value="绑定" onClick="yz()" class="rbtn right"/>
				<div class="clear"></div>
			</form>
		</div>
	</div>
</div>
<script>
var u_id = "1081111";
var forms = $("#forms").children();
var o_sex = "1";
var o_email = "";
var o_mobile = "15988173722";
var va = "0";

function ckav() {
    var a = $("#avatar").val();
    if (a.length < 1) {
        alert("请选择上传的图片后在提交，谢谢！");
        return false;
    }
}

function xpx(id) {
    forms.eq(id).show().siblings().hide();
    $("#msk").hide();
}

function fmx(i) {
    $("#msk").show();
    forms.eq(i).show().siblings().hide();
}



//昵称
function ckf1() {
    var other_name = $("#other_name").val();
    if (other_name.length < 2) {
        alert("昵称不能少于2个字");
        return false;
    }
    $.ajax({
        type: "POST",
        url: "profile.php",
        data: {
            act: "update_other_name",
            other_name: other_name
        },
        datatype: "text",
        success: function (data) {
            if (data == 1) {
                alert("更新成功");
                location.reload();
            } else if (data == 2) {
                alert("该昵称已被抢先一步，请重新填写");
                $("#other_name").val("");
            } else {
                alert("更新失败");
            }
        }
    });
}


//性别
function ckf2() {
        var sex = $("input[name='sex']:checked").val();
        if (sex == o_sex) {
            return false;
        }
        $.ajax({
            type: "POST",
            url: "profile.php",
            data: {
                act: "update_sex",
                sex: sex
            },
            datatype: "text",
            success: function (data) {
                if (data == 1) {
                    alert("更新成功");
                    location.reload();
                } else {
                    alert("更新失败");
                }
            }
        });
    }
    //邮箱

function ckf3() {
    var email = $("#email").val();
    if (email == o_email) {
        return;
    }
    if (!Validator.isEmail(email)) {
        alert("邮箱格式错误");
        return false;
    }
    $.ajax({
        type: "POST",
        url: "profile.php",
        data: {
            act: "update_email",
            email: email,
            change: va
        },
        datatype: "text",
        success: function (data) {
            if (data == 1) {
                alert("更新成功");
                location.reload();
            } else if (data == 2) {
                alert("邮箱已被其他人注册拉");
                $("#email").val(o_email);
            } else {
                alert("更新失败");
            }
        }
    });
}

//手机
function ckf4() {
    var mobile_phone = $("#mobile_phone").val();
    if (mobile_phone == o_mobile) {
        return false;
    }
    if (!Validator.isMobile(mobile_phone)) {
        alert("手机格式错误");
        return false;
    }
    $.ajax({
        type: "POST",
        url: "profile.php",
        data: {
            act: "update_mobile_phone",
            mobile_phone: mobile_phone,
            change: va
        },
        datatype: "text",
        success: function (data) {
            if (data == 1) {
                alert("更新成功");
                location.reload();
            } else if (data == 2) {
                alert("手机已被其他人注册拉");
            } else if (data == 3) {
                alert("请填写正确格式的手机号");
            } else {
                alert("更新失败");
            }
        }
    });
}

//手机解绑
function jiebang(id) {
    $.ajax({
        type: "POST",
        url: "profile.php",
        data: {
            act: "jiebang"
        },
        datatype: "text",
        success: function (data) {
            if (data == 1) {
                $("#mobile_phone").removeAttr("readonly").removeAttr("style");
                $("#jbb").remove();
                $("#xgmob").removeAttr("disabled");
                alert("解绑成功");
            } else if (data == 2) {
                alert("手机没有绑定哦");
            } else {
                alert("解绑失败");
            }
        }
    });
}

var tmo;
var lm = 180;
var xm = 180;
var fa = 0;
var dx = $("#dx");

function tm() {
    lm--;
    if (lm < 1) {
        dx.removeAttr("disabled");
        dx.val("重发");
        clearTimeout(tmo);
        lm = xm;
        return;
    }
    dx.val(lm + "秒后可重发");
    tmo = setTimeout("tm()", 1000);
}

dx.bind("click", function () {
    var il = $(this).prop("disabled");
    var mbv = $('#mobile_phone').val();
    if (!Validator.isMobile(mbv)) {
        alert("请输入正确的手机号码");
        return false;
    }
    if (!il) {
        $(this).prop("disabled", "true");
        tm();
        $("#sms_box").removeClass("hid");
        $.getJSON('profile.php?act=send&t=' + new Date().valueOf(), {
            mobile_phone: mbv
        }, function (data) {
            if (data.code) {
                alert(data.msg);
            }
        });
    } else {
        alert("请等待倒计时结束后重新发送");
    }
});

function yz() {
    var c = $('#code').val();
    if (c.length < 4) {
        alert("请填写完成的验证码");
        return false;
    }
    if (fa == 1) {
        return false;
    }
    fa = 1;
    $.getJSON('profile.php?act=check&t=' + new Date().valueOf(), {
            code: c
        },
        function (data) {
            if (data.code == 1) {
                alert(data.msg);
            } else if (data.code == 0) {
                alert(data.msg);
                window.location.reload();
            } else {
                $('#mobile_phone').attr('readonly', true).css('background-color', '#ccc');
                $("#sms_box").addClass("hid");
                $('#dj').remove();
            }
        });
}
</script>
<?php $this->load->view('m/layout/smallfooter');?>
<?php $this->load->view('m/layout/footer');?>