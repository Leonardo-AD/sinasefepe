
<?php
/*
   Widget de notícias do NoticiadorWeb
   Author: Jorge Roberto - Mantis 5304

*/

function noticiadorWebWidget_register_widget() {
register_widget( 'noticiadorWebWidget' );
}
 
add_action( 'widgets_init', 'noticiadorWebWidget_register_widget' );
/**
 * Displays latest or category wised posts in a 3 block layout.
 */

class noticiadorWebWidget extends WP_Widget {

	/* Register Widget with WordPress*/
	function __construct() {
		parent::__construct(
		// widget ID
		'noticiadorweb_widget',
		// widget name
		__('NotíciadorWeb - Notícias', ' noticiadorweb_widget'),
		// widget description
		array( 'description' => __( 'Widget de notícias do NoticiadorWeb', 'noticiadorweb_widget' ), )
		);
	}


	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */

	public function form( $instance ) {
		//print_r($instance);
		$defaults = array(											
			'areas'  => __( '0:0', 'noticiadorweb_widget' ) , // Área padrão (não funciona)
			'number' => 1, // Quantidade de notícias
			'thumb'  => true, // Padrão é exibir a imagem da notícia
			'text'   => true, // Padrão é exibir o resumo da notícia
			'link'   => __( 'http://www.noticiadorweb.com.br/index.php?', 'noticiadorweb_widget' ), // Link de exibição padrão é no NoticiadorWeb
			'imgDefault'   => __( '#', 'noticiadorweb_widget' ), // Não tem imagem padrão                       			
		);

		$instance = wp_parse_args( (array) $instance, $defaults );

	?>
        
        <!-- Config -->	

        <!-- Áreas que serão exibidas pelo widget, deve ser informada seguindo o padrão: "area:quantidade,area:quantidade" -->			
		<p>
			<label for="<?php echo $this->get_field_id( 'areas' ); ?>"><?php _e( 'Áreas (área,área): ', 'noticiadorweb_widget' ); ?></label>
			<input type="text" placeholder="1000,1001" id="<?php echo $this->get_field_id( 'areas' ); ?>" name="<?php echo $this->get_field_name( 'areas' );?>" value="<?php echo $instance['areas']; ?>"/>			
		</p>

		<!-- Identificador que permite que mais de uma instância do html seja criada na página (deve ser único para funcionar corretamente) -->			
		<p>
			<label for="<?php echo $this->get_field_id( 'identificador' ); ?>"><?php _e( 'Identificador: (Deve ser único) ', 'noticiadorweb_widget' ); ?></label>
			<input type="text" placeholder="Noticias1" id="<?php echo $this->get_field_id( 'identificador' ); ?>" name="<?php echo $this->get_field_name( 'identificador' );?>" value="<?php echo $instance['identificador']; ?>"/>			
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Quantidade:', 'noticiadorweb_widget' ); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' );?>" value="<?php echo $instance['number']; ?>" size="3"/>
		</p>

		<!-- Check de exibir/não exibir a imagem da notícia -->
		<p>
			<label for="<?php echo $this->get_field_id('thumb'); ?>"><?php _e( 'Exibir imagem da notícia.', 'noticiadorweb_widget' ); ?></label>
			<input type="checkbox" <?php checked( $instance['thumb'], true ) ?> class="checkbox" id="<?php echo $this->get_field_id('thumb'); ?>" name="<?php echo $this->get_field_name('thumb'); ?>" />			
		</p>
        
        <!-- Check de exibir/não exibir o resumo da notícia -->
		<p>
			<label for="<?php echo $this->get_field_id('text'); ?>"><?php _e( 'Exibir resumo da notícia.', 'noticiadorweb_widget' ); ?></label>
			<input type="checkbox" <?php checked( $instance['text'], true ) ?> class="checkbox" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" />			
		</p>
        
        <!-- Link onde serão exibidas as notícias: deve ser preenchido com o caminho do site onde está o plugin do NoticiadorWeb: "https://noticiadorweb.com.br/noticia/"  -->
		<p>
			<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Link da notícia : ', 'noticiadorweb_widget' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" value="<?php echo esc_attr($instance['link']); ?>"/>
		</p>
        
        <!-- Link da imagem que irá aparecer se a notícia não tiver imagem -->
		<p>
			<label for="<?php echo $this->get_field_id( 'imgDefault' ); ?>"><?php _e( 'Imagem Padrão : ', 'noticiadorweb_widget' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'imgDefault' ); ?>" name="<?php echo $this->get_field_name( 'imgDefault' ); ?>" value="<?php echo esc_attr($instance['imgDefault']); ?>"/>
		</p>		

	<?php

	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */

	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance[ 'areas' ]  = strip_tags( $new_instance[ 'areas' ] );
		$instance[ 'identificador'  ]  = strip_tags( $new_instance[ 'identificador' ] );
		$instance[ 'number' ] = strip_tags( $new_instance[ 'number' ] );
		$instance[ 'thumb' ]  = (bool)$new_instance[ 'thumb' ];
		$instance[ 'text'  ]  = (bool)$new_instance[ 'text' ];
		$instance[ 'link'  ]  = strip_tags( $new_instance[ 'link' ] );
		$instance[ 'imgDefault'   ] = strip_tags( $new_instance[ 'imgDefault' ] );
						
		return $instance;
	}


	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */

	public function widget( $args, $instance ) {

		extract($args);
		                  
		$areas = $instance[ 'areas' ] ?: __( '0:0', 'noticiadorweb_widget' );
		$identificador  = $instance[ 'identificador' ] ?: __( date('YmdhisU'), 'noticiadorweb_widget' ); 
		$number = ( isset( $instance['number'] ) ) ? $instance['number'] : true; 
		$thumb = ( isset( $instance['thumb'] ) ) ? $instance['thumb'] : true;
		$text  = ( isset( $instance['text'] ) ) ? $instance['text'] : true;
		$link  = $instance[ 'link' ] ?: __( 'https://www.noticiadorweb.com.br/index.php?action=show&secao=exibir_noticia&', 'noticiadorweb_widget' ); 
		$imgDefault   = $instance[ 'imgDefault' ] ?: __( '#', 'noticiadorweb_widget' ); 
		
		echo $before_widget;

		?>	
		
 
    <div class="row" id="<?php echo $identificador;?>"></div>
      
	<script type="text/javascript">

		var areas  = "<?php echo $areas;?>";
		var number = "<?php echo $number > 0 ? $number : 0;?>";
		var thumb  = "<?php echo $thumb;?>";
		var img    = "<?php echo $imgDefault;?>";
	    var text   = "<?php echo $text;?>";
	    var link   = "<?php echo $link;?>";

	    console.log(areas);

		jQuery.ajax({

        url: "https://www.noticiadorweb.com.br/index.php?secao=api&action=site",
        type: "POST",
        dataType: "JSON",
        data: { areas: areas.split(","), quantidade:number }

        }) .always(function(response) {
        	console.log(response);
 		
		 jQuery.each(response, function(index, not) {


		 	if(not){

                image = (not.imagem ? not.imagem : img);

		 	    content = '<div class="col-md-4 col-sm-10 noticiadorWebWidgetContainer">'		 						
		 					    +'<a href="'+link+'noticia_id='+not.id+'&idGN=0&qtdNot=0" >';

		 					if (thumb) { // se mostrar a imagem da notícia

		 						content +='<img class ="noticiadorWebWidgetThumbnail" src="'+image+'">';
		 					}
		 					
		 					    content += '<div class="caption">'
		 					              +'<h3 class ="noticiadorWebWidgetTitle">'+not.titulo+'</h3>';

		 					if (text) { // se mostrar o resumo da notícia

		 						content +='<p class="noticiadorWebWidgetContent">'+not.content+'</p>';
		 					}

		 					content += '</a><br></div></div>';

		 	document.querySelector("#<?php echo $identificador;?>").insertAdjacentHTML('beforeend', content);
		 	}
		 	
		 });
		 
     });
     
  </script>
	<?php 

	echo $after_widget;
	}
}

//Centralizar as notícias na página de notícias e colocar o script de janela livre em (Notícias) usando a api com php;
//Estilizar a aba de notícias com css; 
//Configurar o hover dos dropdown na página inicial;