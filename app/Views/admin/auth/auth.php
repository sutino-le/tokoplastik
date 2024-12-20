<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>InoArt Developer</title>

    <link href="<?= base_url() ?>upload/logovertikal.png" rel="icon">
    <link href="<?= base_url() ?>upload/logovertikal.png" rel="apple-touch-icon">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/dist/css/adminlte.min.css">


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">

            <img src="<?= base_url() ?>upload/logovertikal.png" width="100px" height="100px"><br>
            <a href="<?= base_url() ?>"><b>InoArt Developer</b></a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Silahkan Login</p>

                <div class="errorDatabase"></div>

                <form action="<?= base_url() ?>cekUser" method="post" class="formlogin">
                    <div class="input-group mb-3">
                        <input type="text" name="userid" id="userid" class="form-control" placeholder="User ID">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        <div class="invalid-feedback errorUserID"></div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="userpassword" id="userpassword" class="form-control"
                            placeholder="Kata Sandi">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <div class="invalid-feedback errorPassword"></div>
                    </div>
                    <div class="row">
                        <!-- /.col -->
                        <div class="col">
                            <button type="submit" class="btn btn-primary btn-block">LogIn</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <!-- /.social-auth-links -->

                <!-- <p class="mb-1 mt-5">
                    <a href="forgot-password.html">Saya lupa kata sandi</a>
                </p>
                <p class="mb-0">
                    <a href="register.html" class="text-center">Registrasi pelanggan baru</a>
                </p> -->
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url() ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url() ?>assets/dist/js/adminlte.min.js"></script>


    <script>
        $(document).ready(function() {
            // proses form login
            $('.formlogin').submit(function(e) {
                e.preventDefault();

                $.ajax({
                    type: "post",
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(response) {
                        if (response.error) {
                            let err = response.error;

                            if (err.errUserID) {
                                $('#userid').addClass('is-invalid');
                                $('.errorUserID').html(err.errUserID);
                            } else {
                                $('#userid').removeClass('is-invalid');
                                $('#userid').addClass('is-valid');
                            }

                            if (err.errPassword) {
                                $('#userpassword').addClass('is-invalid');
                                $('.errorPassword').html(err.errPassword);
                            } else {
                                $('#userpassword').removeClass('is-invalid');
                                $('#userpassword').addClass('is-valid');
                            }

                            if (err.errDatabase) {
                                $('.errorDatabase').html(err.errDatabase);
                                $('.errorDatabase').addClass('alert alert-danger');
                                $('#userid').addClass('is-invalid');
                                $('#userpassword').addClass('is-invalid');
                            } else {
                                $('.errorDatabase').html('');
                                $('.errorDatabase').removeClass('alert alert-danger');
                            }
                        }

                        if (response.sukses) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.sukses
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.href = "<?= base_url() ?>main";
                                }
                            });
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + '\n' + thrownError);
                    }
                });

            });

        });
    </script>




</body>

</html>