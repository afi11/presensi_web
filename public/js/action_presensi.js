const loading = document.querySelector(".loading");

loadYears(0, 10);
function loadYears(min, max) {
    var years = document.querySelector(".years");
    var calendar = new Date();
    var year = calendar.getFullYear();
    for (var i = 0; i < max - min; i++) {
        var option = document.createElement("option");
        var tahun = year - min - i;
        option.value = tahun;
        option.innerHTML = tahun;
        years.appendChild(option);
    }
}

loadMonths();
function loadMonths() {
    var months = [
        "Januari",
        "Febuari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember",
    ];
    var month = document.querySelector(".months");
    for (var i = 0; i < months.length; i++) {
        var option = document.createElement("option");
        option.value = i + 1;
        option.innerHTML = months[i];
        month.appendChild(option);
    }
}

// Rekap Data
function rekapData(tipe_file) {
    var id_pegawai = url_segment;
    var tgl_awal = $(".tgl_awal").val();
    var tgl_akhir = $(".tgl_akhir").val();
    loading.classList.remove("hide");
    $.ajax({
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: mainUrl + "/print_data",
        data: {
            id_pegawai: id_pegawai,
            tgl_awal: tgl_awal,
            tgl_akhir: tgl_akhir,
            tipe_file: tipe_file,
        },
        success: function (response) {
            loading.classList.add("hide");
            document.querySelector(".link-download").innerHTML =
                '<p>Silahkan Download File dibawah ini!</p><a href="' +
                response +
                '" class="btn btn-info">Download File</a>';
            console.log(response);
        },
    });
}

function rekapDataAll(tipe_file) {
    var id_pegawai = url_segment;
    var tgl_awal = $(".tgl_periode_awal").val();
    var tgl_akhir = $(".tgl_periode_akhir").val();
    loading.classList.remove("hide");
    $.ajax({
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: mainUrl + "/cetak_pdf_all_kolektif",
        data: {
            id_pegawai: id_pegawai,
            tgl_awal: tgl_awal,
            tgl_akhir: tgl_akhir,
            tipe_file: tipe_file,
        },
        success: function (response) {
            loading.classList.add("hide");
            document.querySelector(".link-download").innerHTML =
                '<p>Silahkan Download File dibawah ini!</p><a href="' +
                response +
                '" class="btn btn-info">Download File</a>';
            console.log(response);
        },
    });
}

function rekapDataKolektif(tipe_file) {
    var id_pegawai = url_segment;
    var tgl_awal = $(".tgl_awal").val();
    var tgl_akhir = $(".tgl_akhir").val();
    loading.classList.remove("hide");
    $.ajax({
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: mainUrl + "/print_data_kolektif",
        data: {
            id_pegawai: id_pegawai,
            tgl_awal: tgl_awal,
            tgl_akhir: tgl_akhir,
            tipe_file: tipe_file,
        },
        success: function (response) {
            console.log(response);
            loading.classList.add("hide");
            document.querySelector(".link-download").innerHTML =
                '<p>Silahkan Download File dibawah ini!</p><a href="' +
                response +
                '" class="btn btn-info">Download File</a>';
            console.log(response);
        },
    });
}

// Detail Presensi
function showDetPresensi(id) {
    $("#modalDetPresensi").modal("show");
    document.querySelector(".loading-detail").classList.remove("hide");
    $.ajax({
        url: mainUrl + "/detail_presensi/" + id,
        method: "GET",
        success: function (response) {
            document.querySelector(".loading-detail").classList.add("hide");
            document.querySelector(".table-detail").classList.remove("hide");
            response.forEach((row) => {
                document.querySelector(".tgl_presensi").innerHTML =
                    row.tgl_presensi;
                document.querySelector(".jam_masuk").innerHTML = row.jam_masuk;
                document.querySelector(".jam_pulang").innerHTML =
                    row.jam_pulang;
                document.querySelector(".ket_jam_masuk").innerHTML =
                    row.ket_masuk;
                document.querySelector(".ket_jam_pulang").innerHTML =
                    row.ket_pulang;
                document.querySelector(".n_telat_masuk").innerHTML =
                    row.n_telat_masuk;
                document.querySelector(".n_telat_pulang").innerHTML =
                    row.n_telat_pulang;
            });
        },
    });
}

// Send Notification
var tipePegawai = "";
var tipePresensi = "";

function selectTipePegawai(){
    const getTipePegawai = document.querySelector(".tipe_pegawai");
    tipePegawai = getTipePegawai.value;
}

function selectTipePresensi(){
    const getTipePresensi = document.querySelector("#tipe_presensi");
    tipePresensi = getTipePresensi.value;
}

function sendNotifAllPegawai(){
    const showNotif = document.querySelector(".notif-pemberitahuan");
    $.ajax({
        url: mainUrl + "/api/callnotification",
        method: "POST",
        data: {
            id_pegawai: "allPegawai",
            tipePegawai: tipePegawai,
            tipePresensi: tipePresensi,
        },
        success: function (response) {
            showNotif.classList.remove("hide");
            showNotif.classList.add("show");
            console.log(response);
        },
    });
}

function sendNotif(id_pegawai, pegawaiTipe) {
    const alertNotif = document.querySelector(".notif-pemberitahuan");
    alertNotif.classList.add("show");
    alertNotif.classList.remove("hide");
    $.ajax({
        url: mainUrl + "/api/callnotification",
        method: "POST",
        data: {
            id_pegawai: id_pegawai,
            tipePegawai: pegawaiTipe,
            tipePresensi: tipePresensi,
        },
        success: function (response) {
            alertNotif.classList.add("hide");
            alertNotif.classList.remove("show");
        },
    });
}

function actAbsen(status) {
    $('.status_izin').val(status);
    const btnApprove = document.querySelector(".btn-approve");
    const btnReject = document.querySelector(".btn-reject");
    const btnLoading = document.querySelector(".btn-loading");
    if (status == "accepted") {
        message = "Berhasil menyetujui izin / cuti";
        btnLoading.classList.remove("hide");
        btnApprove.classList.add("hide");
        btnReject.setAttributeNode(document.createAttribute("disabled"));
    } else {
        message = "Berhasil menolak izin / cuti";
        btnLoading.classList.remove("hide");
        btnLoading.classList.remove("btn-primary");
        btnLoading.classList.remove("btn-danger");
        btnReject.classList.add("hide");
        btnApprove.setAttributeNode(document.createAttribute("disabled"));
    }
}
