<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="col-md-4 mx-auto mt-5">
        <form id="btn-submit">
            <div class="card">
                <div class="card-header">
                    <h4>Create New Password</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="">Password</label>
                        <input type="text" class="form-control" name='password' id='password'>
                    </div>
                    <div class="form-group">
                        <label for="">Confirm Password</label>
                        <input type="text" class="form-control" name='confirm_password' id='confirm_password'>
                    </div>
                </div>
                <div class="card-footer">
                    <button type='submit' class="btn btn-info float-right">Submit</button>
                </div>
            </div>
        </form>
        <div id="message"> </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</body>
<script>
    $("#btn-submit").submit(function(e) {
        e.preventDefault();
        $("#btn-submit").attr('disabled', true)
        $("#btn-submit").attr('value', 'Please wait....')

        var password = $("input[name=password]").val();
        var confirm_password = $("input[name=confirm_password]").val();
        var url = "{{ url('/api/password-reset-confirm/' . $token) }}";

        $.ajax({
            url: url,
            method: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                password: password,
                password_confirmation: confirm_password
            },
            success: function(response) {
                if (response.status == 404) {
                    $('#message').html(response.message);
                    $('#message').addClass("alert alert-danger text-center mt-3");
                } else if (response.status == 201) {
                    $('#message').html(response.message);
                    $('#message').addClass("alert alert-success text-center mt-3");
                    $("#btn-submit").attr('disabled', false)
                    $("#btn-submit").attr('value', 'submit')
                }

            },
            error: function(error) {
                if (error.status == 422) {
                    $('#message').text(error.responseJSON.errors.password);
                    $('#message').addClass("alert alert-danger text-center mt-3");
                    console.log(error.message);
                }
            }
        });
    });
</script>

</html>
