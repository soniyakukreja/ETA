<div class="modal fade" id="confirm_modal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
    
      <div class="modal-header" style="padding: 7px;display: inline;" id="success_head">
      <h4 class="modal-title" style="text-align: center;color:red;"> Confirmation</h4>
      </div>
      
      <!-- Modal body -->
      <div class="modal-body" style="padding: 0;">
       <div style="padding: 20px;text-align: center;font-size: 20px;margin-top: 5px;margin-bottom: -8px;">
       Are You Sure! Do you really want to delete this entry?
       </div>
      </div>
      
      <!-- Modal footer -->
      <div class="modal-footer" style="padding: 6px;">
        <?php echo form_open('',array('id'=>'deleteEntryForm')); ?>
        <button type="submit" class="btnStyle pull-left" id="yes_removeall">Yes</button>
        <?php echo form_close(); ?>
        <button type="button" class="btn btn-danger" data-dismiss="modal" id="cancel_remove">No</button>
      </div>
      
    </div>
  </div>
</div> 