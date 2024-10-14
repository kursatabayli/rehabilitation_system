$(document).ready(function () {
    // Tüm userTable'ları başlat
    $('.userTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"
        }
    });

    // Tüm tablo sarmalayıcılarını gizle
    $('.userTable-container').hide();

    // Tıklanabilir başlıklar üzerinden tablo aç/kapa işlemi
    $('.clickable').click(function () {
        $(this).next('.userTable-container').fadeToggle();
        $(this).find('i').toggleClass('rotate-up rotate-down');
    });

    // Arama alanında yazıldıkça tabloyu filtrele
    $("#search-input").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        var visibleRows = 0;

        $(".table-responsive table tbody tr").filter(function () {
            var isVisible = $(this).find(".find").text().toLowerCase().indexOf(value) > -1;
            $(this).toggle(isVisible);

            if (isVisible) {
                visibleRows++;
            }
        });

        // Sonuç bulunamazsa uyarı göster, aksi takdirde gizle
        if (visibleRows === 0) {
            if ($(".no-results").length === 0) {
                $(".table-responsive").append('<div class="alert alert-warning no-results mt-3">Arama kriterine uygun sonuç bulunamadı.</div>');
            }
        } else {
            $(".no-results").remove();
        }
    });

    // Sweet Alert DELETE
    function setupDeleteButtons() {
        $('.btn-delete').click(function (e) {
            e.preventDefault();
            var url = $(this).data('url'); // data-url kullanarak URL al
            var row = $(this).closest('tr'); // Silinecek satırı tut

            Swal.fire({
                title: `Bu veriyi silmek istediğinize emin misiniz?`,
                text: "Sildiğiniz takdirde veriler tamamen kaybolacak!",
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
                            window.location.href = response.redirectUrl;
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

});
