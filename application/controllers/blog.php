<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->library('blog_lib');    

  }
    
	public function index()
	{

    $data['config'] = $this->blog_config;
    $this->load->library('twig_lib');    
    $data['all_tags'] = $this->blog_lib->get_posts_tags();    
    $data['posts'] = $this->blog_lib->get_posts();
    $this->twig_lib->render("index.html",$data); 
	}
  
  public function posts($pageno=1)
  {
//TODO: 支持分页    
  }
  
  public function post($slug)
  {
    $slug=urldecode($slug);
    $this->load->library('twig_lib');        
    $data['config'] = $this->blog_config;
    $post = $this->blog_lib->get_post($slug);
    if($post===False)
    {
      show_404('Page Not Found.');
    }else{
      $data['post'] = $post['curr'];
      $data['next_post'] = $post['next'];
      $data['prev_post'] =  $post['prev'];

      $this->twig_lib->render("post.html",$data); 
    }

  }
  
  
  public function gallery()
  {

    $this->load->library('twig_lib');        
    $data['config'] = $this->blog_config;

    $this->twig_lib->render("gallery.html",$data); 


  }
  
    
  public function tags($tag='')
  {
    $tag = trim(urldecode($tag));
    $data['config'] = $this->blog_config;
    $this->load->library('twig_lib');    
    $data['all_tags'] = $this->blog_lib->get_posts_tags();    
    if(empty($tag)){
      $this->twig_lib->render("tags_cloud.html",$data);           
      return ;
    }else{
      $data['posts'] = $this->blog_lib->get_posts_by_tag($tag);
      $this->twig_lib->render("tags.html",$data);           
    }
  }
  
  public function help()
  {
    echo $this->blog_lib->get_help();
  }
  
  public function feed()
  {
    $this->load->helper('xml');
    $this->load->helper('text');    
    $data['config'] = $this->blog_config;
    $data['all_tags'] = $this->blog_lib->get_posts_tags();    
    $data['posts'] = $this->blog_lib->get_posts();
    $this->load->view("feed.html",$data); 
  }
}
