<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="Somos uma loja de Vinhos, azeites, perfumes, Make e cosméticos importados com um preço muito competitivo">
    	<meta name="author" content="Bruno Lucio">

		<title>Loja de Perfumes e Vinho | Fragrância e Wine</title>
		<link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/bootstrap.min.css" type="text/css" />

		<link rel="icon" href="<?php echo BASE_URL; ?>assets/images/logo-bazar.png"/>

		<!-- jquery ui muito util -->
		<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/jquery-ui.min.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/jquery-ui.structure.min.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/jquery-ui.jquery-ui.theme.min.css" type="text/css" />

		<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style1.css" type="text/css" />

		<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/jquery.min.js"></script>
	</head>
	<body>
		<nav class="navbar topnav">
			 <button style="background-color:#DCDCDC" type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				 	<span class="sr-only">Toggle navigation</span>
			        <span style="background-color:white;" class="icon-bar"></span>
			        <span style="background-color:white;" class="icon-bar"></span>
			        <span style="background-color:white;" class="icon-bar"></span> 
			     </button>
			<div class="container">
				
			<div class="collapse navbar-collapse" id="myNavbar">

				<ul class="nav navbar-nav ">

					<li class="active"><a href="<?php echo BASE_URL; ?>"><?php $this->lang->get('HOME'); ?></a></li>
					<li><a href="<?php echo BASE_URL; ?>pages/who">Quem somos</a></li>

					<li><a target="_blank" href="https://www.facebook.com/pages/category/Wine-Spirits/Fragr%C3%A2ncia-Wine-748367015555087/"><img style="height: 16px;" src="<?php echo BASE_URL; ?>assets/images/facebook-icon.png"></a></li>
					<li><a target="_blank" href="https://www.instagram.com/fragranciawine4/"><img style="height: 16px;" src="<?php echo BASE_URL; ?>assets/images/insta-icon.png"></a></li>
				</ul>
			
				<ul class="nav navbar-nav navbar-right">
					
				<!--	*** multi-linguagem  ***
				<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php //$this->lang->get('LANGUAGE'); ?>
						<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="<?php //echo BASE_URL; ?>lang/set/en">English</a></li>
							<li><a href="<?php //echo BASE_URL; ?>lang/set/pt-br">Português</a></li>
							 <li><a href="<?php //echo BASE_URL; ?>lang/set/es">Espanhol</a></li> 
						</ul>
					</li> -->
					<?php if(!empty($this->sessLogin)): ?>
						<li><a href="<?php echo BASE_URL; ?>purchases">Minha compras</a></li>
						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $this->sessLogin['email']; ?>
								<span class="caret"></span></a>
								<ul class="dropdown-menu">
									 <li><a href="<?php echo BASE_URL; ?>login/change">Trocar senha</a></li>
									 <li><a href="<?php echo BASE_URL; ?>login/exit">Sair</a></li> 
								</ul>
						</li>
						
					<?php else: ?>

					<li><a href="<?php echo BASE_URL; ?>login"><?php $this->lang->get('LOGIN'); ?></a></li>
					<li><a href="<?php echo BASE_URL; ?>login/sign"><?php $this->lang->get('SIGN_UP'); ?></a></li>

					<?php endif; ?>
				</ul>
			</div>	

			</div>

		</nav>
		<header>

			<div class="container">
				<div class="row">
					<div class="col-sm-2 logo">
						<a href="<?php echo BASE_URL; ?>">
							<img src="<?php echo BASE_URL; ?>assets/images/logo-bazar.png" />
						</a>
					</div>
					<div class="col-sm-7">
						<div class="head_help">(11) 96841-5103</div>
						<div class="head_email">fragranciawinealpha@gmail.com</div>
						
						<div class="search_area">
							<form action="<?php echo BASE_URL; ?>busca" method="GET">
								<input type="text" name="s" value="<?php echo (!empty($viewData['searchTerm'])) ? $viewData['searchTerm']:''; ?>"  placeholder="<?php $this->lang->get('SEARCHFORANITEM'); ?>" />
						<input type="hidden" id="saleSuperior" name="filter[sale]" value="0">								
<select name="category" id="selectNewz">

									<option value=""><?php $this->lang->get('ALLCATEGORIES'); ?></option>
									<option data-lpe="ok" id="lpe" value="" <?php echo (isset($viewData['filters_selected']['sale']) && 
							$viewData['filters_selected']['sale'] == "1" )?'selected="selected"':''; ?>>Promoções</option>

									<?php foreach($viewData['categories'] as $cat): ?>
										<option <?php echo ($viewData['category']==$cat['id'])?'selected="selected"':''; ?> value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
							         	
							         	<?php 
							         		if(count($cat['subs']) > 0 ){
							         			$this->loadView('search_subcategory',array(
							         				'subs' => $cat['subs'],
							         				'level' => 1,
							         				'category' => $viewData['category']
							         			));
							         			
							         		} 
							         	?>
							         <?php endforeach; ?>


								</select>
								<input type="submit" value="" />
						    </form>
						</div>
					</div>
					<div class="col-sm-3">
						<a href="<?php echo BASE_URL; ?>cart">
							<div class="cartarea">
								<div class="carticon">
									<div class="cartqt"><?php echo $viewData['cart_qt']; ?></div>
								</div>
								<div class="carttotal">
									<?php $this->lang->get('CART'); ?>:<br/>
									<span>R$ <?php echo number_format($viewData['cart_subtotal'],2,',','.');  ?></span>
								</div>
							</div>
						</a>
					</div>
				</div>
			</div>
		</header>

<?php if(isset($viewData['banner'])): ?>
	
	<div class="container">
		<div class="row" class="back-baner">
			<div>
				<img style="width: 100%; margin-left: 5px; margin-top: 10px;" src="<?php echo BASE_URL; ?>assets/images/banner-toy.jpg" alt="" class="img_responsive m_bottom_8">
			</div>			
		</div>		
	</div> 


<!-- Slideshow banner
<div class="container">
<div class="row">
	<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
		

	
			<div class="carousel-inner" role="listbox">
				<div class="item active">
					<img src="<?php //echo BASE_URL; ?>assets/images/banner-toy.png" alt="banner um de vinhos" class="img_responsive m_bottom_8 banner-changed">
					
				</div>
				<div class="item">
					<img src="<?php //echo BASE_URL; ?>assets/images/banner-toy.png" alt="banner dois de vinhos" class="img_responsive m_bottom_8 banner-changed">
					
				</div>
				<div class="item">
					<img src="<?php //echo BASE_URL; ?>assets/images/banner-toy.png" alt="banner tres de vinhos" class="img_responsive m_bottom_8 banner-changed">
					
				</div>
				
			</div>


		  <a  style="background: transparent;" onMouseOver="this.style.background='rgba(255,255,255,0)'" class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
		    <span style="font-size: 14pt;" class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		    <span class="sr-only">Previous</span>
		  </a>
		  <a style="background: transparent;" onMouseOver="this.style.background='rgba(255,255,255,0)'" class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
		    <span style="font-size: 14pt;" class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
		    <span class="sr-only">Next</span>
		  </a>

		
	</div>

</div>
</div> -->


<?php endif; ?>

		<div class="categoryarea">
			<nav class="navbar">
				<div class="container">
					<ul class="nav navbar-nav">
						<li class="dropdown">
					        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php $this->lang->get('SELECTCATEGORY'); ?>
					        <span class="caret"></span></a>
					     
					        <ul style="background-color: white;" class="dropdown-menu">
					        
					         <?php foreach($viewData['categories'] as $cat): ?>
					         	<li>
					         		<a href="<?php echo BASE_URL.'categories/enter/'.$cat['id']; ?>">
					         			<?php echo $cat['name']; ?>
					         		</a>
					         	</li>
					         	<?php 
					         		if(count($cat['subs']) > 0 ){
					         			$this->loadView('menu_subcategory',array(
					         				'subs' => $cat['subs'],
					         				'level' => 1
					         			));
					         			
					         		}
					         	?>
					         <?php endforeach; ?>
					        </ul>
					      </li>
					    <?php if(isset($viewData['category_filter'])): ?>  
					    	<?php foreach($viewData['category_filter'] as $cf): ?>
							<li><a href="<?php echo BASE_URL; ?>categories/enter/<?php echo $cf['id']; ?>"><?php echo $cf['name']; ?></a></li>
							<?php endforeach; ?>
						<?php endif; ?>
					</ul>
				</div>
			</nav>
		</div>
		<section >
			<div class="container">
				<div class="row">

				<?php if(isset($viewData['sidebar'])): ?>

					<div class="col-md-3">

						<a class="btn btn-default form-control" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
						  Expandir Filtros <span class="caret"></span>
						</a><br><br>

						<div class="collapse" id="collapseExample">
						  <div>
						    <?php $this->loadView('sidebar', array('viewData'=>$viewData)); ?>	
						  </div>
						</div>					    		  
					</div>

					<div class="col-md-9"><?php $this->loadViewInTemplate($viewName, $viewData); ?></div>
				<?php else: ?>
					<div class="col-sm-12"><?php $this->loadViewInTemplate($viewName, $viewData); ?></div>
				<?php endif; ?>
				</div>
	    	</div>
	    </section>


<div id="whatswidget-pre-wrapper" class="">
<div id="whatswidget-widget-wrapper" class="whatswidget-widget-wrapper" style="all:revert;">
<div id="whatswidget-conversation" class="whatswidget-conversation" style="display: none; opacity: 0;"><div class="whatswidget-conversation-header" style="all:revert;">
<div id="whatswidget-conversation-title" class="whatswidget-conversation-title" style="all:revert;">Fragrância e Wine</div></div><div id="whatswidget-conversation-message" class="whatswidget-conversation-message " style="all:revert;">Acessei site da Fragrância e Wine, gostaria de saber mais</div><div class="whatswidget-conversation-cta" style="all:revert;"> <a style="all:revert;" id="whatswidget-phone-desktop" target="_blank" href="https://web.whatsapp.com/send?phone=+5511968415103" class="whatswidget-cta whatswidget-cta-desktop">Enviar Mensagem</a> <a id="whatswidget-phone-mobile" target="_blank" href="https://wa.me/+5511968415103" class="whatswidget-cta whatswidget-cta-mobile" style="all:revert;">Enviar Mensagem</a></div><a class="whatswidget-link" href="#" title="Feito no WhatsWidget" style="all:revert;"><img src=" data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAQAAAC1+jfqAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QAAKqNIzIAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAAHdElNRQfjBhQXLyFLI2siAAABBElEQVQoz33OPSjEcQDG8c/v/ogbkCiFRVJeyiCTl8FmkE0ZlAxkIpRMxCg2STcpUgYpJXd13SJZbUcWkcUgCyXJ8L+TQb7LMzwvPUFMmcaC8gEeYw0g4dCDTwzjFCWajPkqBjZc28eUKsGLFEZ1W4rnJ6yBDscSgiNdYN009DuQQLmMelAnI4lgz2CQd+cNrd49FC43qXCLpBaGpECfFUVW9YJtI7BoHkHmJ5ARsGCBCJfGlchr8+oJPSplDem3XGyUOtGl3SbY0qnDqTK/qJHT4Fwk4Uy9nNrYiAqBd1d2XYg0+zJrzn1shF8rA+Y9C6rtyPqTSTduzPiHtLR/iX5eFfgGDog51TrYD/cAAAAldEVYdGRhdGU6Y3JlYXRlADIwMTktMDYtMjBUMjE6NDc6MzMrMDI6MDDmYSb9AAAAJXRFWHRkYXRlOm1vZGlmeQAyMDE5LTA2LTIwVDIxOjQ3OjMzKzAyOjAwlzyeQQAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPBoAAAAASUVORK5CYII=" style="all:revert;"></a></div><div id="whatswidget-conversation-message-outer" class="whatswidget-conversation-message-outer" style="all:revert;"> <span id="whatswidget-text-header-outer" class="whatswidget-text-header-outer" style="all:revert;">Dúvidas?</span><br> <div id="whatswidget-text-message-outer" class="whatswidget-text-message-outer" style="all:revert;">Fale com a gente via Whats App</div></div><div class="whatswidget-button-wrapper" style="all:revert;"><div class="whatswidget-button" id="whatswidget-button" style="all:revert;"><div style="margin:0 auto;width:38.5px;all:revert;"> <img class="whatswidget-icon" style="all:revert;" src="<?php echo BASE_URL; ?>assets/images/icon-whats.png"></div></div></div>
<script id="whatswidget-script" type="text/javascript">document.getElementById("whatswidget-conversation").style.display="none";document.getElementById("whatswidget-conversation").style.opacity="0"; var button=document.getElementById("whatswidget-button");button.addEventListener("click",openChat);var conversationMessageOuter=document.getElementById("whatswidget-conversation-message-outer");conversationMessageOuter.addEventListener("click",openChat);var chatOpen=!1;function openChat(){0==chatOpen?(document.getElementById("whatswidget-conversation").style.display="block",document.getElementById("whatswidget-conversation").style.opacity=100,chatOpen=!0,document.getElementById("whatswidget-conversation-message-outer").style.display="none"):(document.getElementById("whatswidget-conversation").style.opacity=0,document.getElementById("whatswidget-conversation").style.display="none",chatOpen=!1)}</script></div>
<style id="whatswidget-style">.whatswidget-widget-wrapper{font-family:"Helvetica Neue","Apple Color Emoji",Helvetica,Arial,sans-serif !important;font-size:16px !important;position:fixed !important;bottom:20px !important;right:30px !important;z-index:1001 !important}.whatswidget-conversation{background-color:#e4dcd4 !important;background-image:url('data:image/png !important;base64,iVBORw0KGgoAAAANSUhEUgAAAGUAAABlCAYAAABUfC3PAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAAhHpUWHRSYXcgcHJvZmlsZSB0eXBlIGV4aWYAAAiZdY5dDoQwCITfOcUeYQqUluOYrCbewOM7tW6MD/slwPAbZD32TT6DAojX1iMjQDw9daHomBhQFGVE+skdrVApxXfmYjpFZG/wZ9DxpiJ6bM1pXDHV1YJmV5M3BOOFfA5E/X3zp34jJ5txK0wLhZMZAAABd2lUWHRYTUw6Y29tLmFkb2JlLnhtcAABAFVURi04AFhNTDpjb20uYWRvYmUueG1wAEiJ7ZaxTsMwFEX3foVl5thJKEOsuB1aUBkKCJBaxjR5Taw2TpQYYvprDHwSv4DdVi2qyojEYE+27/U99vPy4qGuk3QFCi0gF5Ljr49PjETG8exq6k/rERRismngaXP3nG5WaZTh4aAXa6bLugSVIF2uZcs0x0lWLYCZud2mGG0tasXxfPqARlUDqE/6xPeutXgL8aCH4iZbssfxzT7CrDgulKoZpV3Xke6SVE1OgyiKqB/SMPSMw2vfpUq0J9sLG7HLGEObNqJWopLIrpNF9ao4xkZH+3DQ4pguW7K9LEmrklqFBsSnP+1KLH+xW+Vot4fZg9Cwno9FCbI1V+A48IMT9eWMapPYbZnkMBOZKs4JExB5oU6U+0aAqYHahWFqK0n3pTQ/Qw9fM9g+6K+HgziIgziIgziIg/wrSC8+NHcgTUfXmdbtG8Nkm7OA2X6LAAATK0lEQVR4nO1d25bjOI4MgKSy5/+/bR/3cf+hLJLAPoCgaFu2JaeU6dptnFNTPVlpWSJIXAIBiP7nv/9L8a98lPBv38C/ci/xt2/g/5qICGoVqAoUAAEAEQIzmBlE9PIaEQBUFaUUiAhU7VIhMEIIYP73MG0VEUHOpa+lCxEhhICUIkIILxUTRQSlVtRSoAoQAQqFFoGoIsX4r2I2iIjgcrlARMGB8fU1gYigqqhVUGpBzhmqipTS02vFWivmeQYTI8YA5gBVQc4ZJWcQgJgSeMOx+/8qtvAVtQpCDJhSujJVzAIiIJeCXApCiGB+vJ6xioCIME0JIYT2Y7tg6RcJQP+33xMzrcvfIAIBm+z0mSIi8HWMMQ7raMLMSCmZ4sT8DfB4PSNUV51QjBEiipzLsgi/JKoKVYWIQETb/SiICMy8yU6fen/tf0IIDy2K36vq8jyP7rlFXw8e6Beec1l8U4CIQFTa7RCIlpNRRaClYEoJMcbfU8xycF8IbVrTqABqLUh6HR3XWiG12oOe/LBdCarQHgGi7yo3UUQMZuqLTyIopaDUCmJGbGajnyy7QA9N3RocrTxfIhnu/VbsngR4ckJcYuCAWgrmeUZskZaIopQMEUVK8VQnX6ugVgsjq0hfPOaAEPlpfC/NjpdSUUtFYIYCkGa7pdoiKRTUwnx/xiMVw+0ecylgEYSmGP8Oj8BEbHvQi++PIYTuP0qpIJa+y7g9xFlmQUQwzxdUEcQQkG6iltu/b2Wx0xk5C6pUO2kAePA3AEFUuuJTjC/D0j3ieUhgRikFKnK1brVaNEtESCm+tGAxBAbxF2opzWQJiAkpphYin5OjdN+hauF4SggPdpD/rjaPquq70xY+xtSTNWrOlm9OmCqDMEaUz8PSvWILnlriqMil9MVXBYgJMUSE8HqTR8B2Fd2EcmfY3luRZl8Dh+4PgMUnjH+ulaJgDogxIISAaUrdnrsy/DrtYcBAM812osz0HWfGPBwmIpS2ud2bERNS2JbNAwP29RNKuBVueYZicY6OHdXaTm5THFOzxe0TpRYA2h803ChVVFFLBYAOGdnvcVNyvQoajpIOTd1ax/asW+RHAclx15sjrhBRxGYhO3ZUS0MYYo+4/KEMp1OgnQyHhkYppZpth0VzVQImLAtGbN/vDvlo+a6iY875UKfncm9+WkjY/81sre/irqxqpiWmiBBGn2C7X8TOFXNb4JXnr9UUm2JEBZliqnTTxi1i0w/FyONZCjEsqF4ngApwsDDXAowl5HVFgVo+wWSfVYuoPCiw0HbxJ6vfD/TfQwMFPcPzfEc0fwupGD/73ZNxex+H7xUvAzg845A1tR0KXPuv8e8QGCIW75dc7BT00DZ2HzD+WZMYAkQEfy4XQLXjUQtA6KdPnsIdj8RyjtpN5xJ6718rQ5dnix7btU5RSs4ZCsPPQlxC1Fdi4W28UpT/2ZPwhWA+pFbp/3/8fg8cXmFQa8/mfk9UwEQtpLdTHeM+DM6ulaGwnJDazw5VyujEU0qYprR7F4Zwb5ZG3zTKo9PivuORZTYlB6jaImzNxXzD1ZbLETOoVguBRa984BaptSKXgilNSMlUcbnMxyulVjGfcQCUMTr/6rhS04v5ptB9095v4sCQDn1sv59S6lXNRGPCPF8scHjDR1G7Fy+IHW6+HGf6LrbkgUJukIUleeiL76cml4yczWfEHRVSajXzWmpHoHfcXQ8W7G/0YGKvTohtQ+WcIc3UllJOyFP6jb2nlK6QXCBiKLVHbI5Ya0OT/QRZToLNpeuOmWFBpbdsom72xMq7QbmfZmLaDaYHZqQYkRvEZQo+I3kkQGUJQffKGLmlVidZXegGpFYR5HlGyQUqimlKmxUDGNSzRykxRtvZ8wwJEbUaavAOl8ErkhaiG0KejjZfFtUwsr5nX23Xm0n5mr5eRjNuhmiamgMuqHVbzcTvte/0jZ9JyaJDD4ktMHm/+mmKDlBloBXxDlUKM4ODQmfd5UCBJb/x3OZWIZ6IjmVg910hhJ7t51L6jt5yv9LAya15hi+iCENVdofrj655VYp/+0oPxBLEJYTdngMAtS2oHekBXhFBdi5Vy9hiiIgR3WQEZmgMmOcMCductyEJ0hHmrfdqG4FwFsH0lKsSM1wxW0W1wSjEVzB+bZl5rVZZjNGSj5wz5pakAkNWTeYnZMN3O9A5Euc+QQ5Xitt5AJsftp+qVnsYfy61QsXCXnP8liMQkeUZ9ZqJ2EvXm5RipYCeA32InIKTMjOqLPD4FrOgaLZ1/Jln8WR4lpsqZm6FpNrwq8Em9xrNaxlt+TtK6cU3YCB3fL9Gc55SquwyC21pVv/ltjykjvuvie4LxokAJu6BwtYSsWf3peSOXluIe0/G2yurShm5V3bjtDnku0rM6r7d5zmDi9fhnUbrztihF6xEPk8V9ux+RaD8nLk4SikFl3nupWyFJb3IltnH+L5iHiol59wKSkZs2BP2mRkiCLZFNeORv03mmBlhYGsaRmTQy+1GWcwdbaZFEZkfu90Qz8RNM4Be1xGxzSCiqFIRNyp3TVYdvcPTzhapYgWrrTdtu4/6rt7yOc873Cz4Z5gZU0pWW4c2rMqSuBGF9u4BwMzR3g2EHdiVVAvNY0O0uRXtrOwA6DejuYc+ZYHL33OCxAxuJnDrKUsxImdrGXAY3E2nK6xd3QDKm+SyNDI6h31BpZ0+YKs3IrLfVNGrT4hqD1i+I6tKuc2IA+/nfzERZMdJscWPPVGc53zlNB9FNYYWL70fcYo9JN8qZi6xmZ7bGZE1I88zKoeOSDDTOY6e2ZpeHGy7JbZtEV/EWuvmaIiZzH9ooxCZVRmoQHZCXMkejHSFhIi4E4NyHlgYytWv79MSXGkkD4eUFIoQToq+Op7DDCjuTMXWGydiiJRd0VBsDMe5Ib+llMYsdJIdNWhEG2ulgsn8zgjPbBH3Q1KlF622SggBX19fKNWIHSDCV5gO4Sk/9Ck9kXvz+u7szTnv80nMjGmawMESRFGBFK88GhRjXQXUggDrQNtTa3f6qqoipvdI38yMRNRP7jsV0DU5lfnkkY02mtGenegPLC0R9VYCL5laKLtQlNZkjf7q/DEvbgUO3+rrPCKDv5XT6WgeNYnqbqDNI68tNnoMJrRFQeqNRypX/+2csKkFEp/WaHv6SeHG3VWRU/omR/ShE/+GiI/YilnEjBQWpr7f39G7/Ag5XSnWs/FeJXKUkfp6a4K64zMkHiF4FY+aUq75Y58sqvpT5qtsBiddeW6C4H6gK8R5xctpMH7wcgrOaqM7W6SVw8939L0O7rXwdVL2NRncsCUdzJJTOv1PbAnt7c7/2xTh4vDSPB9MxlsTIiDEgFoq/lwuHS8CMDSfujNui0+t9aEt/lKnuK9Z/KYSPLQ+YnxKzhm5FMQYfkIphBStz8+agYwA4Zn5YqZwZfe50UK38pDfkR4MvKHYI8enjF0KMfyAUoCFYF0777a1RQz9Itwy+Z/a+R6ledi9R3wRjxyf4ozLWg8meD//Ulo91r9hhqwreUYp1YbbTNMuxYxjP44Yn7Jcx9pAfrSX6RMiIkehnbL0DrzicM+R41PGiPFDG8xeyzudVEtDU4aKVVQXoHPHdy/fvP4L38ALY4x/r1IsxG7U0fjaH6kqSq1Gi+0Th7ZBOLfCRCg4b3zKX6wUZ+YLKBucY+H2/dACV8g8zyAYu7LWuhlXuxVm6405a3zKX6sUz1s81wmykLVvM3rvyweWfkfR9znAHrScNT7ldKUc2UU7ipervXvMWzDmmjsHixt91nofFdPXV+stqYjhe2MYzxyfcqWU62hhfxPMrYwJlvdiHJkIevVvzhm1VCi0U1rHzir3HSEEXEqjwX59f3DbWeNTrpRy1E52slwptU8WoqaMaZoO+x43IxOADPSxITEEBDJGPYArM2U/012Vylf3sOc6W4iOq+ZrzHb34Exj24JjQgabhEbwK6szFr8rfj0FUEsFEyFMAYGuH895v2/HrAfIFqLjnVL8Q5d57vWQEKwf/lnHr8Jmosx5Rh3IDD5fJefcbua9hO2VhBDwRYQLZsu2c8Y0TVe/00eAQFo/5c/PnnSiY0oRCuqY17j575TipkdbxiqqkDyjlIUFeHvcnObjxayUkrFSBjzL297OFCJCDAE5l17Xv/1Op5jO84xpmjZ1fB0tr4iOd45+UYhNqvPopndTqSKp9pCvwxatgSfFtMo8N9R3/5SHvcJsTJeRu9g5xrBBOzGaKc3FwuSfnNa6heh4t00sfCTEFDqPammjzp0nBaAjv/NlBgiYUnriyKmPy3iHRLFVrPkIg2PX3tpNWJDpmGKHW76+vt+3uFW2EB3vzZdazB/4OsxzhJfbMBv3Od4xM02T1U0ePJihDk0VJzZNuX32KXhzzpDWNkFE0Fyag/X5LNa+103uyTX8LUTHVUc/subHi40Fq8s8tz5Ea3fbVNTZ2mL1pkiDU6wVG9aUqrL0Q4IgLH34Zy9TazUWZ0o/MkL+FdHx3ssN5JA18UlDc26Zc+BDc493xfojWw8km0+ppSJN6Y6SuuRRBUpGGPTZxp8wQv6t0MPqCYbOprh3UtH70yieiS+0BR8VBMY0pVUUwW14jHGYi2wn7BNkt1KW5ktFCnFfG5kuielaE1K3t+/WzIfClc8efmRSe04QQ29f+BRe2L1Smt1/FLr6NFSLGvaFkgrt8+mNQnSjlMZm3DtWY6El1X4C9uBsa1Sl35Q7pRAaU/7BaAznb1kSuf1BeudTq/6N0A3B/KxW7TnSP/987VMM0IZOR6tlfNAi75V7pTAB8qQjuo3NmDgtIe4G6bUOYpthf1WMsuOpqhYxiTz8/jUhspaIOMyZ/GR5RW26U0pgRtXaEdbbi0nPjNeZjg9vpBHWUkp9J6/dVBWB5v3BgJmgXR/5FdlCbbp6DGr8KzwYjeEDa/bOiF9uBC9fFtaBuQ/f7e+IU5v+/Ln0PG9N7vZWaCdgrYG0sxl3LlhpmFncEj57gLHrGz5fRmpTldoZoWtypxRrHzAIoLMZm+yd5qCKzoqk1vv+ygGb4hVHvhzgSBmJ6Hs+s4fatKqUwDZBuw7vK/Rb2GPpVWVAYl8PVO5vdmgwzyeKESVspOKW6UfvUJsetmwvdYnacSP0dzJsuPlG7a+lIA1zd5/efBvQeXRl8kj5CWrTQ6WEEHvNgdoojj6O/EUDkKrasM1+A69N0agU/oXC01b5CWrTwz56Nze1VpSceynYmoDW2+X85mzkko10jfF1Zt1HlUubH/nLrwh8Jj9BbXr4r0RtsihTf6eUAn1y3W10NhbC5mxFr9QG3bykkzYn6Pb2t7LxrU7cqU0xxY6ATG2M/IhyxNh+r5WgdeM8/KfDDRYGeUbOdgx9IEwptdcpxqqkansTRCOlvVLIPM+dof5bNXPAp7kakjAClGtyNrXp6Qr4aQEBZVh08/QVpdjggVKWofw2ASI+PSF+qkqtKE3ZaXqtxLXrOGj6rrmz10QZdO+lwFIVUaQ/xyM5i9r0clv6vC0CIZfcXwDGiA1+lx4aRjT4hKl39o7ii+hvnfYy7SuY/VZUtTeqemvbO0N9AHsnpJvm0HZxlTZFHEAI09PPn0Ft2mQrun8hYFbY1J/A/dj6q/RqrfhzMXT5tqFmrKP41B9/u8JemN59kDTmpYi9J3La2ZEFtCl3VfCf//wzNMgG/PlzsRetPddJX58jqU2bDbjTiYxUwcu4vhA7QlvqQnZ2XGfJbKgPuYkprCpui3jsT0RI0zQMT5A2b2v79TpCQUvPIYA+37iz6Ddc70hq02aluMmw92qFvgALedocZG0EPq+duBChdfsuRax3RUXAYRl0owBKXt4FuVXHnZYLtAKZ3agDr0TbpxIdSW3aFeqISI/FFzhk8QPvNuHsFaM26QIBtfI00/5OAaf7lBYBElF7PyTtenPQkdSmzUrxNmvwEkMQ/XwZ1UP1ec4o5dLeGFTBIfSR63skhICvaTL0tr2s03hsafMGO5ratEkpyxACvRrcfEQvxl7xHCElbaaBwJE3wzmPrgcspQkDZcMmUPQMatPuTI2w2OHfEm9Aiuovd/7e5rjl9+6RM6hN+5XSaZa/i039xildkzOoTXHvGEEMi3E2g/7T5SxqE/t7C18K3fsSHSKgv0k6oXAPZebRtWDUppEQ8l2Jc0Nnn8EJRHQ3PMAnqeZcProodSs+FKG2iO3RYFBto5WeWYGzqE1sOcfrF9B0Gz4UdLR1cP0tYq2Dc39z0Xy52NuKVjC6xXc+F0+gj+xv4e0FXvTsuSsF6+1hnyoLKmGTtlXtZQK3daHf9pGsGxUCoM+Qr7V1DrfXNf0tp8UQuPY209bu5xiXy28rBADYW+Ve3UwP2xptaKRe/i0+xTqdDSK6/LlAxd5zzB90/6qK6DyvLTvEWuwKSmkz4tvrvz9hd20VbyF3vxFC+Cjin5UBWn/8M3GsRtHajBuUICrg8LvMk2WCg/Zi17PE8tPaHkZx6xOf9Sr25KhaxayPsQVdzQX+LXF4fJ5zhzpSirvfDvEJcplnKyeHgP8FbJ3FbCth4+oAAAAASUVORK5CYII=') !important;background-repeat:repeat !important;box-shadow:rgba(0, 0, 0, 0.16) 0px 5px 40px !important;width:250px !important;height:300px !important;border-radius:10px !important;transition-duration:0.5s !important;margin-bottom:80px !important}.whatswidget-conversation-header{background-color:white !important;padding:10px !important;padding-left:25px !important;box-shadow:0px 1px #00000029 !important;font-weight:600 !important;border-top-left-radius:10px !important;border-top-right-radius:10px !important}.whatswidget-conversation-message{line-height: 1.2em !important;background-color:white !important;padding:10px !important;margin:10px !important;margin-left:15px !important;border-radius:5px !important}.whatswidget-conversation-message-outer{background-color:#FFF !important;padding:10px !important;margin:10px !important;margin-left:0px !important;border-radius:5px !important;box-shadow:rgba(0, 0, 0, 0.342) 0px 2.5px 10px !important;cursor:pointer !important;animation:nudge 2s linear infinite !important;margin-bottom:70px !important}.whatswidget-text-header-outer{font-weight:bold !important;font-size:90% !important}.whatswidget-text-message-outer{font-size:90% !important}.whatswidget-conversation-cta{border-radius:25px !important;width:175px !important;font-size:110% !important;padding:10px !important;margin:0 auto !important;text-align:center !important;background-color:#23b123 !important;color:white !important;font-weight:bold !important;box-shadow:rgba(0, 0, 0, 0.16) 0px 2.5px 10px !important;transition:1s !important;position:absolute !important;top:62% !important;left:10% !important}.whatswidget-conversation-cta:hover{transform:scale(1.1) !important;filter:brightness(1.3) !important}.whatswidget-cta{text-decoration:none !important;color:white !important}.whatswidget-cta-desktop{display:none !important}.whatswidget-cta-mobile{display:inherit !important}@media (min-width: 48em){.whatswidget-cta-desktop{display:inherit !important}
.whatswidget-cta-mobile{display:none !important}}.whatswidget-button-wrapper{position:fixed !important;bottom:15px !important;right:15px !important}.whatswidget-button{position:relative !important;right:0px !important;background-color:#57bb63 !important;border-radius:100% !important;width:60px !important;height:60px !important;box-shadow:2px 1px #0d630d63 !important;transition:1s !important}.whatswidget-icon{width:42px !important;height:42px !important;position:absolute !important; bottom:10px !important; left:10px !important;}.whatswidget-button:hover{filter:brightness(115%) !important;transform:rotate(15deg) scale(1.15) !important;cursor:pointer !important}@keyframes nudge{20%,100%{transform:translate(0,0)}0%{transform:translate(0,5px);transform:rotate(2deg)}10%{transform:translate(0,-5px);transform:rotate(-2deg)}}.whatswidget-link{position:absolute !important;bottom:90px !important;right:5px !important;opacity:0.5 !important}</style>
</div>

	    <footer>
	    	<div class="container">
	    		<div class="row">
				  <div class="col-sm-4">
				  	<div class="widget">
			  			<h1><?php $this->lang->get('FEATUREDPRODUCTS'); ?></h1>
			  			<div class="widget_body">
			  				<?php $this->loadView('widget_item', array('list'=> $viewData['widget_featured2'])); ?>
			  			</div>
			  		</div>
				  </div>
				  <div class="col-sm-4">
				  	<div class="widget">
			  			<h1><?php $this->lang->get('ONSALEPRODUCTS'); ?></h1>
			  			<div class="widget_body">
			  				<?php $this->loadView('widget_item', array('list'=> $viewData['widget_sale'])); ?>
			  			</div>	
			  		</div>
				  </div>
				  <div class="col-sm-4">
				  	<div class="widget">
			  			<h1><?php $this->lang->get('TOPRATEDPRODUCTS'); ?></h1>
			  			<div class="widget_body">
			  				<?php $this->loadView('widget_item', array('list'=> $viewData['widget_toprated'])); ?>
			  			</div>
			  		</div>
				  </div>
				</div>
	    	</div>

	    	<div class="subarea">
	    		<div class="container">
	    			<div class="row">
						<div class="col-xs-12 col-sm-8 col-sm-offset-2 no-padding">
							<form method="POST" action="<?php echo BASE_URL; ?>home/newsletter">
                                <input type="email" class="subemail" name="newsletter" placeholder="Digite seu e-mail e receba promoções incríveis">
                                <input type="submit" value="Increva-se" />
                            </form>
						</div>
					</div>
	    		</div>
	    	</div>
	    	<div class="links">
	    		<div class="container">
	    			<div class="row">
						<div class="col-sm-4">
							<a href="<?php echo BASE_URL; ?>"><img width="150" src="<?php echo BASE_URL; ?>assets/images/logo-bazar.png" /></a><br/><br/>
							<strong>Vinhos e Perfumes</strong><br/><br/>

						</div><br><br>
						<div class="col-sm-8 linkgroups">
							<div class="row">
								<div class="col-sm-4">
									<h3><?php $this->lang->get('CATEGORIES'); ?></h3>
									<ul>
										<?php $ic = 0; 
										foreach($viewData['footerCategories'] as $cfitem): ?>
										<?php if($ic < 6): ?>
										<li><a href="<?php echo BASE_URL.'categories/enter/'.$cfitem[0]; ?>"><?php echo $cfitem[1]; ?></a></li>
								    	<?php endif;
										$ic++;
										endforeach; ?>
									</ul>
								</div>

								<div class="col-sm-4">
									<h3>Páginas informativas</h3>
									<ul>
										<li><a href="<?php echo BASE_URL; ?>pages/privacy">Política de Privacidade</a></li>
										<li><a href="<?php echo BASE_URL; ?>pages/terms">Termos de uso </a></li>
										<li><a href="<?php echo BASE_URL; ?>pages/devolution">Política de Devolução</a></li>
									</ul>
								</div>
								<div class="col-sm-4">
									<h3>Outras</h3>
									<ul>
										<li><a href="<?php echo BASE_URL; ?>">Contato</a></li>
										<li><a href="<?php echo BASE_URL; ?>pages/who">Quem somos</a></li>
									</ul>
									<img height="80" src="<?php echo BASE_URL; ?>assets/images/site_seguro_verde.png">
								</div>
							</div>
						</div>
					</div>
	    		</div>
	    	</div>
	    	<div class="copyright">
	    		<div class="container">
	    			<div class="row">
						<div class="col-lg-6">© <?php echo date('Y'); ?><span> Fragrância e Wine</span> - <?php $this->lang->get('ALLRIGHTRESERVED'); ?>.</div>
						<div class="col-lg-6">
							<div class="payments">
								<img src="<?php echo BASE_URL; ?>assets/images/mastercard.png" />
								<img src="<?php echo BASE_URL; ?>assets/images/visa.png" />
								<img src="<?php echo BASE_URL; ?>assets/images/american-icon.png" />
								<img src="<?php echo BASE_URL; ?>assets/images/elo_google.png" />
								<img src="<?php echo BASE_URL; ?>assets/images/diners.png" />
								<img src="<?php echo BASE_URL; ?>assets/images/hipercard.png" />

								<img src="<?php echo BASE_URL; ?>assets/images/Boleto.svg" />
							</div>
						</div>
					</div>
	    		</div>
	    	</div>
	    </footer>
		<script type="text/javascript">
			var BASE_URL = '<?php echo BASE_URL; ?>';
			<?php if(isset($viewData['filters'])): ?>
			var maxslider = <?php echo $viewData['filters']['maxslider']; ?>;
			<?php endif ?>
		</script>
		<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/jquery-ui.min.js"></script>
		<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/script2.js"></script>

	</body>
</html>
