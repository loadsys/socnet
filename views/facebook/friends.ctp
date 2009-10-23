<?php if ( FacebookAuth::isEnabled() ): ?>
<fb:container>
<?php foreach($friends as $friend): ?>
	<div style="float:left;">
	<fb:profile-pic uid="<?php echo $friend; ?>" size="square" linked="true"></fb:profile-pic>
	</div>
<?php endforeach; ?>
</fb:container>
<?php endif; ?>
