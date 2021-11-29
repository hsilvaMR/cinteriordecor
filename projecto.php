<!doctype html>
<html lang="pt-pt">
<head>
<meta charset="utf-8">
<title>Ci | Interior Decor</title>
<? include '_head.php';?>

<!-- FACEBOOK -->
<? $url_completo = $_SERVER['REQUEST_URI'];
$url_partes = explode("/", $url_completo);
$id_linha = urldecode($url_partes[2]);
$id_linha = filter_var($id_linha, FILTER_VALIDATE_INT);
$linha = mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM projeto WHERE id = '$id_linha'")); 
$id_projeto = $linha['id'];
$nome = $linha['nome_'.$LANG];
$texto = $linha['texto_'.$LANG];

$linha2 = mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM projeto_gal WHERE id_projeto = '$id_linha' ORDER BY ordem ASC"));
$img = $linha2['img'];?>
<meta property="og:title" content="<? echo $nome?>"/>
<meta property="og:url" content="http://www.ci-interiordecor.com<? echo $url_completo;?>"/>
<meta property="og:image" content="http://www.ci-interiordecor.com<? echo $img;?>"/>
<meta property="og:site_name" content="Ci-interiordecor"/>
<meta property="og:description" content="<? echo $texto?>"/>

<link rel="canonical" href="http://www.ci-interiordecor.com<? echo $url_completo;?>" />
<script>
  $(document).ready(function(){ $.post('https://graph.facebook.com',{id:'http://www.ci-interiordecor.com<? echo $url_completo;?>',scrape:true},function(response){console.log(response);});});
</script>

<!-- SLIDE -->
<link rel="stylesheet" href="/swiper/swiper.css" type="text/css">
<script type="text/javascript" src="/swiper/swiper.js"></script>
</head>

<body>
<? 
  $sepCor='projectos'; 
  include '_header.php';
  include '_login.php';
  include '_register.php';
  include '_new-password.php';
  include '_modal-boas-vindas.php';
?>
<div class="barraH"></div>
<article>
	<!--<div class="projeNome"><? echo nl2br($nome);?></div>-->
	<div class="projeLista">
    <div class="projeP">
      <div class="projePCont">
        <?if($nome){?><p class="projePTit"><? echo nl2br($nome);?></p><?}?>
        <?if($texto){?><p class="projePTex"><? echo nl2br($texto);?></p><?}?>
        <!--<a href="/projectos"><div class="voltar"></div></a>-->
      </div>
    </div>
		<?php
		$num = 0;
		$query = mysqli_query($lnk, "SELECT * FROM projeto_gal WHERE id_projeto = '$id_linha' AND online = 1 ORDER BY ordem ASC");
		while ($linha2 = mysqli_fetch_array($query)){
			$img = $linha2['img'];
			?>
			<div class="projeItem" style="background-image:url('<? echo "$img";?>');" onClick="slideshow(<? echo "$num";?>);"></div>
			<?php
			$num++;
		}
		?>
		<div class="clear"></div>
    <a href="/projectos"><div class="voltar"><? if($LANG=='pt'){echo "Voltar";} if($LANG=='en'){echo "Back";} ?></div></a>
    <div class="clear height30"></div>
	</div>
	<div class="clear"></div>
</article>

<button id="myBtn">Top</button>
 <script>
 // scroll to top 
$('#myBtn').on('click', function() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
});

window.onscroll = function() {

    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        $('#myBtn').css("display", "block");
    } else {
        $('#myBtn').css("display", "none");
    }
}
 </script>

<? include '_footer.php';?>
<!-- Swiper -->
<div id="projeSlide">
    <div class="swiper-container gallery-top">
        <div class="swiper-wrapper">
        	<?php
          $query = mysqli_query($lnk, "SELECT * FROM projeto_gal WHERE id_projeto = '$id_linha' AND online = 1 ORDER BY ordem ASC");
          while ($linha3 = mysqli_fetch_array($query)){
          	$img = $linha3['img'];
          	?>
          	<div class="swiper-slide" style="background-image:url(<? echo "$img";?>)"></div>
          	<?php
          } ?>
        </div>
        <!-- Add Arrows -->
        <div class="swiper-button-next swiper-button-white"></div>
        <div class="swiper-button-prev swiper-button-white"></div>
        <span class="swiper-close" onClick="slidehidden();"></span>
    </div>
</div>
<script>
$(document).keyup(function(e) {
     if (e.keyCode == 27) { slidehidden('projeSlide'); }
});
function slideshow(num_slide){
	Swiper('.swiper-container', {
        slidesPerView: 1,
        spaceBetween: 80,
        keyboardControl: true,
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
		loop: true,
		initialSlide: num_slide,
	});
	$('#projeSlide').css("visibility","visible");
	$('#projeSlide').css("opacity","0");
	$("#projeSlide").animate({opacity:"1"},300);
}
function slidehidden(){
	$("#projeSlide").animate({opacity:"0"},200);	
	setTimeout(function(){ $('#projeSlide').css("visibility","hidden"); }, 200);
}
var swiper = new Swiper('.swiper-container', {
    slidesPerView: 1,
    spaceBetween: 80,
    keyboardControl: true,
    nextButton: '.swiper-button-next',
    prevButton: '.swiper-button-prev',
	loop: true,
	initialSlide: 0,
});

</script>
<script>
    /*$(document).ready(function() {
      var mySwiperFullscreen;
      var photos = [];

      var init = function() {
        var $self = $(this);
        var $parent = $self.parent();
        var indexClicked = $parent.index() + 1;

        var imgFullscreen = $self.data('url-fullscreen');
        photos.push(imgFullscreen);

        var clickHandler = function() {
          if (!$('body').hasClass('show-popup-fullscreen')){
            //$('.popup-fullscreen > div').get(0).webkitRequestFullScreen();
            $('body').addClass('show-popup-fullscreen');
            mySwiperFullscreen.update();
          }
          mySwiperFullscreen.slideTo(indexClicked, 0, false);
        };
        $self.on('click', clickHandler);
      };
      $('.gal-photo').each(init);

      var elements = photos.reduce(function(previousValue, currentValue, index, array) {
        return previousValue + '<div class="swiper-slide"><article style="background-image: url(' + currentValue + ')"></article></div>';
      }, '');
      $('.popup-fullscreen .swiper-wrapper').empty().append(elements);

      var closePopup = function() {
        $('body').removeClass('show-popup-fullscreen');
        document.webkitExitFullscreen();
      };

      $('.popup-fullscreen .action.close').on('click', closePopup);
      $(document).on('keyup', function(e) {
        if(e.keyCode == 27){
          closePopup();
        }
      });

      mySwiperFullscreen = new Swiper ('.swiper-container-fullscreen', {
        // Optional parameters
        direction: 'horizontal',
        loop: true,
        autoplay: 0,

        // If we need pagination
        pagination: '.swiper-pagination',

        // Navigation arrows
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev'
      });
    });*/
  </script>
</body>
</html>