// assets/js/search.js

$(document).ready(function () {
    $('#search-input').on('input', function () {
        var query = $(this).val();

        $.ajax({
            url: '/search',
            method: 'GET',
            data: { query: query },
            success: function (data) {
                updateTable(data);
            }
        });
    });

    function updateTable(data) {
        var tableBody = $('#circuit-table tbody');
        tableBody.empty();

        if (data.length === 0) {
            tableBody.append('<tr><td colspan="9">No records found for the given search query.</td></tr>');
        } else {
            $.each(data, function (index, circuit) {
                var row = '<tr>' +
                    '<td>' + circuit.id + '</td>' +
                    '<td>' + circuit.prix + '</td>' +
                    '<td>' + circuit.depart + '</td>' +
                    // Add other fields as needed
                    '<td>' +
                    '<a href="/circuit/show/' + circuit.id + '">show</a>' +
                    '<a href="/circuit/edit/' + circuit.id + '">edit</a>' +
                    '</td>' +
                    '</tr>';
                tableBody.append(row);
            });
        }
    }
});
