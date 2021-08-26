$("#data").DataTable();

// Log Presensi
$(function () {
    var rangeDates = $(".tgl_awal, .tgl_akhir").datepicker({
        dateFormat: "yy-mm-dd",
    });
    // Log Presensi
    var table_log_presensi = $(".data-log-presensi").DataTable({
        processing: true,
        serverSide: true,
        sDom: "lrtip",
        ajax: {
            url: mainUrl + "/log_presensi/" + url_segment,
            data: function (d) {
                (d.nama_peg = $(".nama_peg").val()),
                (d.tgl_awal = $(".tgl_awal").val()),
                (d.tgl_akhir = $(".tgl_akhir").val()),
                (d.search = $('input[type="search"]').val());
            },
        },
        columns: [
            { data: "DT_RowIndex", name: "DT_RowIndex" },
            { data: "tgl_presensi", name: "tgl_presensi" },
            { data: "waktu_jam_masuk", name: "waktu_jam_masuk" },
            { data: "waktu_jam_pulang", name: "waktu_jam_pulang" },
            { data: "status_jam_masuk", name: "status_jam_masuk" },
            { data: "status_jam_pulang", name: "status_jam_pulang" },
        ],
        responsive: true,
    });

    $(".tgl_akhir").change(function () {
        table_log_presensi.draw();
    });

    $(".resetFilterLog").click(function () {
        rangeDates.datepicker("setDate", null);
        table_log_presensi.draw();
    });

    $(".nama_peg").keypress(function(){
        table_log_presensi.draw();
    });



    // Table Report Presensi
    var rangeDates2 = $(".tgl_periode_awal, .tgl_periode_akhir").datepicker({
        dateFormat: "yy-mm-dd",
    });
    // Log Presensi
    var table_report_presensi = $(".data-report-presensi").DataTable({
        processing: true,
        serverSide: true,
        sDom: "lrtip",
        ajax: {
            url: mainUrl + "/log_presensi/group/" + url_segment,
            data: function (d) {
                (d.tgl_awal = $(".tgl_periode_awal").val()),
                (d.tgl_akhir = $(".tgl_periode_akhir").val()),
                (d.search = $('input[type="search"]').val());
            },
        },
        columns: [
            { data: "DT_RowIndex", name: "DT_RowIndex" },
            { data: "nip", name: "nip" },
            { data: "nama", name: "nama" },
            { data: "tl1", name: "tl1" },
            { data: "tl2", name: "tl2" },
            { data: "tl3", name: "tl3" },
            { data: "tl4", name: "tl4" },
            { data: "psw1", name: "psw1" },
            { data: "psw2", name: "psw2" },
            { data: "psw3", name: "psw3" },
            { data: "psw4", name: "psw4" },
            { data: "tepat_waktu", name: "tepat_waktu" },
            { data: "hadir", name: "hadir" },
            { data: "izin", name: "izin"},
            { data: "tidak_hadir", name: "tidak_hadir" },
            { data: "action", name: "action" },
        ],
        responsive: true,
    });

    $(".tgl_periode_akhir").change(function () {
        table_report_presensi.draw();
    });

    $(".resetFilterLog").click(function () {
        rangeDates2.datepicker("setDate", null);
        table_report_presensi.draw();
    });

});
