<div id="eiPollPane">
	<p><?php echo $title; ?></p>
	<?php foreach ($rows2 as $row) { 
	$x++;
	?>
	<div class="radio">
	  <code>
	    <?php 
	    if ($this->lang == "default") {
	    	echo $row->title_default;
	    }
	    else {
	    	$lang='title_'.$this->lang;
	    	echo $row->$lang;
	    }
	    ?> 
	    <small>[ <?php echo $row->vote; ?> <?php ei_pollLocalization::_output('vote'); ?> ]</small>
	  </code>
	  	<div class="progress">
	  		<div 
	  			class="progress-bar progress-bar-info" 
	  			role="progressbar" 
	  			aria-valuenow="<?php echo frontend::calculate($row->vote,$totalVote); ?>" 
	  			aria-valuemin="0" 
	  			aria-valuemax="100" 
	  			style="width: <?php echo frontend::calculate($row->vote,$totalVote); ?>%;">
	    	<?php echo frontend::calculate($row->vote,$totalVote); ?>%
	  		</div>
		</div>
	</div>
	<?php } ?>
	<p><small><?php ei_pollLocalization::_output('totalVote'); ?> <?php echo $totalVote; ?></small> </p>
</form>
</div>

