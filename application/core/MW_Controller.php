<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'CS_Controller.php';
class MW_Controller extends CI_Controller
{
    protected $frontUser = false;
    public $uid;
    public $aliasName; //用户昵称
    public $userPhone; //用户手机号
    public $userEmail; //用户邮箱
    public $parentId;  //上级用户UID
    public $userLevel; //用户级别
    public $userPhoto; //用户头像

    public function __construct()
    {
    	parent::__construct();
    	$frontUser = get_cookie('frontUser');
        if ($frontUser) {
            $this->frontUser = unserialize(base64_decode($frontUser));
            $this->uid       = $this->frontUser['uid'];
            $this->aliasName = $this->frontUser['aliasName'];
            $this->userPhone = $this->frontUser['userPhone'];
            $this->userEmail = $this->frontUser['userEmail'];
            $this->parentId  = $this->frontUser['parentId'];
            //$this->userLevel = $this->frontUser['userLevel'];
            $this->userPhoto = $this->frontUser['userPhoto'];
        }
    	$this->_init(); //用着重载
    	
    	// 开发模式下开启性能分析
    	if (ENVIRONMENT === 'development') {
    		$this->output->enable_profiler(TRUE);
    	}
    }
    
    public function _init() {}
    
    /**
     * 验证get参数，如果get参数有一个值不为空，则返回true
     */
    protected function search_get_validate($params_get)
    {
        $is_empty = false;
        if (is_array($params_get) && !empty($params_get)) {
            foreach ($params_get as $val) {
                if (!empty($val)) {
                    $is_empty = true;
                    break;
                }
            }
        }
        return $is_empty;
    }
    
    /**
     * 验证参数，如果参数有一个为空，则返回true
     * @param  $postData
     * @return boolean
     */
    protected function validateParam($postData)
    {
        $validate = false;
        if (is_array($postData)) { //验证checkbox，有一个不为空，则通过
            $is_empty = '';
            foreach ($postData as $val) {
                $is_empty .= $val;
            }
            if (empty($is_empty)) {
                $validate = true;
            }
        } else {
            if (empty($postData)) {
                $validate = true;
            }
        }
        return $validate;
    }
    
    /**
     * 验证参数，如果参数有一个为空，则返回true
     * @param  $postData
     * @return boolean
     */
    protected function validateArrayEmpty($postData)
    {
        if (is_array($postData)) { //验证checkbox，有一个不为空，则通过
            foreach ($postData as $val) {
                if (empty($val)){
                    return true;
                }
            }
        } else {
            if (empty($postData)) {
                return true;
            }
        }
        return false;
    }

    /**
     * js提交表单数据提示。
     * @param unknown $error
     * @param string $url
     */
    public function jsonMessage($error, $url='')
    {
        if (!empty($error)) {
            if (is_array($error)) {
                $json = array('status'=>false, 'messages'=>implode('\\n', $error));
            } else {
                $json = array('status'=>false, 'messages'=>$error);
            }
        } else {
            $json = array('status'=>true, 'messages'=>$url);
        }
        echo json_encode($json);exit;
    }

    /**
     * 程序执行错误跳转
     * @param 跳转路径 $url
     * @param url参数 $param
     * @param 提示信息 $message
     */
    protected function error($url, $param, $message)
    {
        if (is_array($message)) {
            foreach ($message as $val) {
                $this->error .= '<p>' . $val . '</p>';
            }
            $this->session->set_flashdata('error', $this->error);
        } else {
            $this->session->set_flashdata('error', $message);
        }
        
        $this->formatUrl($url, $param);
    }
    
    /**
     * 程序执行成功跳转
     * @param 跳转路径 $url
     * @param url参数  $param
     * @param 提示信息 $message
     */
    protected function success($url, $param, $message)
    {
        $this->session->set_flashdata('success', $message);
        $this->formatUrl($url, $param);
    }
    
    private function formatUrl($url, $param)
    {
        $len = strlen($url)-1;
        if ($url{$len} != '/') {
            $url = $url.'/';
        }
        
        if (is_array($param)) {
            $fullUrl = http_build_query($param);
            $url .= '?'.$fullUrl;
        } else {
            $url .= $param;
        }
        
        $parseUrl = parse_url($url);
        if ($parseUrl && isset($parseUrl['scheme'])) {
            $this->redirect($url);
        } else {
            $this->redirect($url);
        }
    }
    
    /**
     * 程序执行跳转
     * @param string $url
     * @param bool $secure
     */
    protected function redirect($url)
    {
        redirectAction($url);
    }
    
    /**
     * 图片上传方法
     * @param $name 图片<input type="file" name="line_image"/>
     * @param string $oldfilename replace重写上传图片，删除老图片
     * @param string $dirName 图片保存在uploads下的目录。
     * @return boolean|array
     */
    protected function dealWithImages($name, $oldfilename = '', $dirName = '')
    {
        $date = date('Ymd');
        $config['upload_path'] = $this->config->upload_image_path($dirName.'/'.$date);
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], DIR_WRITE_MODE, true);
        }
        $config['allowed_types'] = 'gif|jpg|png';
        $config['file_name'] = uniqid(); //唯一的函数
        $this->load->library('upload', $config);
        
        if (!$this->upload->do_upload($name)) { 
            $this->session->set_flashdata('error', $this->upload->display_errors());
            return false;
        }
        
        if (!empty($oldfilename)) {
            $this->deleteOldfileName($oldfilename, $dirName);
        }
        $uploadData = $this->upload->data();
      
        if (!empty($uploadData)) {
            $uploadData['file_name'] = $date.'/'.$uploadData['file_name'];
        }
        return $uploadData;
    }
    
    /**
     * 删除大图和小图
     * @param unknown $oldfullname
     * @param unknown $dirName
     */
    protected function deleteOldfileName($oldfullname, $dirName)
    {
        $imageLarge = $this->config->upload_image_path($dirName, $oldfullname);
        $imageThumb = $this->config->upload_image_thumb_path($dirName, $oldfullname);
        if (is_file($imageLarge)) {
            @unlink($this->config->upload_image_path($dirName, $oldfullname));
            if (is_file($imageThumb)) {
                @unlink($this->config->upload_image_thumb_path($dirName, $oldfullname));
            }
        }
    }
    
    /**
     * 图片等比例压缩
     * @param array $imageData {full_path:图片完整路径；file_path：图片所在完整目录}
     * @param string $dirName 图片保存在uploads下的目录。
     * @return boolean|array
     */
    protected function dealWithImagesResize($imageData, $width='75', $height='50')
    {
        $config['image_library']  = 'GD2'; //设置图像库GD, GD2, ImageMagick, NetPBM	
        $config['source_image']   = $imageData['full_path']; //设置原始图像的名字/路径。 这个路径必须是相对或绝对的服务器路径，不能是URL
        $config['new_image']      = $imageData['file_path'].'thumb/'; //设置图像的目标名/路径。这个路径必须是相对或绝对的服务器路径，不能是URL
        if (!is_dir($config['new_image'])) {
            mkdir($config['new_image'], DIR_WRITE_MODE, true);
        }
        $config['create_thumb']   = TRUE; //让图像处理函数产生一个预览图像
        $config['maintain_ratio'] = TRUE; //指定是否在缩放或使用硬值的时候使图像保持原始的纵横比例。
        $config['thumb_marker']   = ''; //例如，mypic.jpg 将会变成 mypic_thumb.jpg
        $config['quality']        = 90; //设置图像的品质。1 - 100
        $config['width']          = $width;
        $config['height']         = $height;
        
        $this->load->library('image_lib');
        $this->image_lib->initialize($config);
        $ifResize = $this->image_lib->resize();
        if (!$ifResize) {
            $this->session->set_flashdata('error', $this->image_lib->display_errors());
            return false;
        }
        $this->image_lib->clear();
        return $ifResize;
    }
    
    /**
     * 水印处理一个图像
     * @param array $imageData {full_path:图片完整路径；file_path：图片所在完整目录}
     * @param string $textContent 打水印的文字内容。
     */
    protected function dealWithImagesWatermark($imageData, $textContent, $type='text', $fontSize=12, $fontColor='ffffff')
    {
        $config['image_library']      = 'gd2'; //设置图像库GD, GD2, ImageMagick, NetPBM
        $config['wm_type']            = 'text'; //Text: 水印信息将以文字方式生成;Overlay: 水印信息将以图像方式生成
        $config['source_image']       = $imageData['full_path'];//图片的路径;
        $config['quality']            = 90; //设置图像的品质。1 - 100
        $config['wm_padding']         = -10;
        $config['wm_vrt_alignment']   = 'bottom'; //top, middle, bottom
        $config['wm_hor_alignment']   = 'center'; //left, center, right
        $config['wm_hor_offset']      = 'right'; //left, center, right
        $config['wm_vrt_offset']      = 'bottom'; //left, center, right
        
        if (!is_writable($imageData['full_path'])) {
            @chmod($imageData['full_path'], DIR_WRITE_MODE);
        }
        
        if ($type == 'text') {
            $config['wm_text']            = $textContent;
            $config['wm_font_path']       = BASEPATH.'fonts/nsimsun.ttf';
            $config['wm_font_size']       = $fontSize;
            $config['wm_font_color']      = $fontColor;
            //$config['wm_shadow_color']    = $fontColor; //阴影的颜色, 以十六进制给出。
            $config['wm_shadow_distance'] = 3; //阴影与文字之间的距离(以像素为单位)。
        }
        
        if ($type == 'overlay') {
            $config['wm_overlay_path'] = $textContent; //你想要用作水印的图片在你服务器上的路径。
            $config['wm_opacity']      = 50; //图像不透明度(opacity)。通常设置为50。
            $config['wm_x_transp']     = 4; //一个数字	如果你的水印图片是一个PNG或GIF图片, 你可以指定一种颜色用来使图片变得"透明"。
            $config['wm_y_transp']     = 4; //你想要用作水印的图片在你服务器上的路径。
        }
        
        $this->load->library('image_lib');
        $this->image_lib->initialize($config);
        $ifWatermark = $this->image_lib->watermark();
        //var_dump($this->image_lib->display_errors());exit;
        if (!$ifWatermark) {
            $this->session->set_flashdata('error', $this->image_lib->display_errors());
            return false;
        }
        $this->image_lib->clear();
        return $ifWatermark;
    }
    
    /**
     * 导入文件读取函数
     * @param 传入的文件名称 $filename
     * @return string
     */
    protected function getCSVfileContent($filename)
    {
        $row = 1;//第一行开始
        if(($handle = fopen($filename, 'r')) !== false) {
            while(($dataSrc = fgetcsv($handle)) !== false) {
                $num = count($dataSrc);
                for ($c=0; $c < $num; $c++) {
                    if($row === 1) {
                        $dataName[] = mb_convert_encoding($dataSrc[$c], 'UTF-8', 'GBK');//字段名称
                    } else {
                        foreach ($dataName as $k=>$v) {
                            if($k == $c) {
                                $data[$v] = mb_convert_encoding($dataSrc[$c], 'UTF-8', 'GBK');
                            }
                        }
                    }
                }
                if(!empty($data)) {
                    $CSVfileContent[] = $data;
                    unset($data);
                }
                $row++;
            }
            fclose($handle);
            return $CSVfileContent;
        }
    }
    
    /**
     * 错误回跳到首页
     * @param unknown $msg
     */
    protected function alertError($msg)
    {
        echo '<script type="text/javascript">alert("'.$msg.'");location.href="'.base_url().'"</script>';exit;
    }
    
    /**
     * 错误回跳到首页
     * @param unknown $msg
     */
    protected function alertJumpPre($msg)
    {
        echo '<script type="text/javascript">alert("'.$msg.'");location.href="Javascript:window.history.go(-1)"</script>';exit;
    }
    
    /**
     * 分页get参数
     * @param unknown $getParam
     */
    public function pageGetParam($getParam)
    {
        $suffix = '';
        if ($getParam) {
            $param = http_build_query($getParam);
            $suffix = '?'.$param;
        }
        return $suffix;
    }
    
    /**
     * ci 验证码
     * @return Ambigous <boolean, multitype:number string >
     */
    public function getCaptcha($name, $font_size=20, $img_width=100, $img_height=30, $count=4)
    {
        $this->load->helper('captcha');
        $str = 'abcdefghgklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUXWXYZ23456789';
        $word = '';
        for ($i=0; $i < $count; $i++) {
            $word .= $str[mt_rand(0,strlen($str)-1)];
        }
        $vals = array(
            'word'       => $word,
            'img_path'   => FCPATH.'captcha/',
            'img_url'    => base_url().'captcha/',
            'font_path'  => BASEPATH.'fonts/texb.ttf',
            'font_size'  => $font_size.'px',
            'img_width'  => $img_width,
            'img_height' => $img_height,
            'expiration' => '300'
        );
        $captcha = create_captcha($vals);
        $this->session->set_userdata($name, $captcha['word']);
        return $captcha;
    }
}