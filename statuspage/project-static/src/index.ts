import '@popperjs/core';
import 'htmx.org';
import 'simplebar';
import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);
// @ts-expect-error
window.Chart = Chart;
import './statuspage';
