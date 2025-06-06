function getChartColorsArray(r) {
    if (null !== document.getElementById(r)) {
        var e = document.getElementById(r).getAttribute("data-colors");
        return (e = JSON.parse(e)).map(function(r) {
            var e = r.replace(" ", "");
            if (-1 == e.indexOf("--")) return e;
            var t = getComputedStyle(document.documentElement).getPropertyValue(e);
            return t || void 0
        })
    }
}
var barchartColors = getChartColorsArray("mini-1"),
    options1 = {
        series: [{
            data: [25, 66, 41, 89, 63, 25, 44, 23, 40, 40, 54, 41]
        }],
        fill: {
            colors: barchartColors,
            opacity: 1
        },
        chart: {
            type: "bar",
            height: 50,
            sparkline: {
                enabled: !0
            }
        },
        plotOptions: {
            bar: {
                columnWidth: "65%",
                borderRadius: 4
            }
        },
        labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
        xaxis: {
            crosshairs: {
                width: 1
            }
        },
        tooltip: {
            fixed: {
                enabled: !1
            },
            x: {
                show: !1
            },
            y: {
                title: {
                    formatter: function(r) {
                        return ""
                    }
                }
            },
            marker: {
                show: !1
            }
        }
    },
    chart1 = new ApexCharts(document.querySelector("#mini-1"), options1);
chart1.render();
options1 = {
    series: [{
        data: [56, 20, 80, 40, 75, 41, 25, 66, 41, 89, 63, 25]
    }],
    fill: {
        colors: barchartColors = getChartColorsArray("mini-2"),
        opacity: 1
    },
    chart: {
        type: "bar",
        height: 50,
        sparkline: {
            enabled: !0
        }
    },
    plotOptions: {
        bar: {
            columnWidth: "65%",
            borderRadius: 4
        }
    },
    labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
    xaxis: {
        crosshairs: {
            width: 1
        }
    },
    tooltip: {
        fixed: {
            enabled: !1
        },
        x: {
            show: !1
        },
        y: {
            title: {
                formatter: function(r) {
                    return ""
                }
            }
        },
        marker: {
            show: !1
        }
    }
};
(chart1 = new ApexCharts(document.querySelector("#mini-2"), options1)).render();
options1 = {
    series: [{
        data: [59, 63, 35, 75, 50, 66, 25, 66, 41, 40, 54, 41]
    }],
    fill: {
        colors: barchartColors = getChartColorsArray("mini-3"),
        opacity: 1
    },
    chart: {
        type: "bar",
        height: 50,
        sparkline: {
            enabled: !0
        }
    },
    plotOptions: {
        bar: {
            columnWidth: "65%",
            borderRadius: 4
        }
    },
    labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
    xaxis: {
        crosshairs: {
            width: 1
        }
    },
    tooltip: {
        fixed: {
            enabled: !1
        },
        x: {
            show: !1
        },
        y: {
            title: {
                formatter: function(r) {
                    return ""
                }
            }
        },
        marker: {
            show: !1
        }
    }
};
(chart1 = new ApexCharts(document.querySelector("#mini-3"), options1)).render();
options1 = {
    series: [{
        data: [45, 36, 40, 64, 41, 66, 41, 89, 63, 25, 44, 20]
    }],
    fill: {
        colors: barchartColors = getChartColorsArray("mini-4"),
        opacity: 1
    },
    chart: {
        type: "bar",
        height: 50,
        sparkline: {
            enabled: !0
        }
    },
    plotOptions: {
        bar: {
            columnWidth: "65%",
            borderRadius: 4
        }
    },
    labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
    xaxis: {
        crosshairs: {
            width: 1
        }
    },
    tooltip: {
        fixed: {
            enabled: !1
        },
        x: {
            show: !1
        },
        y: {
            title: {
                formatter: function(r) {
                    return ""
                }
            }
        },
        marker: {
            show: !1
        }
    }
};
(chart1 = new ApexCharts(document.querySelector("#mini-4"), options1)).render();
options1 = {
    chart: {
        type: "area",
        height: 360,
        toolbar: {
            show: !1
        }
    },
    series: [{
        name: "Incomes",
        data: [0, 20, 35, 45, 35, 55, 65, 50, 65, 75, 60, 75]
    }, {
        name: "Expenses",
        data: [15, 9, 17, 32, 25, 68, 80, 68, 84, 94, 74, 62]
    }],
    stroke: {
        curve: "straight",
        width: ["4", "4"]
    },
    grid: {
        xaxis: {
            lines: {
                show: !0
            }
        },
        yaxis: {
            lines: {
                show: !0
            }
        }
    },
    colors: barchartColors = getChartColorsArray("sales-report"),
    xaxis: {
        categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Now", "Des"]
    },
    legend: {
        show: !1
    },
    fill: {
        type: "gradient",
        gradient: {
            shadeIntensity: 1,
            inverseColors: !1,
            opacityFrom: .4,
            opacityTo: .1,
            stops: [30, 100, 100, 100]
        }
    },
    dataLabels: {
        enabled: !1
    },
    tooltip: {
        fixed: {
            enabled: !1
        },
        x: {
            show: !1
        },
        y: {
            title: {
                formatter: function(r) {
                    return ""
                }
            }
        },
        marker: {
            show: !1
        }
    }
};
new ApexCharts(document.querySelector("#sales-report"), options1).render();

options = {
    series: [{
        data: [430, 570, 640, 680, 790, 1100, 1200, 1380]
    }],
    chart: {
        type: "bar",
        height: 323,
        toolbar: {
            show: !1
        }
    },
    labels: ["Canada", "Netherlands", "Italy", "France", "Japan", "United States", "China", "Germany"],
    colors: barchartColors = getChartColorsArray("sales-countries"),
    plotOptions: {
        bar: {
            borderRadius: 4,
            horizontal: !0
        }
    },
    dataLabels: {
        enabled: !1
    },
    xaxis: {
        categories: ["Canada", "Netherlands", "Italy", "France", "Japan", "United States", "China", "Germany"]
    }
};
(chart = new ApexCharts(document.querySelector("#sales-countries"), options)).render();
var sparklineoptions1 = {
        series: [{
            data: [25, 66, 41, 89, 63, 25, 44, 12, 36, 9, 54, 84]
        }],
        chart: {
            type: "area",
            width: 200,
            height: 40,
            sparkline: {
                enabled: !0
            }
        },
        fill: {
            type: "gradient",
            gradient: {
                shadeIntensity: 1,
                inverseColors: !1,
                opacityFrom: .45,
                opacityTo: .05,
                stops: [20, 100, 100, 100]
            }
        },
        stroke: {
            curve: "smooth",
            width: 2
        },
        colors: barchartColors = getChartColorsArray("chart-sparkline1"),
        tooltip: {
            fixed: {
                enabled: !1
            },
            x: {
                show: !1
            },
            y: {
                title: {
                    formatter: function(r) {
                        return ""
                    }
                }
            },
            marker: {
                show: !1
            }
        }
    },
    sparklinechart1 = new ApexCharts(document.querySelector("#chart-sparkline1"), sparklineoptions1);
sparklinechart1.render();
sparklineoptions1 = {
    series: [{
        data: [50, 15, 35, 62, 23, 56, 44, 12, 36, 9, 54, 23]
    }],
    chart: {
        type: "area",
        width: 200,
        height: 40,
        sparkline: {
            enabled: !0
        }
    },
    fill: {
        type: "gradient",
        gradient: {
            shadeIntensity: 1,
            inverseColors: !1,
            opacityFrom: .45,
            opacityTo: .05,
            stops: [20, 100, 100, 100]
        }
    },
    stroke: {
        curve: "smooth",
        width: 2
    },
    colors: barchartColors = getChartColorsArray("chart-sparkline2"),
    tooltip: {
        fixed: {
            enabled: !1
        },
        x: {
            show: !1
        },
        y: {
            title: {
                formatter: function(r) {
                    return ""
                }
            }
        },
        marker: {
            show: !1
        }
    }
};
(sparklinechart1 = new ApexCharts(document.querySelector("#chart-sparkline2"), sparklineoptions1)).render();
sparklineoptions1 = {
    series: [{
        data: [25, 35, 35, 89, 63, 25, 44, 12, 36, 9, 54, 25]
    }],
    chart: {
        type: "area",
        width: 200,
        height: 40,
        sparkline: {
            enabled: !0
        }
    },
    fill: {
        type: "gradient",
        gradient: {
            shadeIntensity: 1,
            inverseColors: !1,
            opacityFrom: .45,
            opacityTo: .05,
            stops: [20, 100, 100, 100]
        }
    },
    stroke: {
        curve: "smooth",
        width: 2
    },
    colors: barchartColors = getChartColorsArray("chart-sparkline3"),
    tooltip: {
        fixed: {
            enabled: !1
        },
        x: {
            show: !1
        },
        y: {
            title: {
                formatter: function(r) {
                    return ""
                }
            }
        },
        marker: {
            show: !1
        }
    }
};
(sparklinechart1 = new ApexCharts(document.querySelector("#chart-sparkline3"), sparklineoptions1)).render();
sparklineoptions1 = {
    series: [{
        data: [50, 15, 35, 34, 23, 56, 65, 41, 36, 41, 32, 25]
    }],
    chart: {
        type: "area",
        width: 200,
        height: 40,
        sparkline: {
            enabled: !0
        }
    },
    fill: {
        type: "gradient",
        gradient: {
            shadeIntensity: 1,
            inverseColors: !1,
            opacityFrom: .45,
            opacityTo: .05,
            stops: [20, 100, 100, 100]
        }
    },
    stroke: {
        curve: "smooth",
        width: 2
    },
    colors: barchartColors = getChartColorsArray("chart-sparkline4"),
    tooltip: {
        fixed: {
            enabled: !1
        },
        x: {
            show: !1
        },
        y: {
            title: {
                formatter: function(r) {
                    return ""
                }
            }
        },
        marker: {
            show: !1
        }
    }
};
(sparklinechart1 = new ApexCharts(document.querySelector("#chart-sparkline4"), sparklineoptions1)).render();
sparklineoptions1 = {
    series: [{
        data: [45, 53, 24, 89, 63, 60, 36, 50, 36, 32, 54, 63]
    }],
    chart: {
        type: "area",
        width: 200,
        height: 40,
        sparkline: {
            enabled: !0
        }
    },
    fill: {
        type: "gradient",
        gradient: {
            shadeIntensity: 1,
            inverseColors: !1,
            opacityFrom: .45,
            opacityTo: .05,
            stops: [20, 100, 100, 100]
        }
    },
    stroke: {
        curve: "smooth",
        width: 2
    },
    colors: barchartColors = getChartColorsArray("chart-sparkline5"),
    tooltip: {
        fixed: {
            enabled: !1
        },
        x: {
            show: !1
        },
        y: {
            title: {
                formatter: function(r) {
                    return ""
                }
            }
        },
        marker: {
            show: !1
        }
    }
};
(sparklinechart1 = new ApexCharts(document.querySelector("#chart-sparkline5"), sparklineoptions1)).render();