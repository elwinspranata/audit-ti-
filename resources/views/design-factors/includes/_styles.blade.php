<style>
    /* Light theme */
    .light-card {
        background: white;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .light-input {
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        color: #1e293b;
    }

    .light-input:focus {
        background: white;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
    }

    /* Strategic Table Styling (like Excel) */
    .strategic-table {
        border-collapse: collapse;
        width: 100%;
    }

    .strategic-table th {
        background: #4a5d23;
        color: white;
        font-weight: 600;
        padding: 12px 16px;
        text-align: center;
        border: 1px solid #3d4d1c;
    }

    .strategic-table th:first-child {
        text-align: left;
    }

    .strategic-table td {
        padding: 12px 16px;
        border: 1px solid #c5d9a4;
    }

    .strategic-table tr:nth-child(odd) td {
        background: #f0f7e6;
    }

    .strategic-table tr:nth-child(even) td {
        background: white;
    }

    .strategic-table td:first-child {
        text-align: left;
        font-weight: 500;
        color: #1e293b;
    }

    .strategic-table td:not(:first-child) {
        text-align: center;
        font-weight: 600;
    }

    .strategic-table .baseline-col {
        background: #e8f5d6 !important;
        color: #4a5d23;
    }

    /* Badge Domain Colors */
    .badge-edm {
        background: #3b82f6;
        color: white;
    }

    .badge-apo {
        background: #22c55e;
        color: white;
    }

    .badge-bai {
        background: #f59e0b;
        color: white;
    }

    .badge-dss {
        background: #a855f7;
        color: white;
    }

    .badge-mea {
        background: #ef4444;
        color: white;
    }

    /* Value Colors */
    .value-positive {
        color: #16a34a;
    }

    .value-negative {
        color: #dc2626;
    }

    .value-neutral {
        color: #64748b;
    }

    /* Clean Table - Excel Style for DF3 */
    .clean-table {
        border-collapse: collapse;
        width: 100%;
        border: 1px solid #1e2f13;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .clean-table th {
        background-color: #375623 !important;
        color: #ffffff !important;
        font-weight: 700;
        padding: 12px 8px;
        text-align: center;
        border: 0.5px solid #1e2f13;
        font-size: 0.95rem;
        vertical-align: middle;
    }

    .clean-table th:first-child {
        text-align: left;
        padding-left: 16px;
    }

    .clean-table td {
        padding: 8px 12px;
        border: 0.5px solid #1e2f13;
        text-align: center;
        background-color: #e2efda;
        color: #000;
        font-size: 0.95rem;
    }

    .clean-table td:first-child {
        text-align: left;
        padding-left: 16px;
        font-weight: 500;
    }

    .clean-table td.df3-baseline {
        color: #ffffff !important;
        font-style: italic;
        font-weight: 700;
    }

    /* Heatmap Colors for DF3 */
    .bg-val-1 {
        background-color: #548235 !important;
        color: #ffffff !important;
    }

    .bg-val-2 {
        background-color: #a9d08e !important;
        color: #000000 !important;
    }

    .bg-val-3 {
        background-color: #ffff00 !important;
        color: #000000 !important;
    }

    .bg-val-4 {
        background-color: #f4b084 !important;
        color: #000000 !important;
    }

    .bg-val-5 {
        background-color: #ff0000 !important;
        color: #ffffff !important;
    }

    .heat-input {
        background-color: transparent !important;
        border: none !important;
        color: inherit !important;
        width: 100% !important;
        height: 100% !important;
        cursor: pointer;
        text-align: center;
        font-weight: bold;
    }

    /* DF4 Icon Selector Styles */
    .importance-icon-radio {
        appearance: none;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 2px solid #000;
        cursor: pointer;
        position: relative;
        margin: 0 auto;
        display: block;
    }

    .importance-icon-radio.green {
        background-color: #70ad47;
    }

    .importance-icon-radio.yellow {
        background-color: #ffc000;
    }

    .importance-icon-radio.red {
        background-color: #c00000;
    }

    .importance-icon-radio:checked::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #000;
    }

    .df4-importance-cell {
        text-align: center;
        padding: 8px 4px;
    }

    .validation-error {
        color: #dc2626;
        font-weight: 700;
    }

    .validation-success {
        color: #16a34a;
        font-weight: 700;
    }
</style>
