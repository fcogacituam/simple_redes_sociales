<?php 
/*
    Plugin Name: Simple Redes Sociales
    Plugin URI:
    Description: Despliega tus redes sociales a un costado de tu página web, además puedes desplegarlas dónde quieras con el uso del Widget y el shortcode [simple_redes_sociales]
    Author: Francisco Gacitua
    Text Domain: simple_redes_sociales
    Domain Path: /languages
    Version: 0.3
    Author URI: http://www.fgacitua.cl
    License:  GPL2

    Simple Redes Sociales is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
Simple Redes Sociales is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with Simple Redes Sociales.
*/
if ( !class_exists( 'SimpleRedesSociales' ) ) {
class SimpleRedesSociales {

    private $redes;

    function getRedes():array{
        return $this->redes;
    }
    function setRedes(array $redes){
        $this->redes = $redes;
        return $this;
    }


    public function __construct() {
         $this->redes=array(
            "facebook"=>get_option('facebook'),
            "youtube"=>get_option('youtube'),
            "instagram"=>get_option("instagram"),
            "twitter"=>get_option("twitter"),
            "googleplus"=>get_option("googleplus"),
            "linkedin"=>get_option("linkedin"),
            "spotify"=>get_option("spotify"),
            "pinterest"=>get_option("pinterest"),
            "tumblr"=>get_option("tumblr"),
            "wechat"=>get_option("wechat"),
            "reddit"=>get_option("reddit")
        );

        require_once("redes_sociales_widget_class.php");

       


        register_activation_hook( __FILE__, 'createDataBase' );
        register_deactivation_hook( __FILE__, 'clearDb' );

        add_action( 'admin_menu', array( $this, 'redes_settings_page' ) );
        add_action( 'admin_init', array( $this, 'redes_setup_init' ) );
        add_action( 'wp_footer', array($this,'insertRedes') );
        add_action('wp_enqueue_scripts', array($this,'callback_for_setting_up_scripts') );
        add_action( 'admin_enqueue_scripts', array($this, 'my_plugin_admin_scripts' ));
        add_action('wp_head',array($this,'color_theme_customize') );


        add_action("widgets_init",array($this,"srs_cargar_widget"));
        add_action('init',array($this,'srs_cargar_shortcode'));
        add_action( 'plugins_loaded',array($this,'my_plugin_load_plugin_textdomain') );
    }

   
   function my_plugin_load_plugin_textdomain() {
        load_plugin_textdomain( 'simple_redes_sociales', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
    }
   
    



    public function callback_for_setting_up_scripts(){
        wp_register_style('redes_sociales_css', plugins_url('/includes/css/style.css',__FILE__ ));
        wp_enqueue_style('redes_sociales_css');
        wp_register_style('animate','https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.css');
        wp_enqueue_style('animate');




          wp_register_script( 'jquery', 'https://code.jquery.com/jquery-1.12.4.min.js');
        wp_enqueue_script('jquery');
        wp_register_script( 'redes_sociales_js', plugins_url('/includes/js/index.js',__FILE__ ));
        wp_enqueue_script('redes_sociales_js');


      
    }

    public function my_plugin_admin_scripts() {
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker-alpha', plugins_url( '/includes/js/wp-color-picker-alpha.min.js',  __FILE__ ), array( 'wp-color-picker' ), '1.0.0', true );
    }




    // SHORTCODE
     public function srs_cargar_widget(){
        register_widget("redes_sociales_class");
    }


    public function getInsertedRedes(){
        // $srs= new SimpleRedesSociales();
        $redes= $this->getRedes();
        $notEmpty=array();
        foreach ($redes as $red => $value) {
            switch ($red) {
                case 'googleplus':
                    $red="google-plus";
                    break;
                
                default:
                    break;
            }
           if(!empty($value)){
                $notEmpty[$red]=$value;
           }
        }

        return $notEmpty;
    }




    public function srs_cargar_shortcode(){
        function srs_do_shortcode(){
            
            $srs= new SimpleRedesSociales();
            $redes= $srs->getInsertedRedes();

            $printed_redes_inicio= "<div class='container-fluid text-left'><div class='row'><ul class='shortcodeUl'>";
            $printed_redes_final= "</ul></div></div>";
            
            foreach ($redes as $red => $value) {
               $printed_redes_inicio .= "<li class='".$red."'><a href='".$value."' target='_blank'><i class='fa fa-$red fa-2x' aria-hidden='true'></i></a></li>";
            }

            $printed_redes= $printed_redes_inicio.$printed_redes_final;

            return $printed_redes;

        }
        add_shortcode("simple_redes_sociales" ,"srs_do_shortcode" );
    }








    
    public function insertRedes() {
   
        $redes= $this->getRedes();
        extract($redes);



        ?>
        <div class="container-fluid">
            <div class="row">
                <ul>
        <div class="social">
          <ul>
            <?php if($facebook!==''): ?>
                <li class="facebook"><a href="<?php echo $facebook;?>" target="_blank"><span class="hiden-social">Facebook</span><i class="fa fa-facebook fa-2x" aria-hidden="true"></i></a></li>
            <?php endif; ?>
            <?php if($youtube!==''): ?>
                <li class="youtube"><a href="<?php echo $youtube;?>" target="_blank"><span class="hiden-social">Youtube</span><i class="fa fa-youtube fa-2x" aria-hidden="true"></i></a></li>
            <?php endif; ?>
            <?php if($instagram!==''): ?>
                <li class="instagram"><a href="<?php echo $instagram;?>" target="_blank"><span class="hiden-social">Instagram</span><i class="fa fa-instagram fa-2x" aria-hidden="true"></i></a></li>
            <?php endif; ?>
            <?php if($twitter!==''): ?>
                <li class="twitter"><a href="<?php echo $twitter;?>" target="_blank"><span class="hiden-social">Twitter</span><i class="fa fa-twitter fa-2x" aria-hidden="true"></i></a></li>
            <?php endif; ?>
            <?php if($googleplus!==''): ?>
                <li class="googleplus"><a href="<?php echo $googleplus;?>" target="_blank"><span class="hiden-social">Google+</span><i class="fa fa-google-plus fa-2x" aria-hidden="true"></i></a></li>
            <?php endif; ?>
            <?php if($linkedin!==''): ?>
                <li class="linkedin"><a href="<?php echo $linkedin;?>" target="_blank"><span class="hiden-social">LinkedIn</span><i class="fa fa-linkedin fa-2x" aria-hidden="true"></i></a></li>
            <?php endif; ?>
            <?php if($spotify!==''): ?>
                <li class="spotify"><a href="<?php echo $spotify;?>" target="_blank"><span class="hiden-social">Spotify</span><i class="fa fa-spotify fa-2x" aria-hidden="true"></i></a></li>
            <?php endif; ?>
            <?php if($pinterest!==''): ?>
                <li class="pinterest"><a href="<?php echo $pinterest;?>" target="_blank"><span class="hiden-social">Pinterest</span><i class="fa fa-pinterest fa-2x" aria-hidden="true"></i></a></li>
            <?php endif; ?>
            <?php if($reddit!==''): ?>
                <li class="reddit"><a href="<?php echo $reddit;?>" target="_blank"><span class="hiden-social">Reddit</span><i class="fa fa-reddit fa-2x" aria-hidden="true"></i></a></li>
            <?php endif; ?>
            <?php if($tumblr!==''): ?>
                <li class="tumblr"><a href="<?php echo $tumblr;?>" target="_blank"><span class="hiden-social">Tumblr</span><i class="fa fa-tumblr fa-2x" aria-hidden="true"></i></a></li>
            <?php endif; ?>
            <?php if($wechat!==''): ?>
                <li class="wechat"><a href="<?php echo $wechat;?>" target="_blank"><span class="hiden-social">WeChat</span><i class="fa fa-weixin fa-2x" aria-hidden="true"></i></a></li>
            <?php endif; ?>

            
            
             
            
           
          </ul>
        </div>


        <?php
    }













    public function redes_settings_page() {
        //Create the menu item and page
        $page_title = "Redes Sociales";
        $menu_title = "Redes Sociales";
        $capability = "manage_options";
        $slug = "redes_sociales";
        $callback = array( $this, 'settings_page_content' );
        add_menu_page($page_title, $menu_title, $capability, $slug, $callback,'dashicons-networking',20 );
    }
    /* Create the page*/
    public function settings_page_content() {
         // check user capabilities
        if (!current_user_can('manage_options')) {
            return;
        }
     if ( isset( $_GET['settings-updated'] ) ) {
     add_settings_error( 'redes_messages', 'redes_message', __( 'Settings Saved', 'simple_redes_sociales' ), 'updated' );
     }
     settings_errors( 'redes_messages' );

     ?>
        <div class="wrap">
            <h2> Redes Sociales </h2>
            <form method="post" action="options.php">
                <?php
                    settings_fields("redes_sociales");
                    do_settings_sections("redes_sociales");
                    submit_button();
                ?>
            </form>
    <?php }
    /* Setup section_callback */
    public function section_callback( $args ) {
       /* Set up input*/
        switch( $args['id'] ){
            case "redes_sociales_section" :
                echo __('Copy and paste the full Social Network URL','simple_redes_sociales');
                break;
            case "options_section":
                echo __('Manage the plugin colors','simple_redes_sociales');
            break;
        }
    }
    public function redes_setup_init() {
        register_setting("redes_sociales", "facebook");
        register_setting("redes_sociales", "twitter");
        register_setting("redes_sociales", "youtube");
        register_setting("redes_sociales", "instagram");
        register_setting("redes_sociales", "googleplus");
        register_setting("redes_sociales", "linkedin");
        register_setting("redes_sociales", "spotify");
        register_setting("redes_sociales", "pinterest");
        register_setting("redes_sociales", "reddit");
        register_setting("redes_sociales", "tumblr");
        register_setting("redes_sociales", "wechat");

        register_setting("redes_sociales", "background");

        add_settings_section(
            "redes_sociales_section", // $id. slug-name to identify section. used in 'id'
            __("Add your social networks",'simple_redes_sociales'), // $title. shown as the heading od section
            array($this, 'section_callback'), //$callback. echos out any content at the top of section
            "redes_sociales" //$page. the slug-name of the settings page on which to show the section.
            );

        add_settings_field(
            'facebook', // $id. slug-name to identify the field. used in id
            'Facebook URL: ', // $title. shown as labek
            array( $this, 'facebook_field_callback' ), //$callback. fills the field with desired form input
            'redes_sociales', //$page.  the slug-name of the settings page on which to show the section
            'redes_sociales_section' // $section. slug-name of the section of the settings page.
            );
        add_settings_field(
            'twitter', // $id. slug-name to identify the field. used in id
            'Twitter URL: ', // $title. shown as labek
            array( $this, 'twitter_field_callback' ), //$callback. fills the field with desired form input
            'redes_sociales', //$page.  the slug-name of the settings page on which to show the section
            'redes_sociales_section' // $section. slug-name of the section of the settings page.
            );
         add_settings_field(
            'youtube', // $id. slug-name to identify the field. used in id
            'Youtube URL: ', // $title. shown as labek
            array( $this, 'youtube_field_callback' ), //$callback. fills the field with desired form input
            'redes_sociales', //$page.  the slug-name of the settings page on which to show the section
            'redes_sociales_section' // $section. slug-name of the section of the settings page.
            );
          add_settings_field(
            'instagram', // $id. slug-name to identify the field. used in id
            'Instagram URL: ', // $title. shown as labek
            array( $this, 'instagram_field_callback' ), //$callback. fills the field with desired form input
            'redes_sociales', //$page.  the slug-name of the settings page on which to show the section
            'redes_sociales_section' // $section. slug-name of the section of the settings page.
            );
           add_settings_field(
            'googleplus', // $id. slug-name to identify the field. used in id
            'Google+ URL: ', // $title. shown as labek
            array( $this, 'googleplus_field_callback' ), //$callback. fills the field with desired form input
            'redes_sociales', //$page.  the slug-name of the settings page on which to show the section
            'redes_sociales_section' // $section. slug-name of the section of the settings page.
            );
            add_settings_field(
            'linkedin', // $id. slug-name to identify the field. used in id
            'LinkedIn URL: ', // $title. shown as labek
            array( $this, 'linkedin_field_callback' ), //$callback. fills the field with desired form input
            'redes_sociales', //$page.  the slug-name of the settings page on which to show the section
            'redes_sociales_section' // $section. slug-name of the section of the settings page.
            );
             add_settings_field(
            'spotify', // $id. slug-name to identify the field. used in id
            'Spotify URL: ', // $title. shown as labek
            array( $this, 'spotify_field_callback' ), //$callback. fills the field with desired form input
            'redes_sociales', //$page.  the slug-name of the settings page on which to show the section
            'redes_sociales_section' // $section. slug-name of the section of the settings page.
            );
              add_settings_field(
            'pinterest', // $id. slug-name to identify the field. used in id
            'Pinterest URL: ', // $title. shown as labek
            array( $this, 'pinterest_field_callback' ), //$callback. fills the field with desired form input
            'redes_sociales', //$page.  the slug-name of the settings page on which to show the section
            'redes_sociales_section' // $section. slug-name of the section of the settings page.
            );
               add_settings_field(
            'reddit', // $id. slug-name to identify the field. used in id
            'Reddit URL: ', // $title. shown as labek
            array( $this, 'reddit_field_callback' ), //$callback. fills the field with desired form input
            'redes_sociales', //$page.  the slug-name of the settings page on which to show the section
            'redes_sociales_section' // $section. slug-name of the section of the settings page.
            );
                add_settings_field(
            'tumblr', // $id. slug-name to identify the field. used in id
            'Tumblr URL: ', // $title. shown as labek
            array( $this, 'tumblr_field_callback' ), //$callback. fills the field with desired form input
            'redes_sociales', //$page.  the slug-name of the settings page on which to show the section
            'redes_sociales_section' // $section. slug-name of the section of the settings page.
            );
                add_settings_field(
            'wechat', // $id. slug-name to identify the field. used in id
            'WeChat URL: ', // $title. shown as labek
            array( $this, 'wechat_field_callback' ), //$callback. fills the field with desired form input
            'redes_sociales', //$page.  the slug-name of the settings page on which to show the section
            'redes_sociales_section' // $section. slug-name of the section of the settings page.
            );


        add_settings_section(
           "options_section", // $id. slug-name to identify section. used in 'id'
            __("Settings",'simple_redes_sociales'), // $title. shown as the heading od section
            array($this, 'section_callback'), //$callback. echos out any content at the top of section
            "redes_sociales" //$page. the slug-name of the settings page on which to show the section.            
            );

        add_settings_field(
            'background_color', // $id. slug-name to identify the field. used in id
            'Background: ', // $title. shown as labek
            array( $this, 'background_color_callback' ), //$callback. fills the field with desired form input
            'redes_sociales', //$page.  the slug-name of the settings page on which to show the section
            'options_section' // $section. slug-name of the section of the settings page.
            );
    }
    /* Create input fields*/
    public function facebook_field_callback ( $arguments ) {
        echo "<input name=\"facebook\" id=\"facebook\" type=\"text\" value=\"" .get_option("facebook"). "\"\>";?>
        <p class="description"><?php echo __( 'Add your Facebook URL', 'simple_redes_sociales' ); ?></p>
    <?php
    }
    public function twitter_field_callback ( $arguments ) {
        echo "<input name=\"twitter\" id=\"twitter\" type=\"text\" value=\"" .get_option("twitter"). "\"\>";?>
        <p class="description"><?php echo __( 'Add your Twitter URL', 'simple_redes_sociales' ); ?></p>
    <?php
    }
    public function youtube_field_callback ( $arguments ) {
        echo "<input name=\"youtube\" id=\"youtube\" type=\"text\" value=\"" .get_option("youtube"). "\"\>";?>
        <p class="description"><?php echo __( 'Add your Youtube URL', 'simple_redes_sociales' ); ?></p>
    <?php
    }
    public function instagram_field_callback ( $arguments ) {
        echo "<input name=\"instagram\" id=\"instagram\" type=\"text\" value=\"" .get_option("instagram"). "\"\>";?>
        <p class="description"><?php echo __( 'Add your instagram URL', 'simple_redes_sociales' ); ?></p>
    <?php
    }
    public function googleplus_field_callback ( $arguments ) {
        echo "<input name=\"googleplus\" id=\"googleplus\" type=\"text\" value=\"" .get_option("googleplus"). "\"\>";?>
        <p class="description"><?php echo __( 'Add your Google+ URL', 'simple_redes_sociales' ); ?></p>
    <?php
    }
    public function linkedin_field_callback ( $arguments ) {
        echo "<input name=\"linkedin\" id=\"linkedin\" type=\"text\" value=\"" .get_option("linkedin"). "\"\>";?>
        <p class="description"><?php echo __( 'Add your LinkedIn URL', 'simple_redes_sociales' ); ?></p>
    <?php
    }
    public function spotify_field_callback ( $arguments ) {
        echo "<input name=\"spotify\" id=\"spotify\" type=\"text\" value=\"" .get_option("spotify"). "\"\>";?>
        <p class="description"><?php echo __( 'Add your Spotify URL', 'simple_redes_sociales' ); ?></p>
    <?php
    }
    public function pinterest_field_callback ( $arguments ) {
        echo "<input name=\"pinterest\" id=\"pinterest\" type=\"text\" value=\"" .get_option("pinterest"). "\"\>";?>
        <p class="description"><?php echo __( 'Add your Pinterest URL', 'simple_redes_sociales' ); ?></p>
    <?php
    }
    public function reddit_field_callback ( $arguments ) {
        echo "<input name=\"reddit\" id=\"reddit\" type=\"text\" value=\"" .get_option("reddit"). "\"\>";?>
        <p class="description"><?php echo __( 'Add your Reddit URL', 'simple_redes_sociales' ); ?></p>
    <?php
    }
    public function tumblr_field_callback ( $arguments ) {
        echo "<input name=\"tumblr\" id=\"tumblr\" type=\"text\" value=\"" .get_option("tumblr"). "\"\>";?>
        <p class="description"><?php echo __( 'Add your Tumblr URL', 'simple_redes_sociales' ); ?></p>
    <?php
    }
    public function wechat_field_callback ( $arguments ) {
        echo "<input name=\"wechat\" id=\"wechat\" type=\"text\" value=\"" .get_option("wechat"). "\"\>";?>
        <p class="description"><?php echo __( 'Add your WeChat URL', 'simple_redes_sociales' ); ?></p>
    <?php
    }

    public function background_color_callback($args){
       echo '<input type="text" class="color-picker" data-alpha="true" data-default-color="rgba(0,0,0,0.85)" name="background" value="' . get_option("background") . '"/>';
    }






    public function color_theme_customize(){
        ?>
        <style type="text/css">
            .social ul li{background-color:<?php echo get_option("background"); ?>;}


        </style>

        <?php

    }



}
}

new SimpleRedesSociales();









 ?>
