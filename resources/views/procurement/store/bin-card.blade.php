@extends('layouts_procurement.app')
@section('pageTitle', 'Bin Card')
@section('pageMenu', 'active')
@section('content')

<style>
    /* Search Section Styles */
    .search-section-wrapper {
        max-width: 1200px;
        width: 100%;
        margin: 0 auto 20px auto;
        background: #27ae60 !important;
        border: 3px solid #229954 !important;
        border-radius: 12px !important;
        padding: 20px !important;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        font-family: 'Courier New', monospace;
    }

    .search-section {
        display: flex;
        justify-content: center;
        align-items: flex-end;
        gap: 15px;
        flex-wrap: wrap;
    }

    .search-group {
        display: flex;
        flex-direction: column;
        min-width: 300px;
    }

    .search-label {
        font-size: 14px !important;
        font-weight: bold !important;
        color: #ffffff !important;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 8px;
        text-shadow: 1px 1px 0 #000;
    }

    .search-select {
        padding: 12px 15px !important;
        border: 2px solid #229954 !important;
        border-radius: 8px !important;
        font-size: 16px !important;
        font-family: 'Courier New', monospace !important;
        background: #ecf0f1 !important;
        transition: all 0.3s ease;
        width: 100%;
        color: #2c3e50;
        font-weight: bold;
        cursor: pointer;
    }

    .search-select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23229954' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><polyline points='6 9 12 15 18 9'/></svg>");
        background-repeat: no-repeat;
        background-position: right 15px center;
        background-size: 16px;
        padding-right: 45px !important;
    }

    .search-select:focus {
        outline: none;
        border-color: #27ae60 !important;
        box-shadow: 0 0 15px rgba(39, 174, 96, 0.5);
        background: white !important;
    }

    .search-select option {
        background: #ecf0f1;
        color: #2c3e50;
        padding: 10px;
        font-family: 'Courier New', monospace;
    }

    .search-button {
        background: #e67e22 !important;
        color: white !important;
        border: none !important;
        padding: 12px 25px !important;
        border-radius: 8px !important;
        font-size: 16px !important;
        font-weight: bold !important;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
        height: 48px;
        border: 2px solid #c0392b !important;
        font-family: 'Courier New', monospace;
        min-width: 100px;
    }

    .search-button:hover {
        background: #c0392b !important;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    .search-button:active {
        transform: translateY(0);
    }

    .search-button.clear-btn {
        background: #7f8c8d !important;
        border: 2px solid #34495e !important;
    }

    .search-button.clear-btn:hover {
        background: #34495e !important;
    }

    /* Print Button Styles - Fixed width to match container */
    .print-btn-container {
        max-width: 1200px;
        width: 100%;
        margin: 0 auto 15px auto;
        display: flex;
        justify-content: flex-end;
    }

    .print-button {
        background: #27ae60 !important;
        color: white !important;
        border: none !important;
        padding: 12px 30px !important;
        border-radius: 8px !important;
        font-size: 16px !important;
        font-weight: bold !important;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
        border: 2px solid #229954 !important;
        font-family: 'Courier New', monospace;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        width: auto; /* Auto width based on content */
        min-width: 200px; /* Minimum width */
        justify-content: center; /* Center the text */
    }

    .print-button:hover {
        background: #229954 !important;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    .print-button i {
        font-size: 18px;
    }

    .print-button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
    }

    .search-stats {
        margin-top: 15px;
        padding: 10px;
        background: rgba(255, 255, 255, 0.2) !important;
        border-radius: 6px;
        color: #ffffff !important;
        font-size: 14px;
        text-align: center;
        border: 1px dashed #229954 !important;
    }

    /* Selected item highlight */
    .selected-item-highlight {
        background: #e67e22 !important;
        color: white !important;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 16px;
        font-weight: bold;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(230, 126, 34, 0.7);
        }
        70% {
            box-shadow: 0 0 0 10px rgba(230, 126, 34, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(230, 126, 34, 0);
        }
    }

    /* Contractor and Department badges */
    .contractor-badge {
        background: #3498db !important;
        color: white !important;
        padding: 3px 8px;
        border-radius: 12px;
        font-size: 12px;
        margin-left: 5px;
    }

    .department-badge {
        background: #27ae60 !important;
        color: white !important;
        padding: 3px 8px;
        border-radius: 12px;
        font-size: 12px;
        margin-left: 5px;
    }

    /* Bin Card Styles */
    .bin-card * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .bin-card {
        max-width: 1200px;
        width: 100%;
        background: #f8f4e9 !important;
        border: 4px solid #2c3e50 !important;
        border-radius: 12px !important;
        padding: 25px !important;
        box-shadow: 20px 20px 30px rgba(0, 0, 0, 0.3) !important;
        position: relative;
        background: linear-gradient(145deg, #fff9f0, #f4e9d8) !important;
        margin: 0 auto;
        font-family: 'Courier New', monospace;
    }

    .bin-card::before {
        content: '';
        position: absolute;
        top: 10px;
        left: 10px;
        right: 10px;
        bottom: 10px;
        border: 1px dashed #95a5a6;
        border-radius: 8px;
        pointer-events: none;
    }

    /* Updated Header Styles - Perfectly Centered */
    .bin-card .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding: 0 10px;
        border-bottom: 3px double #34495e;
        padding-bottom: 15px;
        position: relative;
        width: 100%;
    }

    .bin-card .header-left {
        flex: 0 0 auto;
        text-align: left;
        min-width: 100px;
    }

    .bin-card .header-center {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        white-space: nowrap;
    }

    .bin-card .header-right {
        flex: 0 0 auto;
        text-align: right;
        min-width: 100px;
        margin-left: auto;
    }

    .bin-card .header-left h3 {
        font-size: 24px !important;
        font-weight: 600 !important;
        color: #2c3e50 !important;
        margin: 0 !important;
        padding: 0 !important;
        text-transform: uppercase;
        letter-spacing: 2px;
        background: none;
        border: none;
        line-height: 1.2;
    }

    .bin-card .header-center h1 {
        font-size: 42px !important;
        font-weight: 800 !important;
        letter-spacing: 4px;
        color: #2c3e50 !important;
        text-shadow: 2px 2px 0 #bdc3c7;
        margin: 0 !important;
        padding: 0 !important;
        line-height: 1.2;
        background: none;
        border: none;
    }

    /* Store Badge - No background, No border */
    .bin-card .store-badge {
        background: none !important;
        color: #2c3e50 !important;
        padding: 8px 15px !important;
        font-size: 18px !important;
        font-weight: bold !important;
        display: inline-block;
        border: none !important; /* Removed border */
        white-space: nowrap;
    }

    /* Updated Info Grid - Single Column Layout */
    .bin-card .info-grid {
        display: flex;
        flex-direction: column;
        gap: 20px;
        margin-bottom: 25px;
        padding: 15px;
        background: rgba(255, 255, 255, 0.7) !important;
        border: 2px solid #7f8c8d !important;
        border-radius: 10px !important;
        position: relative;
    }

    .bin-card .info-row {
        display: flex;
        flex-direction: row;
        gap: 20px;
        align-items: flex-start;
        flex-wrap: wrap;
    }

    .bin-card .info-item {
        display: flex;
        flex-direction: column;
        flex: 1;
        min-width: 150px;
    }

    .bin-card .info-label {
        font-size: 14px !important;
        font-weight: bold !important;
        color: #7f8c8d !important;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 5px;
    }

    .bin-card .info-value {
        font-size: 20px !important;
        font-weight: 600 !important;
        color: #2c3e50 !important;
        border-bottom: 2px dotted #bdc3c7;
        padding: 5px 0;
        min-width: 150px;
        background: none !important;
        transition: all 0.3s ease;
    }

    /* Removed item-selected background - only border-bottom remains */
    .bin-card .info-value.item-selected {
        background: none !important;
        color: #2c3e50 !important;
        padding: 5px 0 !important;
        border-bottom: 2px dotted #bdc3c7 !important;
        font-size: 20px !important;
        transform: none !important;
        box-shadow: none !important;
        width: auto !important;
        min-width: 150px !important;
        max-width: none !important;
        text-align: left;
        margin-left: 0;
        margin-right: auto;
    }

    .bin-card .info-value .no-item-message {
        font-size: 12px;
        color: #e67e22;
        display: block;
        margin-top: 5px;
        font-style: italic;
    }

    /* DPL Reference - No background, No border */
    .bin-card .dpl-reference {
        background: none !important;
        color: #2c3e50 !important;
        padding: 8px 20px !important;
        font-weight: bold !important;
        font-size: 18px !important;
        text-align: center;
        border: none !important; /* Removed border */
        min-width: 150px;
        align-self: flex-start;
        margin-left: 0;
        width: auto;
        display: inline-block;
    }

    .bin-card .table-container {
        margin: 20px 0;
        overflow-x: auto;
        border: 3px solid #34495e !important;
        border-radius: 8px !important;
    }

    .bin-card table {
        width: 100%;
        border-collapse: collapse;
        font-size: 16px;
        background: white;
        table-layout: fixed; /* Added for better column control */
    }

    /* Updated Table Column Widths */
    .bin-card th, .bin-card td {
        padding: 12px 8px !important;
        text-align: center;
        vertical-align: middle;
        word-wrap: break-word; /* Allow text to wrap */
    }

    /* Specific column width allocations */
    .bin-card th:nth-child(1), .bin-card td:nth-child(1) { width: 12%; } /* Date */
    .bin-card th:nth-child(2), .bin-card td:nth-child(2) { width: 12%; } /* S.I.V/S.R.V No */
    .bin-card th:nth-child(3), .bin-card td:nth-child(3) { width: 20%; } /* Movement */
    .bin-card th:nth-child(4), .bin-card td:nth-child(4) { width: 8%; }  /* Received */
    .bin-card th:nth-child(5), .bin-card td:nth-child(5) { width: 8%; }  /* Issued */
    .bin-card th:nth-child(6), .bin-card td:nth-child(6) { width: 10%; } /* Balance */
    .bin-card th:nth-child(7), .bin-card td:nth-child(7) { width: 30%; } /* Signature - Increased width */

    /* Table Header Styles - Bin Card Background */
    .bin-card th {
        background: linear-gradient(145deg, #fff9f0, #f4e9d8) !important;
        color: #2c3e50 !important;
        padding: 15px 8px !important;
        font-weight: 800 !important;
        text-transform: uppercase;
        letter-spacing: 1px;
        border: 2px solid #34495e !important;
        font-size: 16px !important;
        vertical-align: middle;
        text-shadow: 1px 1px 0 rgba(255, 255, 255, 0.5);
    }

    /* Table Data Styles - Same as Header Background */
    .bin-card td {
        background: linear-gradient(145deg, #fff9f0, #f4e9d8) !important;
        color: #2c3e50 !important;
        padding: 12px 8px !important;
        border: 1px solid #95a5a6 !important;
        font-weight: 500;
        text-shadow: 1px 1px 0 rgba(255, 255, 255, 0.3);
    }

    /* Alternating row colors - Slightly darker for even rows */
    .bin-card tr:nth-child(even) td {
        background: linear-gradient(145deg, #f4e9d8, #f0e4d0) !important;
    }

    /* Hover effect */
    .bin-card tr:hover td {
        background: #f39c12 !important;
        color: white !important;
        transition: all 0.2s ease;
        cursor: pointer;
        text-shadow: none;
    }

    .bin-card .movement-in {
        color: #27ae60 !important;
        font-weight: bold;
    }

    .bin-card .movement-out {
        color: #e74c3c !important;
        font-weight: bold;
    }

    /* Balance column - using same background as other cells, no extra background */
    .bin-card .balance {
        font-weight: 800 !important;
        /* Removed background property to use the cell's default background */
        /* Removed border-radius to keep consistent with other cells */
    }

    .bin-card .contractor-cell {
        font-weight: 600;
        color: #2980b9;
        text-align: left !important; /* Left align movement text */
        padding-left: 15px !important;
    }

    .bin-card .signature-cell {
        font-style: italic;
        text-align: left !important; /* Left align signature */
        padding-left: 15px !important;
    }

    .bin-card .footer-note {
        margin-top: 25px;
        padding: 15px;
        background: #ecf0f1 !important;
        border-left: 10px solid #e67e22 !important;
        font-family: 'Courier New', monospace;
        font-size: 18px !important;
        font-weight: bold !important;
        color: #2c3e50 !important;
        border-radius: 0 10px 10px 0;
        text-align: right;
        border: 2px dashed #95a5a6 !important;
    }

    .bin-card .stamp-effect {
        position: relative;
        display: inline-block;
        background: #e67e22 !important;
        color: white !important;
        padding: 5px 15px !important;
        border-radius: 20px !important;
        transform: rotate(-2deg);
        font-size: 14px !important;
        opacity: 0.9;
    }

    .no-data-message {
        text-align: center;
        padding: 40px !important;
        background: #f8d7da !important;
        color: #721c24 !important;
        font-size: 18px !important;
        font-weight: bold;
    }

    .stacked-item {
        display: flex;
        flex-direction: column;
        gap: 10px;
        width: 100%;
    }

    /* Print Styles - Keep exact same layout as normal display */
    @media print {
        /* Hide elements not needed for printing */
        .search-section-wrapper,
        .print-btn-container,
        .sidebar,
        .navbar,
        footer,
        .search-stats {
            display: none !important;
        }

        /* Ensure content starts on first page */
        @page {
            margin: 1.5cm;
            size: auto;
        }

        /* Remove any page break before the bin card */
        .bin-card {
            page-break-before: avoid !important;
            page-break-after: avoid !important;
            page-break-inside: avoid !important;
            margin-top: 0 !important;
            padding-top: 20px !important;
        }

        /* Ensure the container starts at the top of the page */
        .row {
            margin-top: 0 !important;
            padding-top: 0 !important;
        }

        .col-md-12 {
            margin-top: 0 !important;
            padding-top: 0 !important;
        }

        /* Remove any potential margin/padding that could cause blank page */
        body {
            margin: 0 !important;
            padding: 0 !important;
            background: white;
        }

        /* Keep bin card exactly as displayed */
        .bin-card {
            border: 4px solid #2c3e50 !important;
            box-shadow: none !important;
            padding: 20px !important;
            background: #f8f4e9 !important;
            background: linear-gradient(145deg, #fff9f0, #f4e9d8) !important;
            max-width: 100% !important;
            margin: 0 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .bin-card::before {
            border: 1px dashed #95a5a6 !important;
        }

        /* Keep all info values exactly as displayed - no backgrounds */
        .bin-card .info-value {
            font-size: 20px !important;
            font-weight: 600 !important;
            color: #2c3e50 !important;
            border-bottom: 2px dotted #bdc3c7 !important;
            padding: 5px 0 !important;
            background: none !important;
            transform: none !important;
            box-shadow: none !important;
            width: auto !important;
            max-width: none !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* Keep selected item highlight with no background */
        .bin-card .info-value.item-selected {
            background: none !important;
            color: #2c3e50 !important;
            padding: 5px 0 !important;
            border-bottom: 2px dotted #bdc3c7 !important;
            font-size: 20px !important;
            width: auto !important;
            min-width: 150px !important;
            max-width: none !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* Keep header styles exactly as displayed */
        .bin-card .header-left h3 {
            font-size: 24px !important;
            font-weight: 600 !important;
            color: #2c3e50 !important;
            text-transform: uppercase !important;
            letter-spacing: 2px !important;
        }

        .bin-card .header-center h1 {
            font-size: 42px !important;
            font-weight: 800 !important;
            letter-spacing: 4px !important;
            color: #2c3e50 !important;
            text-shadow: 2px 2px 0 #bdc3c7 !important;
        }

        /* Store badge with no background and no border in print */
        .bin-card .store-badge {
            background: none !important;
            color: #2c3e50 !important;
            padding: 8px 15px !important;
            font-size: 18px !important;
            font-weight: bold !important;
            border: none !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* Keep info grid exactly as displayed */
        .bin-card .info-grid {
            background: rgba(255, 255, 255, 0.7) !important;
            border: 2px solid #7f8c8d !important;
            border-radius: 10px !important;
            padding: 15px !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .bin-card .info-label {
            font-size: 14px !important;
            font-weight: bold !important;
            color: #7f8c8d !important;
            text-transform: uppercase !important;
            letter-spacing: 1px !important;
            margin-bottom: 5px !important;
        }

        /* DPL reference with no background and no border in print */
        .bin-card .dpl-reference {
            background: none !important;
            color: #2c3e50 !important;
            padding: 8px 20px !important;
            font-weight: bold !important;
            font-size: 18px !important;
            border: none !important;
            min-width: 150px !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* Table styles for print - Maintain column widths */
        .bin-card table {
            table-layout: fixed !important;
            width: 100% !important;
        }

        /* Keep table headers exactly as displayed */
        .bin-card th {
            background: linear-gradient(145deg, #fff9f0, #f4e9d8) !important;
            color: #2c3e50 !important;
            padding: 15px 8px !important;
            font-weight: 800 !important;
            text-transform: uppercase !important;
            border: 2px solid #34495e !important;
            text-shadow: 1px 1px 0 rgba(255, 255, 255, 0.5) !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* Keep table data cells with same background as headers */
        .bin-card td {
            background: linear-gradient(145deg, #fff9f0, #f4e9d8) !important;
            color: #2c3e50 !important;
            padding: 12px 8px !important;
            border: 1px solid #95a5a6 !important;
            text-shadow: 1px 1px 0 rgba(255, 255, 255, 0.3) !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .bin-card tr:nth-child(even) td {
            background: linear-gradient(145deg, #f4e9d8, #f0e4d0) !important;
        }

        /* Balance column in print - using same background as other cells */
        .bin-card .balance {
            font-weight: 800 !important;
            /* No extra background - uses cell background */
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* ADJUSTED COLUMN WIDTHS FOR PRINT ONLY */
        /* Reduced movement column width from 20% to 15% */
        .bin-card th:nth-child(3), .bin-card td:nth-child(3) { 
            width: 15% !important; 
        }
        
        /* Increased received and issued columns width from 8% to 10% */
        .bin-card th:nth-child(4), .bin-card td:nth-child(4),
        .bin-card th:nth-child(5), .bin-card td:nth-child(5) { 
            width: 10% !important; 
        }
        
        /* Maintain other column widths with slight adjustments */
        .bin-card th:nth-child(1), .bin-card td:nth-child(1) { width: 12% !important; } /* Date */
        .bin-card th:nth-child(2), .bin-card td:nth-child(2) { width: 12% !important; } /* S.I.V/S.R.V No */
        .bin-card th:nth-child(6), .bin-card td:nth-child(6) { width: 11% !important; } /* Balance - slightly increased */
        .bin-card th:nth-child(7), .bin-card td:nth-child(7) { width: 30% !important; } /* Signature */

        /* Ensure signature cell has enough space */
        .bin-card td:nth-child(7) {
            text-align: left !important;
            padding-left: 15px !important;
            font-style: italic !important;
        }

        /* Keep movement colors exactly as displayed */
        .movement-in {
            color: #27ae60 !important;
            font-weight: bold !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .movement-out {
            color: #e74c3c !important;
            font-weight: bold !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* Keep contractor cell alignment */
        .contractor-cell {
            text-align: left !important;
            padding-left: 15px !important;
        }

        /* Keep badges exactly as displayed */
        .contractor-badge, .department-badge {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* Keep footer note exactly as displayed */
        .bin-card .footer-note {
            background: #ecf0f1 !important;
            border-left: 10px solid #e67e22 !important;
            border: 2px dashed #95a5a6 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* Ensure full width in print */
        .col-md-12 {
            width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        .row {
            margin: 0 !important;
            padding: 0 !important;
        }
    }

    /* Responsive adjustments */
    @media (max-width: 992px) {
        .search-group {
            min-width: 250px;
        }
        
        .bin-card .info-row {
            flex-wrap: wrap;
        }
        
        .bin-card .info-item,
        .bin-card .dpl-reference {
            min-width: 200px;
        }
    }

    @media (max-width: 768px) {
        .search-section {
            flex-direction: column;
            align-items: stretch;
        }
        
        .search-group {
            min-width: auto;
        }
        
        .search-button {
            width: 100%;
        }
        
        .print-btn-container {
            justify-content: center;
        }
        
        .print-button {
            width: 100%;
            max-width: 300px;
        }
        
        .bin-card .header {
            flex-wrap: wrap;
            gap: 10px;
            position: relative;
            min-height: 100px;
        }
        
        .bin-card .header-left,
        .bin-card .header-right {
            flex: 1;
            min-width: auto;
        }
        
        .bin-card .header-center {
            position: static;
            transform: none;
            width: 100%;
            order: -1;
            margin-bottom: 10px;
            text-align: center;
        }
        
        .bin-card .header-center h1 {
            font-size: 32px !important;
        }
        
        .bin-card .header-left h3 {
            font-size: 20px !important;
        }
        
        .bin-card .info-row {
            flex-direction: column;
        }
        
        .bin-card .info-item,
        .bin-card .dpl-reference {
            width: 100%;
        }
    }
</style>

<div class="row">
    <div class="col-md-12">
        <!-- Search Section with Only Item Dropdown - Always Visible -->
        <div class="search-section-wrapper">
            <form method="GET" action="{{ url()->current() }}" id="searchForm">
                <div class="search-section">
                    <div class="search-group">
                        <label class="search-label">📦 Select Product</label>
                        <select class="search-select" name="item_id" id="searchItem">
                            <option value="">-- Select Product --</option>
                            @foreach($items as $item)
                                <option value="{{ $item->itemID }}" data-name="{{ $item->item }}" {{ request('item_id') == $item->itemID ? 'selected' : '' }}>
                                    {{ $item->item }}
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="item_name" id="itemName" value="{{ request('item_name') }}">
                    </div>
                    
                    <a href="{{ url()->current() }}" class="search-button clear-btn">Clear Selection</a>
                </div>
                
                <div class="search-stats" id="searchStats">
                    @if(count($binCardData['entries']) > 0)
                        📊 Showing {{ count($binCardData['entries']) }} records for <strong>{{ $binCardData['product'] }}</strong>
                    @elseif($binCardData['product_id'])
                        📊 No records found for <strong>{{ $binCardData['product'] }}</strong>
                    @else
                        📊 Please select an item to view records
                    @endif
                </div>
            </form>
        </div>

        <!-- Bin Card - Only displayed when an item is selected -->
        @if($binCardData['product_id'])
        <!-- Print Button - Now with same width constraints as search section -->
        <div class="print-btn-container">
            <button class="print-button" onclick="handlePrintClick(event)">
                <i>🖨️</i> Print Bin Card
            </button>
        </div>

        <div class="bin-card" id="binCard">
            <div class="header">
                <div class="header-left">
                    <h3>Nigeria</h3>
                </div>
                <div class="header-center">
                    <h1>BIN CARD</h1>
                </div>
                <div class="header-right">
                    <span class="store-badge">Stores {{ $binCardData['store'] }}</span>
                </div>
            </div>

            <!-- Single Column Info Grid -->
            <div class="info-grid">
                <!-- First Row - ITEM and UNIT OF ISSUE -->
                <div class="info-row">
                    <div class="info-item">
                        <span class="info-label">PRODUCT</span>
                        <span class="info-value" id="displayItem">
                            {{ $binCardData['product_with_specs'] }}
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">UNIT OF ISSUE</span>
                        <span class="info-value"></span>
                    </div>
                </div>

                <!-- Second Row - LEDGER FOLIO, PACK and MINIMUM STOCK on one line -->
                <div class="info-row">
                    <div class="info-item">
                        <span class="info-label">LEDGER FOLIO</span>
                        <span class="info-value"></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">PACK</span>
                        <span class="info-value"></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">MINIMUM STOCK</span>
                        <span class="info-value"></span>
                    </div>
                </div>

                <!-- DPL/PWO directly below MINIMUM STOCK (aligned under it) -->
                <div style="display: flex; flex-direction: row; gap: 20px; margin-top: -10px; margin-left: calc(66.67% + 20px);">
                    <div class="dpl-reference">
                        DPL/PWO
                    </div>
                </div>
            </div>

            <div class="table-container">
                <table id="binCardTable">
                    <thead>
                        <tr>
                            <th style="text-align: center">Date <br> Issue Receipt</th>
                            <th style="text-align: center">S.I.V No <br> or <br> S.R.V No</th>
                            <th style="text-align: center">Movement</th>
                            <th colspan="2" style="text-align: center">QUANTITY</th>
                            <th style="text-align: center">Balance</th>
                            <th style="text-align: center">Signature</th>
                        </tr>
                        <tr>
                            <th colspan="3"></th>
                            <th>Received</th>
                            <th>Issued</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @forelse($binCardData['entries'] as $entry)
                        <tr>
                            <td><strong>{{ $entry['date'] }}</strong></td>
                            <td>{{ $entry['reference'] }}</td>
                            <td class="contractor-cell">
                                {{ $entry['movement'] }}
                                @if($entry['movement_type'] == 'department')
                                    <span class="department-badge">Dept</span>
                                @elseif($entry['movement_type'] == 'contractor' && $entry['movement'] != 'N/A')
                                @endif
                            </td>
                            <td class="movement-in">{{ $entry['received'] > 0 ? $entry['received'] : '-' }}</td>
                            <td class="movement-out">{{ $entry['issued'] > 0 ? $entry['issued'] : '-' }}</td>
                            <td class="balance">{{ $entry['balance'] }}</td>
                            <td class="signature-cell">{{ $entry['signature'] }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="no-data-message">
                                🔍 No transactions found for <strong>{{ $binCardData['product'] }}</strong>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 20px; font-size: 12px; color: #7f8c8d; text-align: center;">
                <span>Generated: {{ now()->format('d/m/Y H:i:s') }}</span>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
// Global flag to prevent multiple print dialogs
let isPrinting = false;

// Fix for dropdown selection issue
document.addEventListener('DOMContentLoaded', function() {
    const searchItem = document.getElementById('searchItem');
    const searchForm = document.getElementById('searchForm');
    const itemName = document.getElementById('itemName');
    
    if (searchItem) {
        // Remove the onchange attribute from HTML and handle with JavaScript
        searchItem.removeAttribute('onchange');
        
        // Add change event listener
        searchItem.addEventListener('change', function(e) {
            // Get the selected option
            const selectedOption = this.options[this.selectedIndex];
            const selectedValue = this.value;
            const selectedName = selectedOption.getAttribute('data-name') || '';
            
            // Update hidden input
            if (itemName) {
                itemName.value = selectedName;
            }
            
            // Only submit if a valid item is selected (not the placeholder)
            if (selectedValue && selectedValue !== '') {
                // Add a small delay to ensure all data is set
                setTimeout(function() {
                    searchForm.submit();
                }, 100);
            }
        });
        
        // Fix for page load - ensure the selected value matches URL parameter
        const urlParams = new URLSearchParams(window.location.search);
        const selectedItemId = urlParams.get('item_id');
        
        if (selectedItemId && searchItem.value !== selectedItemId) {
            searchItem.value = selectedItemId;
            
            // Trigger change event to update hidden input
            const event = new Event('change', { bubbles: true });
            searchItem.dispatchEvent(event);
        }
    }

    // Handle print event after print dialog closes
    window.addEventListener('afterprint', function() {
        // Reset printing flag when print dialog is closed
        isPrinting = false;
        
        // Re-enable print button if it was disabled
        const printButton = document.querySelector('.print-button');
        if (printButton) {
            printButton.disabled = false;
            printButton.style.opacity = '1';
            printButton.style.cursor = 'pointer';
        }
    });

    // Handle before print event
    window.addEventListener('beforeprint', function() {
        // Optional: Do something just before printing
    });
});

// Separate function for print handling to avoid event issues
function handlePrintClick(event) {
    event.preventDefault();
    event.stopPropagation();
    
    // Check if already printing
    if (isPrinting) {
        return;
    }
    
    // Set printing flag
    isPrinting = true;
    
    // Disable print button to prevent multiple clicks
    const printButton = event.currentTarget;
    printButton.disabled = true;
    printButton.style.opacity = '0.5';
    printButton.style.cursor = 'not-allowed';
    
    // Trigger print with a small delay to ensure flag is set
    setTimeout(function() {
        window.print();
    }, 100);
    
    // Safety timeout to reset flag if afterprint doesn't fire
    setTimeout(function() {
        if (isPrinting) {
            isPrinting = false;
            printButton.disabled = false;
            printButton.style.opacity = '1';
            printButton.style.cursor = 'pointer';
        }
    }, 5000); // Reset after 5 seconds as fallback
}

// Update hidden item name field when selection changes (backup)
document.getElementById('searchItem')?.addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const itemName = selectedOption.getAttribute('data-name') || '';
    document.getElementById('itemName').value = itemName;
});

// Initialize on page load
window.onload = function() {
    // Check if there's a preselected item from request
    const itemSelect = document.getElementById('searchItem');
    const itemName = document.getElementById('itemName');
    
    if (itemSelect && itemSelect.value) {
        const selectedOption = itemSelect.options[itemSelect.selectedIndex];
        const selectedName = selectedOption.getAttribute('data-name') || '';
        if (itemName) {
            itemName.value = selectedName;
        }
    }
    
    // Reset printing flag on page load
    isPrinting = false;
};

// Handle keyboard shortcut (Ctrl+P)
document.addEventListener('keydown', function(e) {
    // Check if Ctrl+P is pressed and we're not already in a print operation
    if (e.ctrlKey && e.key === 'p') {
        // Check if there's a print button (meaning an item is selected)
        const printButton = document.querySelector('.print-button');
        if (printButton && !isPrinting) {
            e.preventDefault();
            
            // Set flag to prevent multiple prints
            isPrinting = true;
            
            // Disable print button
            printButton.disabled = true;
            printButton.style.opacity = '0.5';
            printButton.style.cursor = 'not-allowed';
            
            // Trigger print
            setTimeout(function() {
                window.print();
            }, 100);
            
            // Safety timeout
            setTimeout(function() {
                if (isPrinting) {
                    isPrinting = false;
                    printButton.disabled = false;
                    printButton.style.opacity = '1';
                    printButton.style.cursor = 'pointer';
                }
            }, 5000);
        }
    }
});
</script>

@endsection