<!DOCTYPE html>
<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,700&family=Plus+Jakarta+Sans:wght@500;600;700;800&family=JetBrains+Mono:wght@100;200;400&display=swap" rel="stylesheet">    
    <title>IskoLib - Book Catalog</title>
</head>
<body>
    <div class="layout-container">
        @include('common.sidebarAdmin')
        <main class="main-canvas">
            
            <div class="dashboard-header">
                <h1 class="dashboard-title">Book Catalog</h1>
                <div class="profile-avatar">LA</div>
            </div>

            <div class="canvas-content">

                <div class="control-row-container">
                    <div class="control-row">
                        <div class="search-box-wrapper">
                            <i class="bi bi-search"></i>
                            <input type="text" class="search-input" placeholder="Search books...">
                        </div>

                        <div class="dropdown-wrapper">
                            <select class="custom-filter-dropdown">
                                <option value="all" selected>Select Category</option>
                                <option value="programming">Programming</option>
                                <option value="networking">Networking</option>
                                <option value="database">Database</option>
                                <option value="ai">Artificial Intelligence</option>
                                <option value="cybersecurity">Cybersecurity</option>
                                <option value="research">Research</option>
                            </select>
                        </div>

                        <div class="dropdown-wrapper">
                            <select class="custom-filter-dropdown">
                                <option value="all" selected>Status</option>
                                <option value="available">Available</option>
                                <option value="unavailable">Unavailable</option>
                            </select>
                        </div>

                        <button class="btn-export">
                            <img src="{{ asset('AdminAssets/CatalogAssets/downloadIcon.svg') }}" alt="Export Icon" class="btn-icon-svg">
                            <span>Export</span>
                        </button>
                    </div>
                </div>

                <div class="action-strip">
                    <button class="btn-add-book">
                        <span class="btn-plus-symbol">&#43;</span> Add New Book
                    </button>
                </div>

                <div class="catalog-panel">
                    <table class="catalog-data-table">
                        <thead>
                            <tr>
                                <th style="width: 80px;">ID</th>
                                <th>TITLE</th>
                                <th>AUTHOR</th>
                                <th>CATEGORY</th>
                                <th>STATUS</th>
                                <th style="width: 100px; text-align: center;">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="mono-text">#0001</td>
                                <td>
                                    <div class="book-title-cell">
                                        <img src="{{ asset('AdminAssets/CatalogAssets/blueBookIcon.svg') }}" alt="Book" class="table-book-icon">
                                        <span>Introduction to Artificial Intelligence</span>
                                    </div>
                                </td>
                                <td>Stuart Russell</td>
                                <td><span class="cat-badge badge-blue">AI</span></td>
                                <td><span class="status-badge badge-success">Available</span></td>
                                <td class="actions-cell-row">
                                    <button class="action-btn-edit"><img src="{{ asset('AdminAssets/CatalogAssets/editIcon.svg') }}" alt="Edit"></button>
                                    <button class="action-btn-delete"><img src="{{ asset('AdminAssets/CatalogAssets/deleteIcon.svg') }}" alt="Delete"></button>
                                </td>
                            </tr>
                            <tr>
                                <td class="mono-text">#0002</td>
                                <td>
                                    <div class="book-title-cell">
                                        <img src="{{ asset('AdminAssets/CatalogAssets/orangeBookIcon.svg') }}" alt="Book" class="table-book-icon">
                                        <span>Clean Code: A Handbook of Agile Software Craftsmanship</span>
                                    </div>
                                </td>
                                <td>Robert C. Martin</td>
                                <td><span class="cat-badge badge-light-blue">Programming</span></td>
                                <td><span class="status-badge badge-success">Available</span></td>
                                <td class="actions-cell-row">
                                    <button class="action-btn-edit"><img src="{{ asset('AdminAssets/CatalogAssets/editIcon.svg') }}" alt="Edit"></button>
                                    <button class="action-btn-delete"><img src="{{ asset('AdminAssets/CatalogAssets/deleteIcon.svg') }}" alt="Delete"></button>
                                </td>
                            </tr>
                            <tr>
                                <td class="mono-text">#0003</td>
                                <td>
                                    <div class="book-title-cell">
                                        <img src="{{ asset('AdminAssets/CatalogAssets/purpleBookIcon.svg') }}" alt="Book" class="table-book-icon">
                                        <span>Computer Networks</span>
                                    </div>
                                </td>
                                <td>Andrew S. Tanenbaum</td>
                                <td><span class="cat-badge badge-medium-blue">Networking</span></td>
                                <td><span class="status-badge badge-success">Available</span></td>
                                <td class="actions-cell-row">
                                    <button class="action-btn-edit"><img src="{{ asset('AdminAssets/CatalogAssets/editIcon.svg') }}" alt="Edit"></button>
                                    <button class="action-btn-delete"><img src="{{ asset('AdminAssets/CatalogAssets/deleteIcon.svg') }}" alt="Delete"></button>
                                </td>
                            </tr>
                            <tr>
                                <td class="mono-text">#0004</td>
                                <td>
                                    <div class="book-title-cell">
                                        <img src="{{ asset('AdminAssets/CatalogAssets/greenBookIcon.svg') }}" alt="Book" class="table-book-icon">
                                        <span>Database System Concepts</span>
                                    </div>
                                </td>
                                <td>Abraham Silberschatz</td>
                                <td><span class="cat-badge badge-dark-blue">Database</span></td>
                                <td><span class="status-badge badge-success">Available</span></td>
                                <td class="actions-cell-row">
                                    <button class="action-btn-edit"><img src="{{ asset('AdminAssets/CatalogAssets/editIcon.svg') }}" alt="Edit"></button>
                                    <button class="action-btn-delete"><img src="{{ asset('AdminAssets/CatalogAssets/deleteIcon.svg') }}" alt="Delete"></button>
                                </td>
                            </tr>
                            <tr>
                                <td class="mono-text">#0005</td>
                                <td>
                                    <div class="book-title-cell">
                                        <img src="{{ asset('AdminAssets/CatalogAssets/blueBookIcon.svg') }}" alt="Book" class="table-book-icon">
                                        <span>Cybersecurity Essentials</span>
                                    </div>
                                </td>
                                <td>Charles J. Brooks</td>
                                <td><span class="cat-badge badge-cyan">Cybersecurity</span></td>
                                <td><span class="status-badge badge-success">Available</span></td>
                                <td class="actions-cell-row">
                                    <button class="action-btn-edit"><img src="{{ asset('AdminAssets/CatalogAssets/editIcon.svg') }}" alt="Edit"></button>
                                    <button class="action-btn-delete"><img src="{{ asset('AdminAssets/CatalogAssets/deleteIcon.svg') }}" alt="Delete"></button>
                                </td>
                            </tr>
                            <tr>
                                <td class="mono-text">#0006</td>
                                <td>
                                    <div class="book-title-cell">
                                        <img src="{{ asset('AdminAssets/CatalogAssets/purpleBookIcon.svg') }}" alt="Book" class="table-book-icon">
                                        <span>Research Methodology: Methods and Techniques</span>
                                    </div>
                                </td>
                                <td>C.R. Kothari</td>
                                <td><span class="cat-badge badge-teal">Research</span></td>
                                <td><span class="status-badge badge-due">Unavailable</span></td>
                                <td class="actions-cell-row">
                                    <button class="action-btn-edit"><img src="{{ asset('AdminAssets/CatalogAssets/editIcon.svg') }}" alt="Edit"></button>
                                    <button class="action-btn-delete"><img src="{{ asset('AdminAssets/CatalogAssets/deleteIcon.svg') }}" alt="Delete"></button>
                                </td>
                            </tr>
                            <tr>
                                <td class="mono-text">#0007</td>
                                <td>
                                    <div class="book-title-cell">
                                        <img src="{{ asset('AdminAssets/CatalogAssets/greenBookIcon.svg') }}" alt="Book" class="table-book-icon">
                                        <span>Python for Data Analysis</span>
                                    </div>
                                </td>
                                <td>Wes McKinney</td>
                                <td><span class="cat-badge badge-light-blue">Programming</span></td>
                                <td><span class="status-badge badge-success">Available</span></td>
                                <td class="actions-cell-row">
                                    <button class="action-btn-edit"><img src="{{ asset('AdminAssets/CatalogAssets/editIcon.svg') }}" alt="Edit"></button>
                                    <button class="action-btn-delete"><img src="{{ asset('AdminAssets/CatalogAssets/deleteIcon.svg') }}" alt="Delete"></button>
                                </td>
                            </tr>
                            <tr>
                                <td class="mono-text">#0008</td>
                                <td>
                                    <div class="book-title-cell">
                                        <img src="{{ asset('AdminAssets/CatalogAssets/orangeBookIcon.svg') }}" alt="Book" class="table-book-icon">
                                        <span>Machine Learning Yearning</span>
                                    </div>
                                </td>
                                <td>Andrew Ng</td>
                                <td><span class="cat-badge badge-blue">AI</span></td>
                                <td><span class="status-badge badge-success">Available</span></td>
                                <td class="actions-cell-row">
                                    <button class="action-btn-edit"><img src="{{ asset('AdminAssets/CatalogAssets/editIcon.svg') }}" alt="Edit"></button>
                                    <button class="action-btn-delete"><img src="{{ asset('AdminAssets/CatalogAssets/deleteIcon.svg') }}" alt="Delete"></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="catalog-pagination-row">
                        <div class="pagination-info text-zinc">Showing 1-8 of 8</div>
                        <div class="pagination-nav">
                            <span class="page-link active">1</span>
                            <span class="page-link">2</span>
                            <span class="page-link">3</span>
                            <span class="page-link">4</span>
                            <span class="page-link">5</span>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>
</body>
</html>

<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }
    body {
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        background-color: #1C1C1C;
        -webkit-font-smoothing: antialiased;
        overflow: hidden;
    }
    .layout-container {
        display: flex;
        height: 100vh;
        width: 100vw;
        overflow: hidden;
    }

    /* Main Content */
    .main-canvas {
        flex: 1;
        background-color: #F9F6F0;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
    }
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #FFFFFF;
        padding: 20px 40px;
        border-bottom: 1px solid #EAE6DF;
    }
    .canvas-content {
        padding: 32px 40px;
        flex: 1;
    }
    .dashboard-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #1A1A1A;
        letter-spacing: -0.02em;
    }
    .profile-avatar {
        width: 40px;
        height: 40px;
        background-color: #212B05;
        color: white;
        font-weight: 700;
        font-size: 14px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Controls Row */
    .control-row-container {
        background-color: #FFFFFF;
        border: 1px solid #EAE6DF;
        border-radius: 16px;
        padding: 16px 24px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.01);
        width: 100%;
    }

    .control-row {
        display: flex;
        align-items: center;
        gap: 16px;
        width: 100%;
    }
    .search-box-wrapper {
        flex: 2; 
        position: relative;
    }

    .search-input {
        width: 100%;
        padding: 12px 16px 12px 46px;
        background-color: #F4F1EA;
        border: none;
        border-radius: 12px;
        font-size: 0.925rem;
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: #1A1A1A;
        font-weight: 500;
        outline: none;
    }
    .search-input::placeholder {
        color: #A1A1AA;
    }

    .dropdown-wrapper {
        position: relative;
        flex: 1; 
        min-width: 170px;
    }
    .custom-filter-dropdown {
        width: 100%;
        height: 44px;
        padding: 0 36px 0 16px;
        background-color: #F4F1EA;
        border: none;
        border-radius: 12px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.875rem;
        font-weight: 600;
        color: #4B5563;
    }

    .custom-filter-dropdown:focus {
        background-color: #EAE6DF;
    }
    .custom-filter-dropdown option {
        background-color: #FFFFFF;
        color: #1A1A1A;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    
    .btn-export {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 0 24px;
        height: 44px;
        background-color: #FFFFFF;
        border: 1px solid #EAE6DF;
        border-radius: 12px;
        cursor: pointer;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 600;
        font-size: 0.875rem;
        color: #4B5563;
        flex-shrink: 0;
    }
    .btn-icon-svg {
        width: 16px;
        height: 16px;
    }

    /* Action Strip Resource */
    .action-strip {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 24px;
    }
    .btn-add-book {
        background-color: #FF5722;
        color: #FFFFFF;
        border: none;
        padding: 12px 24px;
        border-radius: 14px;
        font-size: 0.875rem;
        font-weight: 700;
        font-family: 'Plus Jakarta Sans', sans-serif;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 10px rgba(255, 87, 34, 0.2);
    }
    .btn-plus-symbol {
        font-size: 1.15rem;
        font-weight: 500;
        line-height: 1;
    }

    .catalog-panel {
        background-color: #FFFFFF;
        border: 1px solid #EAE6DF;
        border-radius: 16px;
        padding: 24px;
    }
    .catalog-data-table {
        width: 100%;
        border-collapse: collapse;
    }
    .catalog-data-table th {
        background-color: #FDFBF7;
        font-size: 0.75rem;
        font-weight: 700;
        color: #71717A;
        letter-spacing: 0.06em;
        padding: 16px;
        border-bottom: 1px solid #F4F1EA;
        text-align: left;
    }
    .catalog-data-table td {
        padding: 14px 16px;
        font-size: 0.875rem;
        color: #5A5A5A !important;
        border-bottom: 1px solid #F4F1EA;
        font-weight: 600;
        vertical-align: middle;
    }
    .catalog-data-table tbody tr:last-child td {
        border-bottom: none;
    }
    
    .mono-text {
        font-family: 'JetBrains Mono', monospace;
        font-weight: 200; 
        color: #A1A1A1 !important; 
        font-size: 0.825rem;
    }

    .book-title-cell {
        display: flex;
        align-items: center;
        gap: 12px;
        color: #1A1A1A;
        font-weight: 700;
    }
    .table-book-icon {
        width: 28px;
        height: 28px;
        flex-shrink: 0;
    }

    .cat-badge {
        padding: 4px 12px;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 700;
        display: inline-block;
    }
    .badge-blue { background-color: #EFF6FF; color: #2563EB; }
    .badge-light-blue { background-color: #E0F2FE; color: #0369A1; }
    .badge-medium-blue { background-color: #EEF2FF; color: #4F46E5; }
    .badge-dark-blue { background-color: #DBEAFE; color: #1D4ED8; }
    .badge-cyan { background-color: #E0F2FE; color: #0369A1; }
    .badge-teal { background-color: #F0FDF4; color: #16A34A; }

    .status-badge {
        padding: 6px 14px;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 700;
        display: inline-block;
    }
    .badge-success { background-color: #DCFCE7; color: #008236; }
    .badge-due { background-color: #FFE2E2; color: #C10007; }

    .actions-cell-row {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
    }
    .action-btn-edit, .action-btn-delete {
        background: none;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: opacity 0.15s ease;
    }
    .action-btn-edit:hover, .action-btn-delete:hover {
        opacity: 0.7;
    }
    .action-btn-edit img, .action-btn-delete img {
        width: 50px;
        height: 50px;
    }

    /* System Pagination Listing Controls interface modules */
    .catalog-pagination-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 24px;
        padding-top: 12px;
    }
    .text-zinc {
        color: #71717A;
        font-size: 0.85rem;
        font-weight: 600;
    }
    .pagination-nav {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .page-link {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        font-weight: 700;
        color: #71717A;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .page-link:hover {  
        background-color: #F4F1EA;
        color: #1A1A1A;
    }
    .page-link.active {
        background-color: #FF5722;
        color: #FFFFFF;
    }
</style>