<?php
 class MP_Admin{
    
    private $url_includes;

    public function __construct(  ){                
        $this->url_includes = plugin_dir_url( __FILE__ ).'includes/';
    }

    public function enqueue_style( $hook ){
        wp_enqueue_style( 'animate_css', $this->url_includes.'animate.css' , [] , '3.5.2' , 'all' );
        wp_enqueue_style( 'bootstrap_css', $this->url_includes.'bootstrap-3.3.7-dist/css/bootstrap.min.css' , [] , '3.3.7' , 'all' );
    }

    public function enqueue_script( $hook ){        
        wp_enqueue_script( 'bootstrap_script', $this->url_includes.'bootstrap-3.3.7-dist/js/bootstrap.min.js' , ['jquery'] , '3.3.7' , true );
        wp_enqueue_script( 'bootstrap_notify', $this->url_includes.'bootstrap-notify/bootstrap-notify.min.js' , ['jquery'] , '3.1.5' , true );
    }

 }

 $mp_admin = new MP_Admin();

 add_action( 'admin_enqueue_scripts', [$mp_admin , 'enqueue_style'] );
 add_action( 'admin_enqueue_scripts', [$mp_admin , 'enqueue_script'] );