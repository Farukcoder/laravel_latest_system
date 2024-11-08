<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">My Application</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Tasks</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container mt-5">
    <h2 class="mb-4">Task List</h2>
    <table class="table table-bordered" id="tasks-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Is Completed</th>
        </tr>
        </thead>
    </table>
</div>

<!-- Bootstrap JS (with Popper.js for tooltips and dropdowns) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

<!-- jQuery (required for DataTables) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#tasks-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: 'http://127.0.0.1:8000/api/v1/tasks', // Replace with your API endpoint
                type: 'GET', // or 'POST' if your API requires POST for search
                data: function(d) {
                    // Modify the data to send the search term directly if needed
                    if (d.search && d.search.value) {
                        d.search = d.search.value; // Send only the search term value
                    }
                },
                dataSrc: function(response) {
                    response.recordsTotal = response.meta.total;
                    response.recordsFiltered = response.meta.total;
                    return response.data;
                }
            },
            columns: [
                {
                    data: null,
                    name: 'serial',
                    render: function(data, type, row, meta) {
                        const pageInfo = $('#tasks-table').DataTable().page.info();
                        return pageInfo.start + meta.row + 1;
                    },
                    title: 'Serial'
                },
                { data: 'id', name: 'id', title: 'ID' },
                { data: 'name', name: 'name', title: 'Name' },
                { data: 'is_completed', name: 'is_completed', render: function(data) {
                        return data ? 'Yes' : 'No';
                    }, title: 'Is Completed' }
            ],
            paging: true,
            lengthChange: false,
            pageLength: 10,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
            responsive: true,
            language: {
                info: "Showing _START_ to _END_ of _TOTAL_ entries"
            }
        });
    });


</script>

</body>
</html>
