<?php 
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM `surgery_list` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0 ){
        foreach($qry->fetch_array() as $k => $v){
            if(!is_numeric($k))
            $$k = $v;
        }
    }
}
?>
<section class="py-5">
    <div class="container">
        <h2 class="fw-bolder text-center"><b><?= isset($id) ? "Edit Surgery" : "Add New Surgery" ?></b></h2>
        <hr>
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-sm-12 col-xs-12">
                <form action="" id="surgery-form" class="py-3">
                    <input type="hidden" name="id" value="<?= isset($id) ? $id : '' ?>">
                    <input type="hidden" name="user_id" value="<?=  $_settings->userdata('id') ?>">
                    <div class="input-group mb-4 input-group-dynamic is-filled">
                        <label for="date" class="form-label">Date<span class="text-primary">*</span></label>
                        <input type="date" id="date" name="date" value="<?= isset($date) ? $date : "" ?>" class="form-control" required>
                    </div>
                    <div class="input-group mb-4 input-group-dynamic is-filled">
                        <label for="surgery" class="form-label">Surgery <span class="text-primary">*</span></label>
                        <textarea rows="1" id="surgery" name="surgery" class="form-control border rounded-0 px-2 py-1" required><?= isset($surgery) ? $surgery : "" ?></textarea>
                    </div>
                    <div class="input-group mb-4 input-group-dynamic is-filled">
                        <label for="description" class="form-label">Description <span class="text-primary">*</span></label>
                        <textarea rows="4" id="description" name="description" class="form-control border rounded-0 px-2 py-1" required><?= isset($description) ? $description : "" ?></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn bg-primary bg-gradient btn-sm text-light w-25"><span class="material-icons">save</span> Save</button>
                            <a href="./?page=surgery" class="btn bg-deafult border bg-gradient btn-sm w-25"><span class="material-icons">keyboard_arrow_left</span> Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<script>
    var fuser_ajax;
    $(function(){
        $('#surgery-form').submit(function(e){
            e.preventDefault()
            $('.pop-alert').remove()
            var _this = $(this)
            var el = $('<div>')
            el.addClass("pop-alert alert alert-danger text-light")
            el.hide()
            start_loader()
            $.ajax({
                url:'../classes/Master.php?f=save_surgery',
                method:'POST',
                data:$(this).serialize(),
                dataType:'json',
                error:err=>{
                    console.error(err)
                    el.text("An error occured while saving data")
                    _this.prepend(el)
                    el.show('slow')
                    $('html, body').scrollTop(_this.offset().top - '150')
                    end_loader()
                },
                success:function(resp){
                    if(resp.status == 'success'){
                        location.href= './?page=surgery/view_details&id='+resp.sid;
                    }else if(!!resp.msg){
                        el.text(resp.msg)
                        _this.prepend(el)
                        el.show('slow')
                        $('html, body').scrollTop(_this.offset().top - '150')
                    }else{
                        el.text("An error occured while saving data")
                        _this.prepend(el)
                        el.show('slow')
                        $('html, body').scrollTop(_this.offset().top - '150')
                    }
                    end_loader()
                    console

                }
            })
        })

    })
</script>