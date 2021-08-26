console.log(dataPresensiMasuk);
console.log(dataPresensiPulang);
$(function () {
    Chart.defaults.global.defaultFontSize = 14;
    // Presensi
    var cDataJamMasuk = dataPresensiMasuk;
    var ctx = $(".jam_masuk");

    var listDataPresensiMasuk = {
        label: "Data Presensi Pegawai",
        data: cDataJamMasuk.data,
        backgroundColor: [
            "#80dda7",
            "#b5b5b5",
            "#e3e567",
            "#f9b06b",
            "#f46e6e"
        ],
    };

    var chartOptions = {
        legend: {
            display: true,
            labels: {
                fontSize: 16,
            },
        },
        plugins: {
            datalabels: {
                formatter: (value, ctx) => {
                    let datasets = ctx.chart.data.datasets;
                    if (datasets.indexOf(ctx.dataset) === datasets.length - 1) {
                        let sum = datasets[0].data.reduce((a, b) => a + b, 0);
                        let percentage = Math.round((value / sum) * 100) + "%";
                        return percentage;
                    } else {
                        return percentage;
                    }
                },
                labels: {
                    title: {
                        font: {
                            size: 16,
                        },
                    },
                },
            },
        },
    };

    var jamMasuk = new Chart(ctx, {
        type: "pie",
        data: {
            labels: cDataJamMasuk.label,
            datasets: [listDataPresensiMasuk],
        },
        options: chartOptions,
    });


    var cDataJamPulang = dataPresensiPulang;
    var ctx = $(".jam_pulang");

    var listDataPresensiPulang = {
        label: "Data Presensi Pegawai",
        data: cDataJamPulang.data,
        backgroundColor: [
            "#80dda7",
            "#b5b5b5",
            "#e3e567",
            "#f9b06b",
            "#f46e6e"
        ],
    };

    var chartOptions2 = {
        legend: {
            display: true,
            labels: {
                fontSize: 16,
            },
        },
        plugins: {
            datalabels: {
                formatter: (value, ctx) => {
                    let datasets = ctx.chart.data.datasets;
                    if (datasets.indexOf(ctx.dataset) === datasets.length - 1) {
                        let sum = datasets[0].data.reduce((a, b) => a + b, 0);
                        let percentage = Math.round((value / sum) * 100) + "%";
                        return percentage;
                    } else {
                        return percentage;
                    }
                },
                labels: {
                    title: {
                        font: {
                            size: 16,
                        },
                    },
                },
            },
        },
    };

    var jamPulang = new Chart(ctx, {
        type: "pie",
        data: {
            labels: cDataJamPulang.label,
            datasets: [listDataPresensiPulang],
        },
        options: chartOptions2,
    });


    var cDataPresensi = dataPresensi;
    var ctx = $(".data_det_presensi");

    var listDataPresensi = {
        label: "Data Presensi Pegawai",
        data: cDataPresensi.data,
        backgroundColor: [
            "#80dda7",
            "#b5b5b5",
            "#e3e567",
            "#f9b06b",
            "#f46e6e"
        ],
    };

    var chartOptions3 = {
        legend: {
            display: true,
            labels: {
                fontSize: 16,
            },
        },
        plugins: {
            datalabels: {
                formatter: (value, ctx) => {
                    let datasets = ctx.chart.data.datasets;
                    if (datasets.indexOf(ctx.dataset) === datasets.length - 1) {
                        let sum = datasets[0].data.reduce((a, b) => a + b, 0);
                        let percentage = Math.round((value / sum) * 100) + "%";
                        return percentage;
                    } else {
                        return percentage;
                    }
                },
                labels: {
                    title: {
                        font: {
                            size: 16,
                        },
                    },
                },
            },
        },
    };

    var presensiData = new Chart(ctx, {
        type: "pie",
        data: {
            labels: cDataPresensi.label,
            datasets: [listDataPresensi],
        },
        options: chartOptions3,
    });

   

    // Tugas
    var cDataTugas = dataTugas;
    console.log(cDataTugas);
    var ctx3 = $(".tugas");
    var dataTugas2 = {
        labels: cDataTugas.label,
        datasets: [
            {
                data: cDataTugas.data,
                backgroundColor: ["#FF0000", "#008000", "#FFFF00"],
            },
        ],
    };
    // options
    var optionsTugas = {
        legend: {
            display: true,
            labels: {
                fontSize: 16,
            },
        },
        plugins: {
            datalabels: {
                formatter: (value, ctx3) => {
                    let datasets = ctx3.chart.data.datasets;
                    if (
                        datasets.indexOf(ctx3.dataset) ===
                        datasets.length - 1
                    ) {
                        let sum = datasets[0].data.reduce((a, b) => a + b, 0);
                        let percentage = Math.round((value / sum) * 100) + "%";
                        return percentage;
                    } else {
                        return percentage;
                    }
                },
                color: "#fff",
                labels: {
                    title: {
                        font: {
                            size: 18,
                        },
                    },
                },
            },
        },
    };
    var chartTugas = new Chart(ctx3, {
        type: "pie",
        data: dataTugas2,
        options: optionsTugas,
    });
});
