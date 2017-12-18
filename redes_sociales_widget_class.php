<?php 
class redes_sociales_class extends WP_Widget{

	public function __construct(){

		$opciones=array(
			"classname" => "redesSocialesWidget",
			"description"=> "Despliega tus redes sociales dónde quieras"
			);

		parent::__construct("css_id","Simple Redes Sociales",$opciones);

	}

	public function form($instance){
		$defaults=array(
			"titulo"=>"Redes Sociales"
			);
		$instance= wp_parse_args((array)$instance,$defaults);
		$titulo= esc_attr($instance['titulo']);
		?>
		<p>Titulo: <input type="text" name="<?php echo $this->get_field_name("titulo"); ?>" value="<?php echo $titulo; ?>" class="widefat"></p>

		<?php
	}

	public function update($new_instance, $old_instance){
		$instance= $old_instance;
		$instance["titulo"]= strip_tags($new_instance["titulo"]);
		return $instance;
	}

	public function widget($args, $instance){
		extract($args);
		$titulo=apply_filters('widget_title',$instance["titulo"]);
		echo $before_widget;
		echo $before_title.$titulo.$after_title;

		$facebook = get_option('facebook');
        $twitter=get_option('twitter');
        $youtube=get_option('youtube');
        $instagram=get_option('instagram');
        $googleplus=get_option('googleplus');
        $linkedin=get_option('linkedin');
        $spotify=get_option('spotify');
        $pinterest=get_option('pinterest');
        $reddit=get_option('reddit');
        $tumblr=get_option('tumblr');
        $wechat=get_option('wechat');
		?>
		<div class="container-fluid">
			<div class="row">
				<ul>
				
					<?php if(!empty($facebook)): ?><li class="facebook"><a href="<?php echo $facebook;?>" target="_blank"><span class="fa-stack fa-lg"><i class="fa fa-square-o fa-stack-2x"></i><i class="fa fa-facebook fa-stack-1x"></i></span></a></li> <?php endif; ?>
					<?php if($youtube!==''): ?><li class="youtube"><a href="<?php echo $youtube;?>" target="_blank"><span class="fa-stack fa-lg"><i class="fa fa-square-o fa-stack-2x"></i><i class="fa fa-youtube fa-stack-1x"></i></span></a></li> <?php endif; ?>
					<?php if($instagram!==''): ?><li class="instagram"><a href="<?php echo $instagram;?>" target="_blank"><span class="fa-stack fa-lg"><i class="fa fa-square-o fa-stack-2x"></i><i class="fa fa-instagram fa-stack-1x"></i></span></a></li> <?php endif; ?>
					<?php if($twitter!==''): ?><li class="twitter"><a href="<?php echo $twitter;?>" target="_blank"><span class="fa-stack fa-lg"><i class="fa fa-square-o fa-stack-2x"></i><i class="fa fa-twitter fa-stack-1x"></i></span></a></li> <?php endif; ?>
					<?php if($googleplus!==''): ?><li class="googleplus"><a href="<?php echo $googleplus;?>" target="_blank"><span class="fa-stack fa-lg"><i class="fa fa-square-o fa-stack-2x"></i><i class="fa fa-google-plus fa-stack-1x"></i></span></a></li> <?php endif; ?>
					<?php if($linkedin!==''): ?><li class="linkedin"><a href="<?php echo $linkedin;?>" target="_blank"><span class="fa-stack fa-lg"><i class="fa fa-square-o fa-stack-2x"></i><i class="fa fa-linkedin fa-stack-1x"></i></span></a></li> <?php endif; ?>
					<?php if($spotify!==''): ?><li class="spotify"><a href="<?php echo $spotify;?>" target="_blank"><span class="fa-stack fa-lg"><i class="fa fa-square-o fa-stack-2x"></i><i class="fa fa-spotify fa-stack-1x"></i></span></a></li> <?php endif; ?>
					<?php if($pinterest!==''): ?><li class="pinterest"><a href="<?php echo $pinterest;?>" target="_blank"><span class="fa-stack fa-lg"><i class="fa fa-square-o fa-stack-2x"></i><i class="fa fa-pinterest fa-stack-1x"></i></span></a></li> <?php endif; ?>
					<?php if(!empty($reddit)): ?><li class="reddit"><a href="<?php echo $reddit;?>" target="_blank"><span class="fa-stack fa-lg"><i class="fa fa-square-o fa-stack-2x"></i><i class="fa fa-reddit fa-stack-1x"></i></span></a></li> <?php endif; ?>
					<?php if($tumblr!==''): ?><li class="tumblr"><a href="<?php echo $tumblr;?>" target="_blank"><span class="fa-stack fa-lg"><i class="fa fa-square-o fa-stack-2x"></i><i class="fa fa-tumblr fa-stack-1x"></i></span></a></li> <?php endif; ?>
					<?php if($wechat!==''): ?><li class="wechat"><a href="<?php echo $wechat;?>" target="_blank"><span class="fa-stack fa-lg"><i class="fa fa-square-o fa-stack-2x"></i><i class="fa fa-weixin fa-stack-1x"></i></span></a></li> <?php endif; ?>
				</ul>
			</div>
		</div>


	
		<?php
		echo $after_widget;

	}


}

 ?>