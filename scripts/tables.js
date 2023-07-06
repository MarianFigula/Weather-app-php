$(document).ready(function () {
    $('#website-visitors').DataTable({
        paging: true,
        lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"] ],
        columnDefs: [
            { className: "dt-head-center", targets: [0,1] },
            { className: "dt-body-center", targets: [0,1] },
        ]
    });
});

$(document).ready(function () {
    $('#visitors-time').DataTable({
        paging: true,
        lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"] ],
        columnDefs: [
            { className: "dt-head-center", targets: [0,1,2,3] },
            { className: "dt-body-center", targets: [0,1,2,3] },
        ]
    });
});