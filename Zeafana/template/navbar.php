<nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
    <a href="#" class="navbar-brand d-flex d-lg-none me-4">
        <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
    </a>

    <a href="#" class="sidebar-toggler flex-shrink-0 me-3">
        <i class="fa fa-bars"></i>
    </a>

    <!-- Left-aligned items -->
    <div class="d-flex align-items-center flex-grow-1  h-100 p-4">
        <div class="me-3">
            <select id="campaign" class="form-select form-select-sm">
                <!-- Campaign options populated via JS -->
            </select>
        </div>

        <!-- Uncomment if needed
        <div class="me-3">
            <select id="search_value" class="form-select form-select-sm">
                <option selected="">Call Center</option>
                <option value="B2C">B2C</option>
            </select>
        </div>
        -->

        <input type="hidden" id="btn_clk" value="submit">
    </div>

    <!-- Right-aligned items -->
    <div class="d-flex align-items-center text-white ms-auto me-3">
        <i class="bi bi-clock me-2"></i> Every 1 Min Refresh
    </div>
</nav>
