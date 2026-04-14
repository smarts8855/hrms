@extends('layouts_procurement.app')
@section('pageTitle', 'Bin Card by Category')
@section('pageMenu', 'active')
@section('content')

<style>
    /* Search Section Styles - Green background as in your bin card */
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

    /* Print Button Styles - Green background as in your bin card */
    .print-button-container {
        max-width: 1200px;
        width: 100%;
        margin: 0 auto 15px auto;
        display: flex;
        justify-content: flex-end;
    }

    .print-button {
        background: #27ae60 !important;
        color: white !important;
        border: 2px solid #229954 !important;
        padding: 10px 25px !important;
        border-radius: 8px !important;
        font-size: 16px !important;
        font-weight: bold !important;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-family: 'Courier New', monospace;
        display: inline-flex;
        align-items: center;
        gap: 8px;
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

    /* Store Badge - No background, No border as in your bin card */
    .bin-card .store-badge {
        background: none !important;
        color: #2c3e50 !important;
        padding: 8px 15px !important;
        font-size: 18px !important;
        font-weight: bold !important;
        display: inline-block;
        border: none !important;
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
        background: none;
        transition: all 0.3s ease;
    }

    /* Remove background from category value */
    .bin-card .info-value.no-background {
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

    .bin-card .info-value.item-selected {
        background: #e67e22 !important;
        color: white !important;
        padding: 8px 15px !important;
        border-radius: 8px !important;
        border-bottom: none !important;
        font-size: 22px !important;
        transform: scale(1.05);
        box-shadow: 0 5px 15px rgba(230, 126, 34, 0.4);
        width: 50%;
        min-width: 150px;
        max-width: 300px;
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

    /* Remove background from DPL/PWO */
    .bin-card .dpl-reference.no-background {
        background: none !important;
        color: #2c3e50 !important;
        padding: 8px 20px !important;
        font-weight: bold !important;
        font-size: 18px !important;
        text-align: center;
        border: none !important;
        min-width: 150px;
        align-self: flex-start;
        margin-left: 0;
        width: auto;
        display: inline-block;
    }

    .bin-card .dpl-reference {
        background: #e67e22 !important;
        color: white !important;
        padding: 8px 20px !important;
        border-radius: 25px !important;
        font-weight: bold !important;
        font-size: 18px !important;
        text-align: center;
        border: none;
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
        table-layout: fixed;
    }

    /* Table Column Widths - Updated for Reference column (reduced) and QUANTITY (increased) */
    .bin-card th:nth-child(1), .bin-card td:nth-child(1) { width: 15%; } /* Item */
    .bin-card th:nth-child(2), .bin-card td:nth-child(2) { width: 10%; } /* Date */
    .bin-card th:nth-child(3), .bin-card td:nth-child(3) { width: 10%; } /* S.I.V/S.R.V No - REDUCED from 15% to 10% */
    .bin-card th:nth-child(4), .bin-card td:nth-child(4) { width: 20%; } /* Movement */
    .bin-card th:nth-child(5), .bin-card td:nth-child(5) { width: 10%; } /* Received - INCREASED from 8% to 10% */
    .bin-card th:nth-child(6), .bin-card td:nth-child(6) { width: 10%; } /* Issued - INCREASED from 8% to 10% */
    .bin-card th:nth-child(7), .bin-card td:nth-child(7) { width: 10%; } /* Balance - INCREASED from 10% to 10% (maintained) */
    .bin-card th:nth-child(8), .bin-card td:nth-child(8) { width: 15%; } /* Signature - INCREASED from 14% to 15% */

    /* Table Header Styles - Bin Card Background as in your bin card */
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

    /* Table Data Styles - Same as Header Background as in your bin card */
    .bin-card td {
        background: linear-gradient(145deg, #fff9f0, #f4e9d8) !important;
        color: #2c3e50 !important;
        padding: 12px 8px !important;
        border: 1px solid #95a5a6 !important;
        font-weight: 500;
        vertical-align: middle;
        text-shadow: 1px 1px 0 rgba(255, 255, 255, 0.3);
    }

    /* Alternating row colors - Slightly darker for even rows */
    .bin-card tr:nth-child(even) td {
        background: linear-gradient(145deg, #f4e9d8, #f0e4d0) !important;
    }

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

    .bin-card .balance {
        font-weight: 800 !important;
        /* No extra background - uses cell background */
    }

    .bin-card .contractor-cell {
        font-weight: 600;
        color: #2980b9;
        text-align: left !important;
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

    /* Items Summary Section */
    .items-summary {
        margin-bottom: 20px;
        padding: 15px;
        background: #ecf0f1;
        border-radius: 8px;
        border: 2px solid #7f8c8d;
    }

    .items-summary h4 {
        margin-bottom: 10px;
        color: #2c3e50;
        font-family: 'Courier New', monospace;
        font-weight: bold;
    }

    .items-summary .item-tag {
        background: white;
        padding: 8px 15px;
        border-radius: 20px;
        border: 1px solid #e67e22;
        display: inline-block;
        margin: 5px;
        font-family: 'Courier New', monospace;
    }

    .items-summary .item-tag strong {
        color: #2c3e50;
    }

    .items-summary .item-tag span {
        color: #e67e22;
        font-weight: bold;
    }

    /* Print Styles - COMPLETELY REWRITTEN FOR TABLE with updated column widths */
    @media print {
        /* Reset all visibility */
        body, html {
            background: white !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        
        /* Hide everything first */
        .search-section-wrapper,
        .print-button-container,
        .search-stats,
        .search-button,
        .clear-btn,
        .stamp-effect,
        .items-summary,
        .sidebar,
        .navbar,
        footer,
        .row > .col-md-12 > *:not(.bin-card) {
            display: none !important;
        }
        
        /* Show only the bin card */
        .bin-card {
            display: block !important;
            visibility: visible !important;
            position: relative !important;
            left: 0 !important;
            top: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            padding: 20px !important;
            border: 2px solid #000 !important;
            background: #f8f4e9 !important;
            box-shadow: none !important;
            page-break-after: avoid !important;
            page-break-before: avoid !important;
        }
        
        /* Force all bin card children to be visible */
        .bin-card * {
            visibility: visible !important;
            display: block !important;
        }
        
        /* Fix for flexbox elements */
        .bin-card .header,
        .bin-card .info-row {
            display: flex !important;
        }
        
        .bin-card .info-item {
            display: flex !important;
        }
        
        /* Table specific overrides - most important part */
        .bin-card .table-container {
            display: block !important;
            width: 100% !important;
            border: 2px solid #000 !important;
            overflow: visible !important;
            margin: 20px 0 !important;
        }
        
        .bin-card table {
            display: table !important;
            width: 100% !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
        }
        
        .bin-card thead {
            display: table-header-group !important;
        }
        
        .bin-card tbody {
            display: table-row-group !important;
        }
        
        .bin-card tr {
            display: table-row !important;
        }
        
        .bin-card td, 
        .bin-card th {
            display: table-cell !important;
            border: 1px solid #000 !important;
            padding: 8px 4px !important;
            text-align: center !important;
            vertical-align: middle !important;
            font-size: 12px !important;
            background: linear-gradient(145deg, #fff9f0, #f4e9d8) !important;
            color: #2c3e50 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        
        /* Ensure alternating row colors print */
        .bin-card tr:nth-child(even) td {
            background: linear-gradient(145deg, #f4e9d8, #f0e4d0) !important;
        }
        
        /* Keep column widths - UPDATED with reduced S.I.V/S.R.V No and increased QUANTITY */
        .bin-card th:nth-child(1), .bin-card td:nth-child(1) { width: 15% !important; } /* Item */
        .bin-card th:nth-child(2), .bin-card td:nth-child(2) { width: 10% !important; } /* Date */
        .bin-card th:nth-child(3), .bin-card td:nth-child(3) { width: 10% !important; } /* S.I.V/S.R.V No - REDUCED from 15% to 10% */
        .bin-card th:nth-child(4), .bin-card td:nth-child(4) { width: 20% !important; } /* Movement */
        .bin-card th:nth-child(5), .bin-card td:nth-child(5) { width: 10% !important; } /* Received - INCREASED from 8% to 10% */
        .bin-card th:nth-child(6), .bin-card td:nth-child(6) { width: 10% !important; } /* Issued - INCREASED from 8% to 10% */
        .bin-card th:nth-child(7), .bin-card td:nth-child(7) { width: 10% !important; } /* Balance - INCREASED from 10% to 10% (maintained) */
        .bin-card th:nth-child(8), .bin-card td:nth-child(8) { width: 15% !important; } /* Signature - INCREASED from 14% to 15% */
        
        /* Keep special text colors */
        .bin-card .movement-in {
            color: #27ae60 !important;
            font-weight: bold !important;
        }
        
        .bin-card .movement-out {
            color: #e74c3c !important;
            font-weight: bold !important;
        }
        
        .bin-card .contractor-cell {
            color: #2980b9 !important;
            text-align: left !important;
        }
        
        .bin-card .balance {
            font-weight: 800 !important;
        }
        
        /* Keep badge colors */
        .contractor-badge {
            background: #3498db !important;
            color: white !important;
            display: inline !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        
        .department-badge {
            background: #27ae60 !important;
            color: white !important;
            display: inline !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        
        /* No background elements */
        .bin-card .info-value.no-background,
        .bin-card .dpl-reference.no-background,
        .bin-card .store-badge {
            background: none !important;
            color: #2c3e50 !important;
            border: none !important;
        }
        
        /* Footer */
        .bin-card .footer-note {
            background: #ecf0f1 !important;
            border-left: 10px solid #e67e22 !important;
            border: 2px dashed #95a5a6 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
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
        
        .bin-card table {
            table-layout: auto;
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
        
        .print-button-container {
            justify-content: center;
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
        
        .bin-card table {
            font-size: 14px;
        }
        
        .bin-card th, .bin-card td {
            padding: 8px 5px !important;
        }
    }
</style>

<div class="row">
    <div class="col-md-12">
        <!-- Search Section with Store Item Category Dropdown - Green background -->
        <div class="search-section-wrapper">
            <form method="GET" action="{{ url()->current() }}" id="searchForm">
                <div class="search-section">
                    <div class="search-group">
                        <label class="search-label">📦 Select Store Item Category</label>
                        <select class="search-select" name="category_id" id="searchCategory">
                            <option value="">-- Select Category --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" data-name="{{ $category->storeItemCat }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->storeItemCat }}
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="category_name" id="categoryName" value="{{ request('category_name') }}">
                    </div>
                    
                    <a href="{{ url()->current() }}" class="search-button clear-btn">Clear Selection</a>
                </div>
                
                <div class="search-stats" id="searchStats">
                    @if(isset($binCardData['entries']) && count($binCardData['entries']) > 0)
                        📊 Showing {{ count($binCardData['entries']) }} transactions for <strong>{{ $binCardData['category'] ?? 'Selected Category' }}</strong>
                    @elseif(isset($binCardData['category_id']) && $binCardData['category_id'])
                        📊 No transactions found for <strong>{{ $binCardData['category'] ?? 'Selected Category' }}</strong>
                    @else
                        📊 Please select a category to view records
                    @endif
                </div>
            </form>
        </div>

        <!-- Bin Card - Only displayed when a category is selected -->
        @if(isset($binCardData['category_id']) && $binCardData['category_id'])
        <!-- Print Button - Green background -->
        <div class="print-button-container">
            <button class="print-button" onclick="printBinCard()">
                🖨️ Print Report
            </button>
        </div>
        
        <div class="bin-card" id="binCardToPrint">
            <div class="header">
                <div class="header-left">
                    <h3>Nigeria</h3>
                </div>
                <div class="header-center">
                    <h1>STORE ITEM CATEGORY</h1>
                </div>
                <div class="header-right">
                    <span class="store-badge">Stores {{ $binCardData['store'] ?? 'N/A' }}</span>
                </div>
            </div>

            <!-- Single Column Info Grid -->
            <div class="info-grid">
                <!-- First Row - Category and UNIT OF ISSUE -->
                <div class="info-row">
                    <div class="info-item">
                        <span class="info-label">CATEGORY</span>
                        <span class="info-value no-background" id="displayCategory">
                            {{ $binCardData['category'] ?? 'N/A' }}
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

                <!-- DPL/PWO directly below MINIMUM STOCK (aligned under it) with no background -->
                <div style="display: flex; flex-direction: row; gap: 20px; margin-top: -10px; margin-left: calc(66.67% + 20px);">
                    <div class="dpl-reference no-background">
                        DPL/PWO
                    </div>
                </div>
            </div>

            <!-- Summary of Items and Current Balances -->
            @if(isset($binCardData['items']) && count($binCardData['items']) > 0)
            <div class="items-summary">
                <h4>📦 Items in this Category:</h4>
                <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                    @foreach($binCardData['items'] as $item)
                    <div class="item-tag">
                        <strong>{{ $item['item_name'] ?? 'N/A' }}</strong>: 
                        <span>{{ $item['current_balance'] ?? 0 }}</span> units
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="table-container">
                <table id="binCardTable">
                    <thead>
                        <tr>
                            <th style="text-align: center">Item</th>
                            <th style="text-align: center">Date</th>
                            <th style="text-align: center">S.I.V No <br> or <br> S.R.V No</th>
                            <th style="text-align: center">Movement</th>
                            <th colspan="2" style="text-align: center">QUANTITY</th>
                            <th style="text-align: center">Balance</th>
                            <th style="text-align: center">Signature</th>
                        </tr>
                        <tr>
                            <th colspan="4"></th>
                            <th>Received</th>
                            <th>Issued</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @forelse($binCardData['entries'] ?? [] as $entry)
                        <tr>
                            <td><strong>{{ $entry['item_name'] ?? 'N/A' }}</strong></td>
                            <td>{{ $entry['date'] ?? 'N/A' }}</td>
                            <td>{{ $entry['reference'] ?? 'N/A' }}</td>
                            <td class="contractor-cell">
                                {{ $entry['movement'] ?? 'N/A' }}
                                @if(isset($entry['movement_type']) && $entry['movement_type'] == 'department')
                                    <span class="department-badge">Dept</span>
                                @elseif(isset($entry['movement_type']) && $entry['movement_type'] == 'contractor' && isset($entry['movement']) && $entry['movement'] != 'N/A')
                                @endif
                            </td>
                            <td class="movement-in">{{ isset($entry['received']) && $entry['received'] > 0 ? $entry['received'] : '-' }}</td>
                            <td class="movement-out">{{ isset($entry['issued']) && $entry['issued'] > 0 ? $entry['issued'] : '-' }}</td>
                            <td class="balance">{{ $entry['balance'] ?? 0 }}</td>
                            <td>{{ $entry['signature'] ?? 'N/A' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="no-data-message">
                                🔍 No transactions found for this category
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

// Enhanced print function
function printBinCard() {
    if (isPrinting) return;
    
    isPrinting = true;
    
    // Disable print button
    const printButton = document.querySelector('.print-button');
    if (printButton) {
        printButton.disabled = true;
        printButton.style.opacity = '0.5';
        printButton.style.cursor = 'not-allowed';
    }
    
    // Store the original title
    const originalTitle = document.title;
    
    // Set a print-friendly title
    document.title = `Bin Card - {{ $binCardData['category'] ?? 'Category' }}`;
    
    // Force a small delay to ensure any pending updates are applied
    setTimeout(function() {
        window.print();
    }, 250);
}

// Handle afterprint event
window.addEventListener('afterprint', function() {
    isPrinting = false;
    const printButton = document.querySelector('.print-button');
    if (printButton) {
        printButton.disabled = false;
        printButton.style.opacity = '1';
        printButton.style.cursor = 'pointer';
    }
    
    // Restore original title
    document.title = 'Bin Card by Category';
});

// Fix for dropdown selection issue
document.addEventListener('DOMContentLoaded', function() {
    const searchCategory = document.getElementById('searchCategory');
    const searchForm = document.getElementById('searchForm');
    const categoryName = document.getElementById('categoryName');
    
    if (searchCategory) {
        // Remove the onchange attribute if any
        searchCategory.removeAttribute('onchange');
        
        // Add change event listener
        searchCategory.addEventListener('change', function(e) {
            // Get the selected option
            const selectedOption = this.options[this.selectedIndex];
            const selectedValue = this.value;
            const selectedName = selectedOption.getAttribute('data-name') || '';
            
            // Update hidden input
            if (categoryName) {
                categoryName.value = selectedName;
            }
            
            // Only submit if a valid category is selected (not the placeholder)
            if (selectedValue && selectedValue !== '') {
                // Add a small delay to ensure all data is set
                setTimeout(function() {
                    searchForm.submit();
                }, 100);
            }
        });
        
        // Fix for page load - ensure the selected value matches URL parameter
        const urlParams = new URLSearchParams(window.location.search);
        const selectedCategoryId = urlParams.get('category_id');
        
        if (selectedCategoryId && searchCategory.value !== selectedCategoryId) {
            searchCategory.value = selectedCategoryId;
            
            // Trigger change event to update hidden input
            const event = new Event('change', { bubbles: true });
            searchCategory.dispatchEvent(event);
        }
    }
});

// Update hidden category name field when selection changes (backup)
document.getElementById('searchCategory')?.addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const categoryName = selectedOption.getAttribute('data-name') || '';
    document.getElementById('categoryName').value = categoryName;
});

// Initialize on page load
window.onload = function() {
    // Check if there's a preselected category from request
    const categorySelect = document.getElementById('searchCategory');
    const categoryName = document.getElementById('categoryName');
    
    if (categorySelect && categorySelect.value) {
        const selectedOption = categorySelect.options[categorySelect.selectedIndex];
        const selectedName = selectedOption.getAttribute('data-name') || '';
        if (categoryName) {
            categoryName.value = selectedName;
        }
    }
    
    // Reset printing flag
    isPrinting = false;
};

// Handle keyboard shortcut for printing (Ctrl+P)
document.addEventListener('keydown', function(e) {
    if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
        const printButton = document.querySelector('.print-button');
        if (printButton && !isPrinting) {
            e.preventDefault();
            printBinCard();
        }
    }
});
</script>

@endsection