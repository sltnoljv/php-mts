<?php 
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT sl.* FROM `surgery_list` sl where sl.id = '{$_GET['id']}'");
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
        <h2 class="fw-bolder text-center"><b>Surgery Details</b></h2>
        <hr>
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-sm-12 col-xs-12">
                <dl class="row">
                    <dt class="col-4 px-2">Surgery Date</dt>
                    <dd class="col-8 px-2"><?= isset($date) ? date("F d, Y", strtotime($date)) : "" ?></dd>
                    <hr class="dark">
                    <dt class="col-4 px-2">Surgery</dt>
                    <dd class="col-8 px-2"><?= isset($surgery)? $surgery : "" ?></dd>
                    <dt class="col-4 px-2">Description</dt>
                    <dd class="col-8 px-2"><?= $description ?? "" ?></dd>
                    <hr class="dark">
                    <div class="d-flex w-100 justify-content-end">
                        <div class="col-auto me-2">
                            <a href=".?page=surgery/manage_surgery&id=<?= isset($id) ? $id : '' ?>" class="btn btn-primary bg-gradient btn-sm rounded-0 d-flex align-items-center"><span class="material-icons">edit</span> Edit</a>
                        </div>
                        <div class="col-auto">
                            <a href="javascript:void(0)" class="btn btn-danger bg-gradient btn-sm rounded-0 d-flex align-items-center" id="delete_data"><span class="material-icons">delete</span> Delete</a>
                        </div>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</section>
<script>
    $(function(){
        $('#delete_data').click(function(){
            _conf("Are you sure to delete this from list?","delete_surgery",['<?= isset($id) ? $id : '' ?>'])
        })
    })
    function delete_surgery($id){
        start_loader();
        var _this = $(this)
        $('.err-msg').remove();
        var el = $('<div>')
        el.addClass("alert alert-danger err-msg")
        el.hide()
        $.ajax({
            url: '../classes/Master.php?f=delete_surgery',
            method: 'POST',
            data: {
                id: $id
            },
            dataType: 'json',
            error: err => {
                console.log(err)
                el.text('An error occurred.')
                el.show('slow')
                end_loader()
            },
            success: function(resp) {
                if (resp.status == 'success') {
                    location.replace('./?page=surgery')
                } else if (!!resp.msg) {
                    el.text('An error occurred.')
                    el.show('slow')
                } else {
                    el.text('An error occurred.')
                    el.show('slow')
                }
                end_loader()
            }
        })
    }
</script>