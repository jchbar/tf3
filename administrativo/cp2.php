<script type="text/javascript">
$(document).ready(function() {
    var frm = $('#resetform');
    frm.submit(function(e){
        e.preventDefault();

        var formData = frm.serialize();
        formData += '&' + $('#submit_btn').attr('name') + '=' + $('#submit_btn').attr('value');
		alert(formData);
        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: formData,
            success: function(data){
                $('#message').html(data).delay(3000).fadeOut(3000);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#message').html(textStatus).delay(2000).fadeOut(2000);
            }

        });
    });
});
</script>


<form name="resetform" action="changepass.php" id="resetform" class="passform" method="post" role="form">
    <h3>Change Your Password</h3>
    <br />
    <input type="hidden" name="username" value="jchbar@cantv.net" ></input>
    <label>Enter Old Password</label>
    <input type="password" class="form-control" name="old_password" id="old_password">
    <label>Enter New Password</label>
    <input type="password" class="form-control" name="new_password" id="new_password">
    <label>Confirm New Password</label>
    <input type="password" class="form-control"  name="con_newpassword"  id="con_newpassword" />
    <br>
    <input type="submit" class="btn btn-warning" name="password_change" id="submit_btn" value="Change Password" />
</form>

<!--display success/error message-->
<div id="message"></div>
