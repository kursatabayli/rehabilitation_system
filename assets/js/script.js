$(document).ready(function () {
  // Tüm genel tablo'ları başlat
  $(".dataTable").DataTable({
    language: {
      url: "//cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json",
    },
  });

  // Tüm tablo sarmalayıcılarını gizle
  $(".table-container:last").hide();

  // Tıklanabilir başlıklar üzerinden tablo aç/kapa işlemi
  $(".clickable-header").click(function () {
    $(this).next(".table-container").fadeToggle();
    $(this).find("i").toggleClass("rotate-up rotate-down");
  });

  // Sweet Alert DELETE
  function setupDeleteButtons() {
    $(".btn-delete").click(function (e) {
      e.preventDefault();
      var url = $(this).data("url"); // data-url kullanarak URL al
      var row = $(this).closest("tr, li");

      Swal.fire({
        title: `Bu veriyi silmek istediğinize emin misiniz?`,
        html: "Sildiğiniz takdirde veriler tamamen kaybolacak!<br><br>Bu işlemi geri alamazsınız!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sil",
        cancelButtonText: "İptal",
        reverseButtons: true,
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: url,
            method: "DELETE",
            success: function (response) {
              Swal.fire(
                "Silindi!",
                `Veri kaydı başarıyla silindi.`,
                "success"
              ).then(() => {
                // Gelen yanıt içinde redirectUrl olup olmadığını kontrol et
                if (response.redirectUrl) {
                  // redirectUrl varsa sayfayı yönlendir
                  window.location.href = response.redirectUrl;
                } else {
                  // redirectUrl yoksa satırı DOM'dan kaldır
                  row.remove();
                }
              });
            },
            error: function () {
              Swal.fire(
                "Hata!",
                "Silme işlemi sırasında bir hata oluştu.",
                "error"
              );
            },
          });
        }
      });
    });
  }

  // Silme butonları için ayarları yap
  setupDeleteButtons();

  // Sweet Alert CREATE/UPDATE
  $("form").on("submit", function (e) {
    e.preventDefault();
    var form = $(this);
    var actionType = form.data("action-type");

    // Form verilerini al
    var formData = form.serialize();

    $.ajax({
      url: form.attr("action"),
      type: form.attr("method"),
      data: formData,
      success: function (response) {
        Swal.close(); // Yükleme göstergesini kapat

        if (response.success || response.success == null) {
          var title = "İşlem Tamamlandı!";
          var text =
            actionType == "create"
              ? "Yeni veri eklendi"
              : "Veriler güncellendi";

          Swal.fire({
            title: title,
            text: text,
            icon: "success",
            confirmButtonText: "Tamam",
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
            title: "Başarısız!",
            text:
              response.message ||
              "İşlem gerçekleştirilemedi. Lütfen tekrar deneyin.",
            icon: "error",
            confirmButtonText: "Tamam",
          });
        }
      },
      error: function (response) {
        Swal.fire({
          title: "Hata!",
          text:
            response.responseJSON.message ||
            "İşlem sırasında bir hata oluştu. Lütfen tekrar deneyin.",
          icon: "error",
          confirmButtonText: "Tamam",
        });
      },
    });
  });

  $("#customTable").DataTable({
    paging: true,
    info: false,
    searching: true,
    ordering: false,
    lengthChange: true,
    pageLength: 10,
    lengthMenu: [10, 20, 50, 100],
    language: {
      lengthMenu: "Sayfa başına _MENU_ kayıt gösteriliyor",
      search: "", // "Search" ifadesi tamamen kaldırıldı
      paginate: {
        previous: "&#129168;", // Sol ok
        next: "&#129170;", // Sağ ok
      },
      zeroRecords:
        '<div class="alert alert-warning no-results mt-3">Arama kriterine uygun sonuç bulunamadı.</div>',
      emptyTable:
        '<div class="alert alert-danger mt-3" role="alert"><p><i>Daha önce eklenen herhangi bir veri bulunamadı. <strong>Ekle</strong> butonunu kullanarak yeni bir veri girişi yapabilirsiniz</i></p></div>',
    },
    initComplete: function () {
      // Arama input'una placeholder ekle
      $("div.dataTables_filter input").attr("placeholder", "Ara...");
    },
  });

  // Select2'yi dropdown'lar için etkinleştirme
  $("#staffId").select2({
    placeholder: "Personel arayın",
    allowClear: true,
  });

  $("#studentId").select2({
    placeholder: "Öğrenci arayın",
    allowClear: true,
  });

  const today = new Date();
  const dayOfWeek = today.getDay() === 0 ? 7 : today.getDay();
  // Gün seçildiğinde seans saatlerini ve seansları getir ve URL’yi güncelle
  const dayLinks = document.querySelectorAll('a[href^="?dayId"]');
  dayLinks.forEach((link) => {
    link.addEventListener("click", function (e) {
      e.preventDefault();
      const dayId = new URL(this.href).searchParams.get("dayId");

      // Seçili gün vurgusu
      dayLinks.forEach((dayOfWeek) =>
        dayOfWeek.classList.remove("selected-day")
      );
      this.classList.add("selected-day");

      // URL'yi güncelle (sayfa yeniden yüklenmeden)
      history.pushState(null, "", `?dayId=${dayId}`);

      // Seansları güncelle
      fetchSessions(dayId);
    });
  });

  // Seans saatlerini ve seansları almak için AJAX fonksiyonu
  function fetchSessions(dayId) {
    if (document.getElementById("adminSessionsTable")) {
      fetch(`../../Controllers/SessionController.php?dayId=${dayId}`)
        .then((response) => response.json())
        .then((data) => {
          const tableHeadElement = document.querySelector(
            "#adminSessionsTable thead"
          );
          const tableBodyElement = document.querySelector(
            "#adminSessionsTable tbody"
          );
          const adminSessionsTable =
            document.getElementById("adminSessionsTable");
          const noSessionsMessage =
            document.getElementById("noSessionsMessage");

          tableHeadElement.innerHTML = "";
          tableBodyElement.innerHTML = "";
          adminSessionsTable.style.display = "none";
          noSessionsMessage.style.display = "none";

          if (data.length === 0) {
            noSessionsMessage.style.display = "block";
          } else {
            adminSessionsTable.style.display = "table";
            let tableHead = "<tr><th>Personeller</th>";
            let tableBody = "";
            const staffSessions = {};

            data.forEach((item) => {
              const startTime = item.time.sessionStartTime.substring(0, 5);
              const endTime = item.time.sessionEndTime.substring(0, 5);
              tableHead += `<th>${startTime} - ${endTime}</th>`;

              item.sessions.forEach((session) => {
                const staffName = `${session.staffName} ${session.staffSurname}`;
                if (!staffSessions[staffName]) {
                  staffSessions[staffName] = {};
                }
                const sessionContent = session.studentName
                  ? `<a href="Update.php?sessionId=${session.sessionId}">${
                      session.studentName
                    } ${session.studentSurname}<br>${
                      session.sessionType
                        ? " (" + session.sessionType + ")"
                        : ""
                    }</a>`
                  : "-";
                staffSessions[staffName][`${startTime}-${endTime}`] =
                  sessionContent;
              });
            });

            tableHead += "</tr>";

            Object.keys(staffSessions).forEach((staffName) => {
              tableBody += `<tr><td>${staffName}</td>`;
              data.forEach((item) => {
                const startTime = item.time.sessionStartTime.substring(0, 5);
                const endTime = item.time.sessionEndTime.substring(0, 5);
                const session =
                  staffSessions[staffName][`${startTime}-${endTime}`] || "-";
                tableBody += `<td>${session}</td>`;
              });
              tableBody += "</tr>";
            });

            tableHeadElement.innerHTML = tableHead;
            tableBodyElement.innerHTML = tableBody;
          }
        })
        .catch((error) => {
          console.error("Seanslar getirilemedi:", error);
        });
    } else {
      fetch(`../../Controllers/SessionController.php?dayId=${dayId}`)
        .then((response) => response.json())
        .then((data) => {
          const tableHeadElement = document.querySelector(
            "#staffSessionsTable thead"
          );
          const tableBodyElement = document.querySelector(
            "#staffSessionsTable tbody"
          );
          const staffSessionsTable =
            document.getElementById("staffSessionsTable");
          const noSessionsMessage =
            document.getElementById("noSessionsMessage");

          // Başlangıç durumu
          tableHeadElement.innerHTML = "";
          tableBodyElement.innerHTML = "";
          staffSessionsTable.style.display = "none";
          noSessionsMessage.style.display = "none";

          if (data.length === 0) {
            noSessionsMessage.style.display = "block";
            return;
          }

          staffSessionsTable.style.display = "table";
          const staffSessions = {};
          let tableHead = "<tr>";
          let tableBody = "";

          data.forEach((item) => {
            const startTime = item.time.sessionStartTime.substring(0, 5);
            const endTime = item.time.sessionEndTime.substring(0, 5);

            // Tablo başlıkları
            tableHead += `<th>${startTime} - ${endTime}</th>`;

            item.sessions.forEach((session) => {
              const staffId = `${session.staffId}`;
              if (!staffSessions[staffId]) {
                staffSessions[staffId] = {};
              }

              const sessionContent = session.studentName
                ? `<a href="Detail.php?studentId=${session.studentId}">${
                    session.studentName
                  } ${session.studentSurname}<br>${
                    session.sessionType ? " (" + session.sessionType + ")" : ""
                  }</a>`
                : "-";
              staffSessions[staffId][`${startTime}-${endTime}`] =
                sessionContent;
            });
          });

          tableHead += "</tr>";

          const loggedInStaffId =
            document.getElementById("loggedInStaffId").value;

          // Kullanıcıya ait seansları ekleme
          Object.keys(staffSessions).forEach((staffId) => {
            if (staffId == loggedInStaffId) {
              tableBody += "<tr>";
              data.forEach((item) => {
                const startTime = item.time.sessionStartTime.substring(0, 5);
                const endTime = item.time.sessionEndTime.substring(0, 5);
                const session =
                  staffSessions[staffId][`${startTime}-${endTime}`] || "-";
                tableBody += `<td>${session}</td>`;
              });
              tableBody += "</tr>";
            }
          });

          // Güncellenmiş içeriği tabloya ekleme
          if (tableBody.trim().length > 0) {
            // tableBody boş değilse
            tableHeadElement.innerHTML = tableHead;
            tableBodyElement.innerHTML = tableBody;
          } else {
            noSessionsMessage.style.display = "block";
          }
        })
        .catch((error) => {
          console.error("Seanslar getirilemedi:", error);
        });
    }
  }

  // URL'deki dayId parametresine göre varsayılan gün belirleme
  const urlParams = new URLSearchParams(window.location.search);
  const dayId = urlParams.get("dayId") || dayOfWeek; // Varsayılan: Pazartesi
  fetchSessions(dayId);

  // Seçili gün vurgusunu güncelle
  dayLinks.forEach((link) => {
    const linkDayId = new URL(link.href).searchParams.get("dayId");
    if (linkDayId === dayId) {
      link.classList.add("selected-day");
    }
  });

  $("#studentId").change(function () {
    var studentId = $(this).val();

    if (studentId) {
      $.ajax({
        url: "../../Controllers/StudentSessionTypeController.php",
        method: "GET",
        data: { id: studentId },
        success: function (response) {
          var sessionTypeSelect = $("#sessionTypeId");
          sessionTypeSelect.empty(); // Önceki seçenekleri temizle
          sessionTypeSelect.append(
            '<option value="">Seans Türü Seçin</option>'
          ); // Varsayılan boş seçenek

          // Gelen seans türlerini dropdown'a ekle
          response.forEach(function (item) {
            sessionTypeSelect.append(
              '<option value="' +
                item.sessionTypeId +
                '">' +
                item.sessionType +
                "</option>"
            );
          });
        },
        error: function () {
          alert("Seans türleri alınamadı. Lütfen tekrar deneyin.");
        },
      });
    } else {
      $("#sessionTypeId")
        .empty()
        .append('<option value="">Seans Türü Seçin</option>'); // Eğer öğrenci seçilmezse boşalt
    }
  });
});

function togglePassword(id) {
  // Şifre alanını seç
  const passwordField = document.getElementById(id);
  const toggleIcon = passwordField.nextElementSibling; // Göz simgesi

  // Şifreyi göster/gizle
  if (passwordField.type === "password") {
    passwordField.type = "text";
    toggleIcon.classList.remove("fa-eye");
    toggleIcon.classList.add("fa-eye-slash");
  } else {
    passwordField.type = "password";
    toggleIcon.classList.remove("fa-eye-slash");
    toggleIcon.classList.add("fa-eye");
  }
}

// Başlık tıklanarak içeriğin açılıp kapanmasını sağlayan script
document.querySelector(".toggle-title").addEventListener("click", function () {
  const content = this.nextElementSibling; // Başlığın hemen altındaki .toggle-content
  content.classList.toggle("active");
});
