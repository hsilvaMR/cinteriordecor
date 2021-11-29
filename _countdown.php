<?php
$hoje=date('Y-m-d');
$linhaCountdownPromo = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM promocao WHERE inicio<='$hoje' AND fim>='$hoje' AND countdown!='' ORDER BY valor DESC"));
if(isset($linhaCountdownPromo['countdown']) && $linhaCountdownPromo['countdown']){
?>
<section class="countdown">
    <img src="<?php echo $linhaCountdownPromo['countdown']; ?>">
</section>
<?php
}else{
	$linhaCountdownBanner = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM banner WHERE inicio<='$hoje' AND fim>='$hoje' AND countdown!='' ORDER BY ordem ASC"));
	if(isset($linhaCountdownBanner['countdown']) && $linhaCountdownBanner['countdown']){
	?>
	<section class="countdown">
	    <img src="<?php echo $linhaCountdownBanner['countdown']; ?>">
	</section>
<?php }
} ?>