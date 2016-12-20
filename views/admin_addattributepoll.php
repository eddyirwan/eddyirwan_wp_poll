<h2>JPN POLL &gt; <small>ADD NEW POLL</small></h2>
<style>
.attributePlaceholder {
    border:1px solid #cccccc;
    padding:15px;
}
.gapAboveTitle {
    margin-top:10px;
    font-weight: bold;
}
</style>
<?php
if ( is_wp_error( $reg_errors ) ) {
    echo '<div class="alert alert-warning"><strong>ERROR</strong>';
    foreach ( $reg_errors->get_error_messages() as $error ) {
        echo '<div>';
        echo $error;
        echo '</div>';
    }
    echo '</div>';
}
?>
<div style="height:10px"></div>
<form action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>&noheader=true" method="post">
<input type="hidden" name="pluginname" value="<?php echo PLUGIN_NAME; ?>"/>
<input type="hidden" name="id" value="<?php echo $idfromUrl; ?>"/>
<input type="hidden" name="maxAttr" value="<?php echo $maxAttr; ?>"/>
<input type="hidden" name="page" value="listAddPollAttribute"/>
<div class="attributePlaceholder">
<?php
for ($x=0;$x<$maxAttr;$x++) {
    $default="attr".$x."-default";
    $en="attr".$x."-en";
?>
<div class="gapAboveTitle">Attribute <?php echo $y=$x+1; ?></div>
<table class="table">
<tr>

<td>
Default: </td><td><input type="text" name="<?php echo $default; ?>" 
    pattern="[a-zA-Z0-9 ]+" 
    value="<?php echo ( isset( $_POST[$default] ) ?  esc_attr( $_POST[$default] ) : '' ); ?>" 
    size="40" />
    </td>
    </tr>
<tr><td>
En: </td><td><input type="text" name="<?php echo $en; ?>" 
    pattern="[a-zA-Z0-9 ]+" 
    value="<?php echo ( isset( $_POST[$en] ) ?  esc_attr( $_POST[$en] ) : '' ); ?>" 
    size="40" />
    </td></tr>
</table>
<?php } ?>



</div>
<p><input type="submit" class="btn btn-submit" value="Send"></p>
</form>
