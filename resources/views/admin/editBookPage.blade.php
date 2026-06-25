<!DOCTYPE html>
<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">    
    <title>IskoLib - Edit Book</title>
</head>
<body>
    <div class="layout-container">
        @include('common.sidebarAdmin')
        <main class="main-canvas">
            
            <div class="dashboard-header">
                <h1 class="dashboard-title">Edit Book</h1>
                <div class="profile-avatar">LA</div>
            </div>

            <div class="canvas-content">
                
                <a href="{{ route('admin.dashboard') }}" class="back-navigation-link">
                    <span class="left-arrow-chevron">&lsaquo;</span> Back to Catalog
                </a>

                <form action="#" method="POST" enctype="multipart/form-data" class="book-information-form-card">
                    @csrf
                    
                    <h2 class="form-section-heading">Book Information</h2>
                    
                    <div class="form-fields-grid">
                        
                        <div class="form-group span-full-width">
                            <label class="input-element-label">Book Title</label>
                            <input type="text" class="form-text-input" placeholder="Enter the full book title" required>
                        </div>

                        <div class="form-group">
                            <label class="input-element-label">Author</label>
                            <input type="text" class="form-text-input" placeholder="Author full name" required>
                        </div>

                        <div class="form-group">
                            <label class="input-element-label">ISBN</label>
                            <input type="text" class="form-text-input" placeholder="978-X-XXXX-XXXX-X" required>
                        </div>

                        <div class="form-group">
                            <label class="input-element-label">Category</label>
                            <div class="form-select-wrapper">
                                <select class="form-select-dropdown" required>
                                    <option value="" disabled selected hidden></option>
                                    <option value="programming">Programming</option>
                                    <option value="networking">Networking</option>
                                    <option value="database">Database</option>
                                    <option value="ai">Artificial Intelligence</option>
                                    <option value="cybersecurity">Cybersecurity</option>
                                    <option value="research">Research</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="input-element-label">Publisher</label>
                            <input type="text" class="form-text-input" placeholder="Publisher name" required>
                        </div>

                        <div class="form-group">
                            <label class="input-element-label">Year Published</label>
                            <input type="number" class="form-text-input" placeholder="2024" min="1000" max="2026" required>
                        </div>

                        <div class="form-group">
                            <label class="input-element-label">Number of Copies</label>
                            <input type="number" class="form-text-input" value="1" min="1" required>
                        </div>

                        <div class="form-group span-full-width">
                            <label class="input-element-label">Description</label>
                            <textarea class="form-textarea-input" placeholder="Brief description of this book.." rows="4"></textarea>
                        </div>

                        <div class="form-group span-full-width">
                            <label class="input-element-label">Book Cover</label>
                            <label class="upload-dropzone-capsule">
                                <input type="file" name="book_cover" accept="image/*" class="hidden-file-input">
                                <img src="{{ asset('AdminAssets/CatalogAssets/bookCoverIcon.svg') }}" alt="Book Icon" class="upload-vector-icon">
                                <div class="upload-prompt-text">Click to upload or drag and drop</div>
                                <div class="upload-limitation-subtext">PNG, JPG up to 5MB</div>
                            </label>
                        </div>
                    </div>

                    <div class="form-action-footer-strip">
                        <button type="button" class="btn-form-cancel">Cancel</button>
                        <button type="submit" class="btn-form-submit">Add Book</button>
                    </div>

                </form>

            </div>
        </main>
    </div>
</body>
</html>

<style>
    /* Baseline Overrides & Viewport Resets */
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

    /* Core Canvas Layout Context Framing */
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
        padding: 24px 40px 40px 40px;
        flex: 1;
        display: flex;
        flex-direction: column;
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

    /* Back Navigation Navigation Typography Link Anchor Controls */
    .back-navigation-link {
        font-size: 0.875rem;
        color: #71717A;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 24px;
        width: max-content;
        transition: color 0.15s ease;
    }
    .back-navigation-link:hover {
        color: #1A1A1A;
    }
    .left-arrow-chevron {
        font-size: 1.35rem;
        line-height: 1;
        font-weight: 500;
        margin-top: -2px;
    }

    /* Core Content Entry Form Card Structure Section */
    .book-information-form-card {
        background-color: #FFFFFF;
        border: 1px solid #EAE6DF;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.01);
        width: 100%;
    }
    .form-section-heading {
        font-size: 1.25rem;
        font-weight: 800;
        color: #1A1A1A;
        letter-spacing: -0.01em;
        margin-bottom: 28px;
    }

    /* Sub-grid system components sizing configurations */
    .form-fields-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        column-gap: 24px;
        row-gap: 20px;
    }
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .span-full-width {
        grid-column: span 2;
    }

    /* Individual Component Field Element Form Inputs Controls */
    .input-element-label {
        font-size: 0.875rem;
        font-weight: 700;
        color: #1A1A1A;
    }
    .form-text-input, .form-textarea-input, .form-select-dropdown {
        width: 100%;
        padding: 12px 16px;
        background-color: #FFFFFF;
        border: 1px solid #E5E7EB;
        border-radius: 10px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.925rem;
        color: #1A1A1A;
        font-weight: 500;
        outline: none;
        transition: border-color 0.15s ease;
    }
    .form-text-input:focus, .form-textarea-input:focus, .form-select-dropdown:focus {
        border-color: #FF5722;
    }
    .form-text-input::placeholder, .form-textarea-input::placeholder {
        color: #A1A1AA;
        font-weight: 500;
    }
    .form-textarea-input {
        resize: vertical;
    }

    /* Direct Select Customizing Overrides wrappers */
    .form-select-wrapper {
        position: relative;
        width: 100%;
    }
    .form-select-dropdown {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        padding-right: 40px;
        cursor: pointer;
        background-color: #FFFFFF;
    }

    /* Upload Media Vector Capsule Dropzone Field box */
    .upload-dropzone-capsule {
        width: 100%;
        border: 1px dashed #D1D5DB;
        border-radius: 12px;
        padding: 32px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        background-color: #FFFFFF;
        transition: background-color 0.15s ease;
    }
    .upload-dropzone-capsule:hover {
        background-color: #FDFBF7;
    }
    .hidden-file-input {
        display: none;
    }
    .upload-vector-icon {
        width: 32px;
        height: 32px;
        margin-bottom: 12px;
    }
    .upload-prompt-text {
        font-size: 0.875rem;
        font-weight: 600;
        color: #71717A;
        margin-bottom: 4px;
    }
    .upload-limitation-subtext {
        font-size: 0.75rem;
        color: #A1A1AA;
        font-weight: 500;
    }

    /* Footer Action Panel Control Row */
    .form-action-footer-strip {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 32px;
        gap: 16px;
    }
    .btn-form-cancel {
        flex: 1;
        height: 48px;
        background-color: #FFFFFF;
        border: 1px solid #D1D5DB;
        color: #1A1A1A;
        border-radius: 12px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.925rem;
        font-weight: 700;
        cursor: pointer;
        transition: background-color 0.15s ease;
    }
    .btn-form-cancel:hover {
        background-color: #F9F6F0;
    }
    .btn-form-submit {
        flex: 1;
        height: 48px;
        background-color: #FF5722;
        border: none;
        color: #FFFFFF;
        border-radius: 12px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.925rem;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(255, 87, 34, 0.15);
        transition: opacity 0.15s ease;
    }
    .btn-form-submit:hover {
        opacity: 0.9;
    }
</style>