$(document).ready(function () {
    // Tüm genel tablo'ları başlat
    $('.dataTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"
        }
    });

    // Tüm tablo sarmalayıcılarını gizle
    $('.table-container:last').hide();

    // Tıklanabilir başlıklar üzerinden tablo aç/kapa işlemi
    $('.clickable-header').click(function () {
        $(this).next('.table-container').fadeToggle();
        $(this).find('i').toggleClass('rotate-up rotate-down');
    });

    // Sweet Alert DELETE
    function setupDeleteButtons() {
        $('.btn-delete').click(function (e) {
            e.preventDefault();
            var url = $(this).data('url'); // data-url kullanarak URL al
            var row = $(this).closest('tr, li');

            Swal.fire({
                title: `Bu veriyi silmek istediğinize emin misiniz?`,
                html: 'Sildiğiniz takdirde veriler tamamen kaybolacak!<br><br>Bu işlemi geri alamazsınız!',
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sil",
                cancelButtonText: "İptal",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        method: 'DELETE',
                        success: function () {
                            Swal.fire('Silindi!', `Veri kaydı başarıyla silindi.`, 'success')
                                .then(() => {
                                    // Satırı DOM'dan kaldır
                                    row.remove();
                                });
                        },
                        error: function () {
                            Swal.fire('Hata!', 'Silme işlemi sırasında bir hata oluştu.', 'error');
                        }
                    });
                }
            });
        });
    }

    // Silme butonları için ayarları yap
    setupDeleteButtons();


    // Sweet Alert CREATE/UPDATE

    $('form').on('submit', function (e) {
        e.preventDefault();
        var form = $(this);
        var actionType = form.data('action-type');

        // Form verilerini al
        var formData = form.serialize();

        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: formData,
            success: function (response) {
                Swal.close(); // Yükleme göstergesini kapat

                if (response.success || response.success == null) {
                    var title = 'İşlem Tamamlandı!';
                    var text = (actionType == 'create') ? 'Yeni veri eklendi' : 'Veriler güncellendi';

                    Swal.fire({
                        title: title,
                        text: text,
                        icon: 'success',
                        confirmButtonText: 'Tamam',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (response.redirectUrl != null) {
                                window.location.href = response.redirectUrl;
                            } else {
                                location.reload();
                            }
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Başarısız!',
                        text: response.message || 'İşlem gerçekleştirilemedi. Lütfen tekrar deneyin.',
                        icon: 'error',
                        confirmButtonText: 'Tamam'
                    });
                }
            },
            error: function (response) {
                Swal.fire({
                    title: 'Hata!',
                    text: response.responseJSON.message || 'İşlem sırasında bir hata oluştu. Lütfen tekrar deneyin.',
                    icon: 'error',
                    confirmButtonText: 'Tamam'
                });
            }

        });
    });

    $('#customTable').DataTable({
        "paging": true,
        "info": false,
        "searching": true,
        "ordering": false,
        "lengthChange": true,
        "pageLength": 10,
        "lengthMenu": [10, 20, 50, 100],
        "language": {
            "lengthMenu": "Sayfa başına _MENU_ kayıt gösteriliyor",
            "search": "", // "Search" ifadesi tamamen kaldırıldı
            "paginate": {
                "previous": "&#129168;", // Sol ok
                "next": "&#129170;" // Sağ ok
            },
            "zeroRecords": '<div class="alert alert-warning no-results mt-3">Arama kriterine uygun sonuç bulunamadı.</div>',
            "emptyTable": '<div class="alert alert-danger at-3" role="alert"><p><i>Daha önce eklenen herhangi bir veri bulunamadı. <strong>Ekle</strong> butonunu kullanarak yeni bir veri girişi yapabilirsiniz</i></p></div>'

        },
        "initComplete": function () {
            // Arama input'una placeholder ekle
            $('div.dataTables_filter input').attr('placeholder', 'Ara...');
        }
    });


    // Resme tıklanınca modal aç
    $('#viewImage').click(function (e) {
        e.preventDefault(); // Link tıklamasını engelle

        // SweetAlert ile resmi ve dinamik başlığı göster
        var name = $(this).data('name');
        var surname = $(this).data('surname');

        Swal.fire({
            title: name + ' ' + surname,
            html: '<img src="' + $(this).find('img').attr('src') + '"class="img-fluid">',
            showCloseButton: true,
            showConfirmButton: false,
            width: 'auto', // Modala göre otomatik genişlik
            background: '#fff',
            padding: '1rem'
        });
    });

});
