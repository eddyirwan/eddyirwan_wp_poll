<script type="text/javascript">
jQuery(document).ready(function($) {
	$('#ei_poll').submit(function() {
	  return false;
	});
	$( "#ei_pollBtnSubmit" ).click(function() {		
		$.ajax({
			url: "<?php echo get_site_url(); ?>/wp-admin/admin-ajax.php",
			type: 'POST',
			data: {
				'action':'ei_voteThruAjax',
				'lang':'<?php echo $this->lang; ?>',
				'idOfButtonThatUserClick' : $("input[name='ei_poll']:checked").val()
			},
			success:function(result) {
			  	$("#eiPollPane").html(result);
			},
			error: function(errorThrown){
			    console.log(errorThrown);
			}
		});	 
		
	}); 
	$( "#ei_viewResult" ).click(function() {		
		$.ajax({
			url: "<?php echo get_site_url(); ?>/wp-admin/admin-ajax.php",
			type: 'POST',
			data: {
				'action':'ei_seeResultFromAjax',
				'lang':'<?php echo $this->lang; ?>',
				'idOfButtonThatUserClick' : $("input[name='ei_poll']:checked").val()
			},
			success:function(result) {
			  	$("#eiPollPane").html(result);
			},
			error: function(errorThrown){
			    console.log(errorThrown);z
			}
		});	 
		
	});   	  	     
});
</script>
<div id="eiPollPane">
<form id="ei_form">
	<p><?php echo $title; ?></p>
	<?php foreach ($rows2 as $row) { 
	$x++;
	?>
	<div class="radio">
	  <label>
	    <input type="radio" name="ei_poll" 
	    	id="optionsRadios<?php echo $x; ?>" 
	    	value="<?php echo $row->id; ?>" 
	    	<?php if ($row->checked == 1) { ?>
	    		checked="checked"
	    	<?php } ?>>
	    <?php 
	    if ($this->lang == "default") {
	    	echo $row->title_default;
	    }
	    else {
	    	$lang='title_'.$this->lang;
	    	echo $row->$lang;
	    }
	    ?>
	  </label>
	</div>
	<?php } ?>
	<div>
	<button type="button" class="btn btn-default btn-sm" id="ei_pollBtnSubmit">
	  <?php ei_pollLocalization::_output('send'); ?>
	</button>
	</div>
	<p><small><?php ei_pollLocalization::_output('totalVote'); ?> <?php echo $totalVote; ?></small> </p>
	<p><small><a href="javascript:void(0)" id="ei_viewResult"><?php ei_pollLocalization::_output('viewResult'); ?></a></small> </p>
</form>
</div>

