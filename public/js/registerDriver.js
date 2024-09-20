$(document).ready(function () {
    $('#driverForm').on('submit', function (e) {
        e.preventDefault(); // Mencegah submit default form
        let formData = new FormData(this);
        let header = {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')};
        let $submitButton = $('#submitBtnDriver'); // Akses tombol submit

        // Ubah tombol jadi loading dan disable
        $submitButton.prop('disabled', true).html('<span class="loading-spinner"></span> Loading...');

        $.ajax({
            type: 'POST',
            url: '/mitra/daftar-driver',
            headers: header,
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
            withCredentials: false,
            success: function (response) {
                // Kembalikan tombol ke keadaan semula
                $submitButton.prop('disabled', false).html('Submit');

                // Tampilkan pesan sukses
                Swal.fire({
                    icon: 'success',
                    title: `${response.success}`,
                    showConfirmButton: false,
                    timer: 3000
                });

                // Refresh halaman setelah 3000ms
                setTimeout(function () {
                    location.reload();
                }, 3000);
            },
            error: function (response) {
                // Kembalikan tombol ke keadaan semula
                $submitButton.prop('disabled', false).html('Submit');

                // Tampilkan pesan error
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
