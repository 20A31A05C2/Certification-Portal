@extends('layouts.adminsidebar')

@section('content')
    <!-- Custom Styles -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Main Dashboard Content -->
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-6">
        <div class="space-y-12">
            <!-- Dashboard Header -->
            <div class="glass-effect rounded-2xl shadow-lg p-6 mb-8">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center space-y-4 lg:space-y-0">
                    <div>
                        <div class="flex items-center space-x-3">
                            <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
                            <span class="px-3 py-1 text-xs font-semibold text-blue-600 bg-blue-100 rounded-full">Live</span>
                        </div>
                        <p class="mt-2 text-gray-600">Overview of your certification metrics</p>
                    </div>

                    <button id="refreshData"
                        class="flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Refresh
                    </button>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <!-- Total Users Card -->
                <div class="stat-card bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-white/10 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                    <button onclick="window.location.href='{{ route('adminusers') }}'">

                        <div class="space-y-2">
                            <p class="text-sm font-medium text-white/80">Total Users</p>
                            <div class="flex items-baseline">
                                <p class="text-3xl font-bold">{{ number_format(App\Models\User::count()) }}</p>
                                <span class="ml-2 text-sm font-medium text-white/80">users</span>
                            </div>
                        </div>
                    </button>
                </div>

                <!-- Certifications Card -->
                <div class="stat-card bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl p-6 text-white">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-white/10 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                        </div>
                    </div>
                    <button onclick="window.location.href='{{ route('addcert') }}'">
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-white/80">Total Certifications</p>
                            <div class="flex items-baseline">
                                <p class="text-3xl font-bold">{{ number_format(App\Models\Certification::count()) }}</p>
                                <span class="ml-2 text-sm font-medium text-white/80">certificates</span>
                            </div>
                        </div>
                    </button>
                </div>
            </div>

            <!-- Chart Section -->
            <div class="glass-effect rounded-2xl shadow-lg p-8 chart-container">
                <div class="flex flex-col space-y-6">
                    <!-- Chart Header with Controls -->
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between space-y-4 lg:space-y-0">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Certification Distribution</h3>
                            <p class="text-gray-500 mt-1">Breakdown of certification distribution</p>
                        </div>

                        <div class="flex flex-wrap gap-4">
                            <!-- Time Range Selector -->
                            <select id="timeRange"
                                class="px-4 py-2 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="day">Today</option>
                                <option value="week">This Week</option>
                                <option value="month" selected>This Month</option>
                                <option value="quarter">This Quarter</option>
                                <option value="year">This Year</option>
                            </select>

                            <!-- Chart Type Selector -->
                            <div class="inline-flex rounded-lg shadow-sm">
                                <button data-type="BarChart"
                                    class="chart-toggle-btn px-4 py-2 text-sm font-medium rounded-l-lg border border-gray-200 hover:bg-gray-50 focus:z-10 focus:ring-2 focus:ring-blue-500 active bg-blue-50 text-blue-600">
                                    Bar
                                </button>
                                <button data-type="ColumnChart"
                                    class="chart-toggle-btn px-4 py-2 text-sm font-medium border-t border-b border-gray-200 hover:bg-gray-50 focus:z-10 focus:ring-2 focus:ring-blue-500">
                                    Column
                                </button>
                                <button data-type="PieChart"
                                    class="chart-toggle-btn px-4 py-2 text-sm font-medium rounded-r-lg border border-gray-200 hover:bg-gray-50 focus:z-10 focus:ring-2 focus:ring-blue-500">
                                    Pie
                                </button>
                            </div>

                            <!-- View Options -->
                            <select id="viewOption"
                                class="px-4 py-2 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="count">Count</option>
                                <option value="percentage">Percentage</option>
                            </select>
                        </div>
                    </div>

                    <!-- Chart Area -->
                    <div class="relative">
                        <div id="certificationChart" class="w-full h-[500px] transition-all duration-300"></div>

                        <!-- Loading Overlay -->
                        <div id="chartLoader" class="hidden absolute inset-0 bg-white/80 flex items-center justify-center">
                            <div class="flex flex-col items-center">
                                <div
                                    class="w-12 h-12 border-4 border-blue-500 border-t-transparent rounded-full animate-spin">
                                </div>
                                <p class="mt-4 text-gray-600">Loading data...</p>
                            </div>
                        </div>
                    </div>

                    <!-- Chart Legend -->
                    <div id="chartLegend" class="flex flex-wrap gap-4 justify-center pt-4 border-t border-gray-100"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Google Charts Script -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart'],
            'language': 'en'
        });
        google.charts.setOnLoadCallback(initChart);

        let currentData;
        let currentChart;
        let chartType = 'BarChart';
        let viewOption = 'count';

        function showLoader() {
            document.getElementById('chartLoader').classList.remove('hidden');
        }

        function hideLoader() {
            document.getElementById('chartLoader').classList.add('hidden');
        }

        function initChart() {
            setupEventListeners();
            fetchAndUpdateChart();
        }

        function setupEventListeners() {
            document.querySelectorAll('.chart-toggle-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.querySelectorAll('.chart-toggle-btn').forEach(b => {
                        b.classList.remove('active', 'bg-blue-50', 'text-blue-600');
                    });
                    this.classList.add('active', 'bg-blue-50', 'text-blue-600');

                    chartType = this.dataset.type;
                    if (currentData) drawChart(currentData);
                });
            });

            document.getElementById('viewOption').addEventListener('change', function() {
                viewOption = this.value;
                if (currentData) drawChart(currentData);
            });

            document.getElementById('timeRange').addEventListener('change', fetchAndUpdateChart);

            document.getElementById('refreshData').addEventListener('click', () => {
                const button = document.getElementById('refreshData');
                button.disabled = true;
                button.innerHTML = `
                <svg class="animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Refreshing...
            `;
                fetchAndUpdateChart().finally(() => {
                    button.disabled = false;
                    button.innerHTML = `
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Refresh
                `;
                });
            });
        }

        function showNoDataMessage() {
            const chartDiv = document.getElementById('certificationChart');
            const legendDiv = document.getElementById('chartLegend');

            // Clear any existing chart
            if (currentChart) {
                currentChart.clearChart();
            }

            // Clear the legend
            legendDiv.innerHTML = '';

            // Show no data message
            chartDiv.innerHTML = `
            <div class="flex flex-col items-center justify-center h-full">
                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No Data Available</h3>
                <p class="mt-1 text-sm text-gray-500">No certification data found for the selected time period.</p>
            </div>
        `;
        }

        async function fetchAndUpdateChart() {
            showLoader();
            try {
                const timeRange = document.getElementById('timeRange').value;
                const response = await fetch(`{{ route('certification.stats') }}?timeRange=${timeRange}`);
                if (!response.ok) throw new Error('Network response was not ok');

                const data = await response.json();
                currentData = data;

                if (!data.certifications || data.certifications.length === 0) {
                    showNoDataMessage();
                } else {
                    drawChart(data);
                }
            } catch (error) {
                console.error('Error fetching data:', error);
                showError('Failed to fetch data. Please try again.');
            } finally {
                hideLoader();
            }
        }

        function drawChart(data) {
            if (!data.certifications || data.certifications.length === 0) {
                showNoDataMessage();
                return;
            }

            const chartData = prepareChartData(data);
            const dataTable = google.visualization.arrayToDataTable(chartData);
            const options = getChartOptions();

            if (currentChart) {
                currentChart.clearChart();
            }

            const chartDiv = document.getElementById('certificationChart');
            currentChart = new google.visualization[chartType](chartDiv);

            chartDiv.style.opacity = 0;
            currentChart.draw(dataTable, options);

            setTimeout(() => {
                chartDiv.style.opacity = 1;
                chartDiv.style.transition = 'opacity 0.5s ease';
            }, 100);

            updateLegend(data.certifications, generateGradientColors(data.certifications.length));
            setupChartInteractions(currentChart, dataTable);
        }

        function prepareChartData(data) {
            const chartData = [
                ['Certification', 'Value', {
                    role: 'style'
                }, {
                    role: 'annotation'
                }, {
                    role: 'tooltip',
                    p: {
                        html: true
                    }
                }]
            ];
            const colors = generateGradientColors(data.certifications.length);
            const total = data.certifications.reduce((sum, cert) => sum + cert.count, 0);

            data.certifications.forEach((cert, index) => {
                let value, annotation;
                if (viewOption === 'percentage') {
                    value = (cert.count / total * 100);
                    annotation = `${value.toFixed(1)}%`;
                } else {
                    value = cert.count;
                    annotation = value.toLocaleString();
                }

                // For Bar and Column charts, use solid colors instead of gradients
                const [startColor] = colors[index].match(/#[0-9A-Fa-f]{6}/g);
                const barColor = chartType === 'PieChart' ? colors[index] : startColor;

                chartData.push([
                    cert.name,
                    value,
                    barColor, // Use solid color for bars
                    annotation,
                    createTooltipHtml(cert, value, total)
                ]);
            });

            return chartData;
        }

        function getChartOptions() {
            const baseOptions = {
                backgroundColor: {
                    fill: 'transparent'
                },
                chartArea: {
                    width: '85%',
                    height: '80%',
                    backgroundColor: {
                        fill: 'transparent'
                    }
                },
                animation: {
                    startup: true,
                    duration: 1000,
                    easing: 'out'
                },
                tooltip: {
                    isHtml: true,
                    trigger: 'hover'
                },
                legend: 'none' // Hide default legend for bar and column charts
            };

            const chartSpecificOptions = {
                BarChart: {
                    hAxis: {
                        title: viewOption === 'percentage' ? 'Percentage (%)' : 'Count',
                        titleTextStyle: {
                            color: '#374151',
                            italic: false,
                            bold: true
                        },
                        textStyle: {
                            color: '#374151'
                        },
                        gridlines: {
                            color: '#E5E7EB'
                        },
                        minValue: 0
                    },
                    vAxis: {
                        textStyle: {
                            color: '#374151'
                        },
                        gridlines: {
                            color: 'transparent'
                        }
                    }
                },
                ColumnChart: {
                    vAxis: {
                        title: viewOption === 'percentage' ? 'Percentage (%)' : 'Count',
                        titleTextStyle: {
                            color: '#374151',
                            italic: false,
                            bold: true
                        },
                        textStyle: {
                            color: '#374151'
                        },
                        gridlines: {
                            color: '#E5E7EB'
                        },
                        minValue: 0
                    },
                    hAxis: {
                        textStyle: {
                            color: '#374151'
                        },
                        gridlines: {
                            color: 'transparent'
                        }
                    }
                },
                PieChart: {

                    pieHole: 0.4,
                    sliceVisibilityThreshold: 0.05,
                    legend: {
                        position: 'right'
                    },
                    pieSliceText: viewOption === 'percentage' ? 'percentage' : 'value'
                }
            };

            return {
                ...baseOptions,
                ...chartSpecificOptions[chartType],
                bar: chartType === 'BarChart' ? {
                    groupWidth: '70%'
                } : undefined,
                column: chartType === 'ColumnChart' ? {
                    groupWidth: '70%'
                } : undefined
            };
        }

        function generateGradientColors(count) {
            const baseColors = [
                ['#3B82F6', '#2563EB'], // Blue
                ['#10B981', '#059669'], // Green
                ['#6366F1', '#4F46E5'], // Indigo
                ['#F59E0B', '#D97706'], // Amber
                ['#EC4899', '#DB2777'], // Pink
                ['#8B5CF6', '#7C3AED'], // Purple
                ['#14B8A6', '#0D9488'], // Teal
                ['#EF4444', '#DC2626'], // Red
                ['#F97316', '#EA580C'], // Orange
                ['#84CC16', '#65A30D'] // Lime
            ];

            return Array.from({
                length: count
            }, (_, i) => {
                const [start, end] = baseColors[i % baseColors.length];
                return `linear-gradient(45deg, ${start}, ${end})`;
            });
        }

        function createTooltipHtml(cert, value, total) {
            const percentage = (cert.count / total * 100).toFixed(1);
            return `
        <div class="bg-white shadow-lg rounded-lg p-4 border border-gray-200">
            <div class="font-bold text-gray-900">${cert.name}</div>
            <div class="text-gray-600 mt-1">
                Count: ${cert.count.toLocaleString()}<br>
                Percentage: ${percentage}%
            </div>
        </div>
    `;
        }

        function updateLegend(certifications, colors) {
            const legend = document.getElementById('chartLegend');
            legend.innerHTML = '';

            certifications.forEach((cert, index) => {
                const legendItem = document.createElement('div');
                legendItem.className =
                    'flex items-center space-x-2 px-3 py-1 rounded-full border border-gray-200 hover:bg-gray-50 cursor-pointer transition-colors';

                // Use solid colors for bar/column charts, gradients for pie chart
                const [startColor] = colors[index].match(/#[0-9A-Fa-f]{6}/g);
                const backgroundStyle = chartType === 'PieChart' ?
                    colors[index].replace('linear-gradient', 'linear-gradient(45deg') :
                    startColor;

                legendItem.innerHTML = `
            <div class="w-3 h-3 rounded-full" style="background: ${backgroundStyle}"></div>
            <span class="text-sm font-medium text-gray-700">${cert.name}</span>
        `;

                legendItem.addEventListener('click', () => {
                    if (currentChart) {
                        currentChart.setSelection([{
                            row: index
                        }]);
                        highlightLegendItem(index);
                    }
                });

                legend.appendChild(legendItem);
            });
        }

        function highlightLegendItem(selectedIndex) {
            const legendItems = document.getElementById('chartLegend').children;
            Array.from(legendItems).forEach((item, index) => {
                item.classList.toggle('bg-gray-100', index === selectedIndex);
                item.classList.toggle('border-blue-500', index === selectedIndex);
            });
        }

        function showError(message) {
            const toast = document.createElement('div');
            toast.className =
                'fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg transform transition-transform duration-300 translate-y-full';
            toast.innerHTML = `
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>${message}</span>
            </div>
        `;

            document.body.appendChild(toast);
            requestAnimationFrame(() => {
                toast.style.transform = 'translateY(0)';
            });

            setTimeout(() => {
                toast.style.transform = 'translateY(100%)';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        function setupChartInteractions(chart, dataTable) {
            google.visualization.events.addListener(chart, 'select', function() {
                const selection = chart.getSelection();
                if (selection.length > 0) {
                    const row = selection[0].row;
                    const certName = dataTable.getValue(row, 0);
                    highlightLegendItem(row);



                    if (chartType !== 'PieChart') {
                        const element = document.querySelector(
                            `#certificationChart svg g g g:nth-child(${row + 2})`);
                        if (element) {
                            element.style.transform = 'scale(1.05)';
                            element.style.transition = 'transform 0.3s ease';
                            setTimeout(() => {
                                element.style.transform = 'scale(1)';
                            }, 300);
                        }
                    }
                    window.location.href = `/admin/viewmore/${encodeURIComponent(certName)}`;
                }
            });


        }
    </script>
@endsection
