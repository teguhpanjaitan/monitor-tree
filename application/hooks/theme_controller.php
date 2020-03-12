<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class theme_controller{

    public function generate_constant(){
        global $template;
		$theme = "notebook";
		$template = new StdClass();
        $template->header ="theme/$theme/header.php";
        $template->footer ="theme/$theme/footer.php";
        $template->sidebar = "theme/$theme/sidebar.php";
        $template->footer_add = "";
        $template->theme = "theme/$theme/";
        $template->data = array();
    }

    public function render_html(){
        global $template;
        $CI =& get_instance();
        if(empty($template->content)) {
            return;
        }
		$data = array();

        $data['header'] = $CI->load->view($template->header, null, true);
        $data['footer'] = $CI->load->view($template->footer, null, true);
		$data['sidebar'] = $CI->load->view($template->sidebar, null, true);
		$data['content'] = $template->content;
		$CI->load->view($template->theme."layout.php",$data);
    }
    
}


?>