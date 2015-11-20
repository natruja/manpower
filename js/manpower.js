$(document).ready(function() {
    // total = $('#total').DataTable({
    //      "bPaginate": false,
    //      "columnDefs": [
    //         { "width": "1%", "targets": 0},
    //         { "width": "40%", "targets": 1},
    //         { "width": "10%", "targets": 2}
    //       ],
    // });

    var new_emp = $('#group_emp').DataTable({
       "order": [[ 7, "desc" ]]
    });
    var deetail_emp = $('#deetail_emp').DataTable();
});