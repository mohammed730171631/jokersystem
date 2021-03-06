<style type="text/css">
    @media print
    {
        .no-print, .no-print *
        {
            display: none !important;
        }
    }
</style>
 
<div class="content-wrapper" style="min-height: 946px;">  
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> <?php echo $this->lang->line('users'); ?></h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <?php
            if ($this->rbac->hasPrivilege('users_setting', 'can_add')) {
                ?>        
                <div class="col-md-4">          
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo $this->lang->line('add_user'); ?></h3>
                        </div>
                        <form id="form" action="<?php echo base_url(); ?>user"  id="employeeform" name="employeeform" method="post" accept-charset="utf-8">
                            <div class="box-body">
                                <?php if ($this->session->flashdata('msg')) { ?>
                                    <?php echo $this->session->flashdata('msg') ?>
                                <?php } ?>     
                                <?php echo $this->customlib->getCSRF(); ?>
                              

                                
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('first_name'); ?></label><small class="req"> *</small>
                                    <input required autofocus="" id="first_name" name="first_name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('first_name'); ?>" />
                                    <span class="text-danger"><?php echo form_error('first_name'); ?></span>
                                </div>
                                     <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('father_name'); ?></label><small class="req"> *</small>
                                    <input required autofocus="" id="father_name" name="father_name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('father_name'); ?>" />
                                    <span class="text-danger"><?php echo form_error('father_name'); ?></span>
                                </div>
                                     <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('last_name'); ?></label>
                                    <input autofocus="" id="last_name" name="last_name"  type="text" class="form-control"  value="<?php echo set_value('last_name'); ?>" />
                                    <span class="text-danger"><?php echo form_error('last_name'); ?></span>
                                </div>
                                     <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('email'); ?></label><small class="req"> *</small>
                                    <input required  name="email"  type="email" class="form-control"  value="<?php echo set_value('email'); ?>" />
                                    <span class="text-danger"><?php echo form_error('email'); ?></span>
                                </div>
                                     <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('password'); ?></label><small class="req"> *</small>
                                    <input required autofocus="" id="password" name="password" placeholder="" type="password" class="form-control"  value="<?php echo set_value('password'); ?>" />
                                    <span class="text-danger"><?php echo form_error('password'); ?></span>
                                </div>

                                    <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('confirm_password'); ?></label><small class="req"> *</small>
                                    <input required autofocus="" id="confirm_password" name="confirm_password" placeholder="" type="password" class="form-control"  value="<?php echo set_value('confirm_password'); ?>" />
                                    <span class="text-danger"><?php echo form_error('confirm_password'); ?></span>
                                </div>

                                     <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('is_active'); ?></label><small class="req"> *</small>
                                    <select required autofocus="" id="city_name" name="is_active" placeholder="" type="text" class="form-control" >


                                <option value="1"><?php echo $this->lang->line('active'); ?>   </option>
                                <option value="1"><?php echo $this->lang->line('not_active'); ?>   </option>

                                        



                                    </select>
                                    <span class="text-danger"><?php echo form_error('is_active'); ?></span>
                                </div>
                               
                             
                              
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php 
            }
             ?>
            <div class="col-md-<?php
            if ($this->rbac->hasPrivilege('users_setting', 'can_add')) {
                echo "8";
            } else {
                echo "12";
            }
            ?>">            
                <div class="box box-primary" id="sublist">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('users_list'); ?></h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive mailbox-messages">
                            <div class="download_label"><?php echo $this->lang->line('users'); ?></div>
                            <table class="table table-striped table-bordered table-hover example1">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('user_name'); ?></th>
                                        <th><?php echo $this->lang->line('email'); ?></th>
                                        <th><?php echo $this->lang->line('is_active'); ?></th>
                                      
                                         <?php
                                    if ($this->rbac->hasPrivilege('users_setting', 'can_edit')||
                                        $this->rbac->hasPrivilege('users_setting', 'can_delete')) {
                                        ?>
                                        <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                                        <?php 
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>

                               
                                    <?php
                                    $count = 1;
                                    foreach ($user_list as $subject) {
                                        ?>
                                        <tr>
                                            <td class="mailbox-name"> <?php echo $subject['first_name']." ".$subject['father_name']." ".$subject['last_name'] ?></td> 
                                             <td class="mailbox-name"> <?php echo $subject['email']?></td>  
                    


                    <td class="mailbox-name">
                            
  <?php
                                                if ($this->rbac->hasPrivilege('users_setting', 'can_edit') && $subject['role'] ==0  ) { ?>
                            <select autofocus="" data-id="<?php echo $subject['id'];?>" id="is_active" name="active" placeholder="" type="text" class=" is_active form-control" >
                                <option
                                <?php if($subject['is_active']=='1'  ){
                                                echo "selected";}?> value="1"><?php echo $this->lang->line('active'); ?>   </option>
                                <option 
                                 <?php if($subject['is_active']=='0'){
                                                echo "selected " ;} ?> value="0"><?php echo $this->lang->line('not_active'); ?>   </option>

                                    
                                    </select>
 <?php }else{?>
                                              <?php if($subject['is_active']=='1'){
                                                echo $this->lang->line('active');
                                                    }else{
                                                    echo $this->lang->line('not_active');

                                                }?>
 <?php } ?> 
                                            </td>
                                          <td class="mailbox-date pull-right no-print">
                                                <?php
                                                if ($this->rbac->hasPrivilege('users_setting', 'can_edit')) {
                                                    ?>
                                                    <a href="<?php echo base_url(); ?>user/edit/<?php echo $subject['id'] ?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>

                                                      </a>
                                                      <a href="<?php echo base_url(); ?>user/getUserPermission/<?php echo $subject['id'] ?>" class="btn btn-default btn-xs" data-toggle="tooltip" title="" data-original-title="<?php echo $this->lang->line('permission'); ?>">
                                                            <i class="fa fa-tag"></i>
                                                     </a>
                                                    <?php
                                                }
                                                if ($this->rbac->hasPrivilege('users_setting', 'can_delete')) {
                                                    ?>
                                                    <a href="<?php echo base_url(); ?>user/deleteUser/<?php echo $subject['id'] ?>"class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" onclick="return confirm('<?php echo $this->lang->line('delete_confirm') ?>');">
                                                        <i class="fa fa-remove"></i>
                                                  
                                                <?php } ?>


                           
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    $count++;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> 

        </div> 
    </section>
</div>

<script type="text/javascript">
    $(document).on('change','.is_active',function (e){
        var state = $(this).val();
        var user = $(this).data('id');
    

        var base_url ='<?php echo base_url() ?>';
        $.ajax({

            type : "post",
            url : base_url+"user/make_active",
            data :{'user' : user , 'state':state},
            dataType:"json",
            success:function(res){
                if(res.status == "fail"){

                    errorMsg(res.message);
                   
                }else{

                    successMsg(res.message);
                    // window.location.reload(true);

                }


            }


        });

    });
</script>