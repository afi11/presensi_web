$(".select2_nm_pegawai")
    .select2({
        minimumInputLength: 3,
        allowClear: true,
        placeholder: "Nama Pegawai",
        ajax: {
            dataType: "json",
            url: mainUrl + "/all_pegawai",
            delay: 800,
            data: function (params) {
                return {
                    search: params.term,
                };
            },
            processResults: function (data, page) {
                return {
                    results: data,
                };
            },
        },
    })
    .on("select2_nm_pegawai:select", function (evt) {
        var data = $(".select2_nm_pegawai option:selected").text();
    });
