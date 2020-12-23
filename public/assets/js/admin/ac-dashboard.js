/**
 * Actudent "Pengaturan" scripts
 * 
 * @author      Adnan Zaki
 * @copyright   Wolestech (c) 2018
 */

const dashboard = new Vue({
    el: '#dashboard-content',
    mixins: [plugin],
    data: {
        changelogList: [],
        sevenDaysPresence: {},
    },
    mounted() {
        if(changelog.indexOf('-') === -1) {
            this.changelogList.push(changelog)            
        } else {
            let split = changelog.split('- ')
            split.forEach(item => {
                this.changelogList.push(item)
            })
        }
        $('#changelog-modal').modal('show')
        this.getLastSevenDaysPresence()
        
        if(localStorage.getItem('changelog') === null) {
            localStorage.setItem('changelog', 'show')
        }

        if(localStorage.getItem('version') === null) {
            localStorage.setItem('version', acVersion)
        }        
    },
    methods: {
        getLastSevenDaysPresence() {
            $.ajax({
                url: `${this.home}absensi-seminggu`,
                dataType: 'json',
                success: res => {
                    this.sevenDaysPresence = res
                    setTimeout(() => {
                        this.runCharts()
                    }, 1000);
                }
            })
        },
        hideChangelog() {
            localStorage.setItem('changelog', 'hide')
            localStorage.setItem('version', acVersion)
        },
        runCharts() {
            let obj = this
            /********************************************
            *               BTC Card                    *
            ********************************************/
            //Get the context of the Chart canvas element we want to select
            var btcChartjs = document.getElementById("btc-chartjs").getContext("2d");
            // Create Linear Gradient
            var blue_trans_gradient = btcChartjs.createLinearGradient(0, 0, 0, 100);
            blue_trans_gradient.addColorStop(0, 'rgba(255, 145, 73,0.4)');
            blue_trans_gradient.addColorStop(1, 'rgba(255,255,255,0)');
            // Chart Options
            var BTCStats = {
                responsive: true,
                maintainAspectRatio: false,
                datasetStrokeWidth : 3,
                pointDotStrokeWidth : 4,
                tooltipFillColor: "rgba(255, 145, 73,0.8)",
                legend: {
                    display: false,
                },
                hover: {
                    mode: 'label'
                },
                scales: {
                    xAxes: [{
                        display: false,
                    }],
                    yAxes: [{
                        display: false,
                        ticks: {
                            min: 0,
                            max: 100
                        },
                    }]
                },
                title: {
                    display: false,
                    fontColor: "#FFF",
                    fullWidth: false,
                    fontSize: 30,
                    text: '52%'
                }
            };
        
            // Chart Data           
            var BTCMonthData = {
                labels: ['first', 'second', 'third', 'fourth', 'fifth', 'sixth', 'seventh'],
                datasets: [{
                    label: "BTC",
                    data: obj.sevenDaysPresence.present,
                    backgroundColor: blue_trans_gradient,
                    borderColor: "#FF9149",
                    borderWidth: 1.5,
                    strokeColor : "#FF9149",
                    pointRadius: 0,
                }]
            };
        
            var BTCCardconfig = {
                type: 'line',
        
                // Chart Options
                options : BTCStats,
        
                // Chart Data
                data : BTCMonthData
            };
        
            // Create the chart
            var BTCAreaChart = new Chart(btcChartjs, BTCCardconfig);
        
            /********************************************
            *               ETH Card                    *
            ********************************************/
            //Get the context of the Chart canvas element we want to select
            var ethChartjs = document.getElementById("eth-chartjs").getContext("2d");
            // Create Linear Gradient
            var blue_trans_gradient = ethChartjs.createLinearGradient(0, 0, 0, 100);
            blue_trans_gradient.addColorStop(0, 'rgba(120, 144, 156,0.4)');
            blue_trans_gradient.addColorStop(1, 'rgba(255,255,255,0)');
            // Chart Options
            var ETHStats = {
                responsive: true,
                maintainAspectRatio: false,
                datasetStrokeWidth : 3,
                pointDotStrokeWidth : 4,
                tooltipFillColor: "rgba(120, 144, 156,0.8)",
                legend: {
                    display: false,
                },
                hover: {
                    mode: 'label'
                },
                scales: {
                    xAxes: [{
                        display: false,
                    }],
                    yAxes: [{
                        display: false,
                        ticks: {
                            min: 0,
                            max: 100
                        },
                    }]
                },
                title: {
                    display: false,
                    fontColor: "#FFF",
                    fullWidth: false,
                    fontSize: 30,
                    text: '52%'
                }
            };
        
            // Chart Data
            var ETHMonthData = {
                labels: ['first', 'second', 'third', 'fourth', 'fifth', 'sixth', 'seventh'],
                datasets: [{
                    label: "ETH",
                    data: obj.sevenDaysPresence.permit,
                    backgroundColor: blue_trans_gradient,
                    borderColor: "#78909C",
                    borderWidth: 1.5,
                    strokeColor : "#78909C",
                    pointRadius: 0,
                }]
            };
        
            var ETHCardconfig = {
                type: 'line',
                // Chart Options
                options : ETHStats,
                // Chart Data
                data : ETHMonthData
            };
        
            // Create the chart
            var ETHAreaChart = new Chart(ethChartjs, ETHCardconfig);
        
            /********************************************
            *               XRP Card                    *
            ********************************************/
            //Get the context of the Chart canvas element we want to select
            var xrpChartjs = document.getElementById("xrp-chartjs").getContext("2d");
            // Create Linear Gradient
            var blue_trans_gradient = xrpChartjs.createLinearGradient(0, 0, 0, 100);
            blue_trans_gradient.addColorStop(0, 'rgba(30,159,242,0.4)');
            blue_trans_gradient.addColorStop(1, 'rgba(255,255,255,0)');
            // Chart Options
            var XRPStats = {
                responsive: true,
                maintainAspectRatio: false,
                datasetStrokeWidth : 3,
                pointDotStrokeWidth : 4,
                tooltipFillColor: "rgba(30,159,242,0.8)",
                legend: {
                    display: false,
                },
                hover: {
                    mode: 'label'
                },
                scales: {
                    xAxes: [{
                        display: false,
                    }],
                    yAxes: [{
                        display: false,
                        ticks: {
                            min: 0,
                            max: 100
                        },
                    }]
                },
                title: {
                    display: false,
                    fontColor: "#FFF",
                    fullWidth: false,
                    fontSize: 30,
                    text: '52%'
                }
            };
        
            // Chart Data
            var XRPMonthData = {
                labels: ['first', 'second', 'third', 'fourth', 'fifth', 'sixth', 'seventh'],
                datasets: [{
                    label: "XRP",
                    data: obj.sevenDaysPresence.absent,
                    backgroundColor: blue_trans_gradient,
                    borderColor: "#1E9FF2",
                    borderWidth: 1.5,
                    strokeColor : "#1E9FF2",
                    pointRadius: 0,
                }]
            };
        
            var XRPCardconfig = {
                type: 'line',
        
                // Chart Options
                options : XRPStats,
        
                // Chart Data
                data : XRPMonthData
            };
        
            // Create the chart
            var XRPAreaChart = new Chart(xrpChartjs, XRPCardconfig);
        }
    },
    computed: {
        showChangelog() {
            let changelog = localStorage.getItem('changelog'),
                version = localStorage.getItem('version')
            
            return (changelog === 'show' || version !== acVersion) ? true : false
        },
        home() {
            if(actudentSection === 'admin') {
                return `${admin}home/`
            } else {
                return `${guru}home/`
            }
        }
    },
})