jQuery(document).ready(function($) {
    $('#project-filter-form').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        var projectName = $('#project_name').val();
        var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();

        // AJAX request to filter the projects
        $.ajax({
            url: mytheme_ajax_obj.ajaxurl,
            type: 'POST',
            data: {
                action: 'filter_projects', // The action hook defined in functions.php
                project_name: projectName,
                start_date: startDate,
                end_date: endDate
            },
            success: function(response) {
                // Update the projects section with the filtered projects
                $('#projects-list').html(response);
            }
        });
    });
});
