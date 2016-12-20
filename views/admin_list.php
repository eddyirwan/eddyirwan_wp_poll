    <style>
    .nopaddingandmargin {
        margin:0 !important;
        padding:0 !important;
        padding-left:20px !important;
    }
    </style>
    <h2>JPN POLL</h2>
    <form action="admin.php" method="get">
    <input type="hidden" name="page" value="listAddPoll"/>
    <div class="tablenav top">
        <div class="alignleft actions">
            <input type="submit" class="button" value="ADD POLL">
            <input type="text" name="maxAttr" 
                pattern="[2-5]" 
                value="5"
                title="From 2 until 5"
                size="2" />
        </div>
        <br class="clear">
    </div>
    </form>

    <table class='table wp-list-table widefat  striped'>
        <tr>
            <th style="width:5%">ID</th>
            <th style="width:35%">Title</th>
            <th style="width:10%">Status</th>
            <th style="width:50%">Attribute</th>
        </tr>
        <?php foreach ($rows as $row) { ?>
            <tr>
                <td><?php echo $row->id; ?></td>
                <td>
                    <code>Default</code>
                    <p><?php echo $row->title_default; ?></p>
                    <code>English</code>
                    <p><?php echo $row->title_en; ?></p>
                    <div>
                    <a href="<?php echo admin_url('admin.php?page=listUpdatePoll&id=' . $row->id); ?>">Update</a> 
                    ::
                    <a href="<?php echo admin_url('admin.php?task=deleteall&page=listDeletePoll&noheader=true&id=' . $row->id); ?>" onclick="return confirm('Are you sure?')">Delete</a>
            

                </td>
                <td><?php echo StringHelper::returnTextForStatus($row->status); ?></td>
                <td> 
                    <p><code>Description</code></p>
                    <table class="table">
                    <?php 
                        $y=0;
                        foreach ($row->child as $rowchild) { 
                        $y++;
                    ?>    
                    <tr>
                    <td class="nopaddingandmargin"><?php echo $y; ?>)</td>
                    <td class="nopaddingandmargin">Default: <b><?php echo $rowchild->title_default; ?></b></td>                       
                    <td class="nopaddingandmargin">En: <b><?php echo $rowchild->title_en; ?></b></td>
                    <td class="nopaddingandmargin">[ <a href="<?php echo admin_url('admin.php?task=deleteattribute&page=listDeletePoll&noheader=true&id=' . $rowchild->id); ?>" onclick="return confirm('Are you sure?')">Delete</a> ]</td>
                    </tr>
                    <?php } ?>
                    <tr><td colspan="4">
                        <a class="button"
                        href="<?php echo admin_url('admin.php?task=clearattribute&page=listDeletePoll&noheader=true&id=' . $row->id); ?>" 
                        onclick="return confirm('Are you sure?')">CLEAR ALL ATTRIBUTE</a>
                        <form action="admin.php" method="get">
                        <input type="hidden" name="page" value="listAddPollAttribute"/>
                        <input type="hidden" name="id" value="<?php echo $row->id; ?>"/>
                        <div class="tablenav top">
                            <div class="alignleft actions">
                                <input type="submit" class="button" value="ADD ATTRIBUTE">
                                <input type="text" name="maxAttr" 
                                    pattern="[1-3]" 
                                    value="2"
                                    title="From 1 until 3"
                                    size="2" />
                            </div>
                            <br class="clear">
                        </div>
                        </form>
                    </td></tr> 
                    </table>
                </td>               
            </tr>
        <?php } ?>
    </table>