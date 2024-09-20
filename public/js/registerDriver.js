$(document).ready(function () {
    $('#driverForm').on('submit', function (e) {
        e.preventDefault(); // Mencegah submit default form
        let formData = new FormData(this);
        
        $.ajax({
            type: 'POST',
            url: '/mitra/daftar-driver',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
            withCredentials: false,
            success: function (response) {
                //show success message
                Swal.fire({
                    icon: 'success',
                    title: `${response.success}`,
                    showConfirmButton: false,
                    timer: 3000
                });

                // refresh 3000ms
                setTimeout(function () {
                    location.reload();
                }, 3000);
            },
            error: function (response) {
                //show error message
                if (response.responseJSON) {
                    Swal.fire({
                        icon: 'error',
                        title: `${response.responseJSON.message}`,
                        showConfirmButton: false,
                        timer: 3000
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi kesalahan',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            }
        });
    });
});
