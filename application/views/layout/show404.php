<?php $this->load->view('layout/header');?>
<style>
.search-main{margin:15px auto 0;font-family:"Microsoft YaHei";padding-bottom:50px;*padding-top:15px;width:990px;}
.search-main a:hover{text-decoration:none;}
.search404{text-align:center;margin:60px auto;color:#666;}
.search404 .search404ico{display:inline-block;width:286px;height:182px;background:url(http://images.miaocw.com/common/search404.png) no-repeat 0 0;}
.search404 h5{font-size:18px;line-height:60px;font-weight:normal;}
.search404 p{font-size:14px;}
.search404 p a{color:#28E;margin:0 0 0 40px;}
.search404 p a:hover{color:#FA0;text-decoration:underline;}
</style>
    <div class="w" id="content" >
    	<div class="search-main">
            <div class="search404">
                <em class="search404ico"></em>
                <h5>抱歉，您请求的页面没有找到，但不要着急哦！</h5>
                <p>您可以<a href="<?php echo $this->config->main_base_url;?>">返回首页</a><a href="http://wpa.qq.com/msgrd?v=3&uin=2644720895&site=qq&menu=yes">联系客服</a></p>
            </div>
        </div>
    </div>
<?php $this->load->view('layout/footer');?>