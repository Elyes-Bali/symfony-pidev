// search.js
document.addEventListener('DOMContentLoaded', function () {
    var searchForm = document.getElementById('searchForm');
    var circuitsContainer = document.getElementById('circuitsContainer');

    // Attach event listeners to form inputs for dynamic search
    searchForm.addEventListener('input', function () {
        // Collect form data
        var formData = new FormData(searchForm);

        // Make an asynchronous request to update search results
        fetch('/searcher', {  // Update the path accordingly
            method: 'GET',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Update the circuitsContainer with new search results
            circuitsContainer.innerHTML = data.html;
        })
        .catch(error => console.error('Error:', error));
    });
});
