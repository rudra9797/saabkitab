// Call the dataTables jQuery plugin
$(document).ready(function() {
$('#dataTable').DataTable({
'pageLength': 25,

'aoColumnDefs': [{
'bSortable': false,
'aTargets': [-1] /* 1st one, start by the right */
}],
scrollY: 500
});
});
