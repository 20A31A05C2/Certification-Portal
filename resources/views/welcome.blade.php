<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certification Analytics</title>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .chart-container {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(56, 189, 248, 0.08);
            border: 1px solid rgba(186, 230, 253, 0.4);
        }

        .gradient-background {
            background: linear-gradient(135deg, #e0f2fe, #ffffff, #f0f9ff);
            background-size: 400% 400%;
            animation: shine 15s ease infinite;
        }

        @keyframes shine {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        #chart-tooltip {
            pointer-events: none;
            transition: all 0.1s ease;
            z-index: 1000;
        }
    </style>
</head>
<body class="gradient-background min-h-screen p-8">
    <div class="max-w-7xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Certification Analytics</h1>
            <p class="text-gray-600 mt-2">Distribution by Organization and Batch Year</p>
        </div>

        <div class="chart-container">
            <div class="flex flex-col space-y-6">
                <!-- Chart Type Selector -->
                <div class="flex justify-end gap-2">
                    <button data-type="BarChart" class="chart-toggle-btn px-6 py-2.5 text-sm font-medium rounded-lg border border-gray-200 hover:bg-blue-50 focus:ring-2 focus:ring-blue-500 transition-all duration-300 active bg-blue-50 text-blue-600">
                        Bar Chart
                    </button>
                    <button data-type="PieChart" class="chart-toggle-btn px-6 py-2.5 text-sm font-medium rounded-lg border border-gray-200 hover:bg-purple-50 focus:ring-2 focus:ring-blue-500 transition-all duration-300">
                        Pie Chart
                    </button>
                </div>

                <!-- Chart Area -->
                <div class="relative min-h-[500px] bg-white/50 rounded-xl p-4">
                    <div id="certificationChart" class="w-full h-[500px]"></div>
                    <div id="chartLoader" class="hidden absolute inset-0 bg-white/80 flex items-center justify-center">
                        <div class="flex flex-col items-center">
                            <div class="w-12 h-12 border-4 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
                            <p class="mt-4 text-gray-600">Loading data...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    google.charts.load('current', { 'packages': ['corechart'] });
    
    let currentData;
    let currentChart;
    let chartType = 'BarChart';
    
    google.charts.setOnLoadCallback(initChart);
    
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
        // Chart type toggle buttons
        document.querySelectorAll('.chart-toggle-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove active state from all buttons
                document.querySelectorAll('.chart-toggle-btn').forEach(b => {
                    b.classList.remove('active', 'bg-blue-50', 'text-blue-600', 'bg-purple-50', 'text-purple-600');
                });
                
                // Add active state to clicked button
                if (this.dataset.type === 'BarChart') {
                    this.classList.add('active', 'bg-blue-50', 'text-blue-600');
                } else {
                    this.classList.add('active', 'bg-purple-50', 'text-purple-600');
                }
                
                chartType = this.dataset.type;
                if (currentData) drawChart(currentData);
            });
        });

        // Handle window resize
        let resizeTimeout;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                if (currentChart && currentData) {
                    drawChart(currentData);
                }
            }, 250);
        });
    }
    
    async function fetchAndUpdateChart() {
        showLoader();
        try {
            const response = await fetch(window.location.href, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            if (!response.ok) throw new Error('Network response was not ok');
            
            const data = await response.json();
            currentData = data;
            drawChart(data);
        } catch (error) {
            console.error('Error:', error);
            showError('Failed to load chart data');
        } finally {
            hideLoader();
        }
    }

    function prepareChartData(data) {
        if (chartType === 'BarChart') {
            // Prepare data for Bar Chart
            const organizations = [...new Set(data.certifications.map(item => item.organization))];
            const years = [...new Set(data.certifications.map(item => item.batch))];
            
            const chartData = [['Organization', ...years.map(year => `Batch ${year}`)]];
            
            organizations.forEach(org => {
                const row = [org];
                years.forEach(year => {
                    const certCount = data.certifications.find(
                        item => item.organization === org && item.batch === year
                    )?.count || 0;
                    row.push(certCount);
                });
                chartData.push(row);
            });
            
            return chartData;
        } else {
            // Prepare data for Pie Chart
            const chartData = [['Organization', 'Total Certifications']];
            const orgTotals = {};
            
            data.certifications.forEach(item => {
                orgTotals[item.organization] = (orgTotals[item.organization] || 0) + item.count;
            });
            
            Object.entries(orgTotals).forEach(([org, count]) => {
                chartData.push([org, count]);
            });
            
            return chartData;
        }
    }

    function getChartColors() {
        return [
            '#38bdf8', '#7dd3fc', '#93c5fd', '#bae6fd', '#e0f2fe',
            '#ACC8E5', '#B8E0D2', '#CAB8FF', '#FFE5B4', '#FFD1DC'
        ];
    }

    function getChartOptions() {
        const baseOptions = {
            backgroundColor: { fill: 'transparent' },
            animation: {
                startup: true,
                duration: 1000,
                easing: 'out'
            },
            colors: getChartColors()
        };

        if (chartType === 'BarChart') {
            return {
                ...baseOptions,
                title: 'Certifications by Organization and Batch Year',
                titleTextStyle: { color: '#1e293b', fontSize: 16, bold: true },
                chartArea: { width: '70%', height: '70%' },
                legend: { position: 'top', maxLines: 3 },
                bar: { groupWidth: '70%' },
                hAxis: {
                    title: 'Number of Certifications',
                    titleTextStyle: { color: '#64748b', italic: false },
                    textStyle: { color: '#64748b' }
                },
                vAxis: {
                    title: 'Organization',
                    titleTextStyle: { color: '#64748b', italic: false },
                    textStyle: { color: '#64748b' }
                }
            };
        } else {
            return {
                ...baseOptions,
                title: 'Total Certifications by Organization',
                titleTextStyle: { color: '#1e293b', fontSize: 16, bold: true },
                chartArea: { width: '80%', height: '80%' },
                legend: { position: 'right' },
                pieHole: 0.4,
                tooltip: { trigger: 'selection', isHtml: true }
            };
        }
    }

    function drawChart(data) {
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
        
        google.visualization.events.addListener(currentChart, 'select', function() {
            const selection = currentChart.getSelection();
            if (selection.length > 0) {
                const row = selection[0].row;
                const col = selection[0].column;
                
                let tooltipContent;
                if (chartType === 'BarChart') {
                    const org = dataTable.getValue(row, 0);
                    const year = dataTable.getColumnLabel(col).replace('Batch ', '');
                    const count = dataTable.getValue(row, col);
                    tooltipContent = `
                        <div class="bg-white/95 backdrop-blur-sm p-4 rounded-lg shadow-lg border border-blue-100">
                            <div class="font-bold text-gray-900">${org}</div>
                            <div class="text-gray-600">Batch Year: ${year}</div>
                            <div class="text-blue-600 font-semibold mt-1">Certifications: ${count}</div>
                        </div>
                    `;
                } else {
                    const org = dataTable.getValue(row, 0);
                    const count = dataTable.getValue(row, 1);
                    tooltipContent = `
                        <div class="bg-white/95 backdrop-blur-sm p-4 rounded-lg shadow-lg border border-purple-100">
                            <div class="font-bold text-gray-900">${org}</div>
                            <div class="text-purple-600 font-semibold mt-1">Total Certifications: ${count}</div>
                        </div>
                    `;
                }
                showTooltip(tooltipContent);
            }
        });
        
        setTimeout(() => {
            chartDiv.style.opacity = 1;
            chartDiv.style.transition = 'opacity 0.5s ease';
        }, 100);
    }

    function showTooltip(content) {
        let tooltip = document.getElementById('chart-tooltip');
        if (!tooltip) {
            tooltip = document.createElement('div');
            tooltip.id = 'chart-tooltip';
            tooltip.className = 'fixed pointer-events-none transform -translate-x-1/2 -translate-y-full';
            document.body.appendChild(tooltip);
        }
        
        tooltip.innerHTML = content;
        tooltip.style.display = 'block';
        
        document.addEventListener('mousemove', function(e) {
            const x = e.pageX;
            const y = e.pageY - 10;
            tooltip.style.left = x + 'px';
            tooltip.style.top = y + 'px';
        });
        
        document.addEventListener('click', function() {
            tooltip.style.display = 'none';
        });
    }

    function showError(message) {
        const toast = document.createElement('div');
        toast.className = 'fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg transform transition-transform duration-300 translate-y-full z-50';
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
</script>
</body>
</html>