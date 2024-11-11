# Custom WordPress Theme - Ikonic

This is a custom-built WordPress theme named **Ikonic**. It is designed to showcase the developer's skills in both front-end and back-end development, featuring custom post types, custom fields, an API endpoint, and a dynamic navigation menu. This theme is fully responsive, follows WordPress best practices, and includes basic security implementations.

## Features

- **Custom Post Type for Projects:** Adds a "Projects" post type with custom fields for project details.
- **Custom Page Templates:** Includes templates for the homepage, single project view, and archive page.
- **Responsive Design:** Optimized for mobile and desktop devices.
- **Dynamic Sidebar:** Custom sidebar with a list of recent projects, displayed on the homepage.
- **Custom API Endpoint:** Provides project data in JSON format, including project title, URL, start date, and end date.
- **Filtering on Archive Page:** Filter projects by meta keys using AJAX for a seamless user experience.
- **Dynamic Navigation Menu:** Supports multi-level dropdowns, using WordPress’s `wp_nav_menu()` function.

## Theme Installation

1. **Upload the Theme**  
   Download or clone this repository and upload the theme folder to your WordPress installation’s `/wp-content/themes/` directory.

2. **Activate the Theme**  
   In the WordPress dashboard, go to **Appearance > Themes** and activate the **Ikonic** theme.

3. **Configure Permalinks**  
   Go to **Settings > Permalinks** and ensure the permalink structure is set to "Post name" for proper URL handling.

4. **Set Up the Homepage**  
   Go to **Settings > Reading**, set your homepage to display a static page, and assign it to the page using the `home.php` template.

5. **Add Widgets to Sidebar**  
   Go to **Appearance > Widgets** and add widgets to the "Homepage Sidebar" to customize sidebar content.

## Custom Post Type and Custom Fields

The theme includes a "Projects" post type with the following custom fields:
- **Project Name**
- **Project Description**
- **Project Start Date**
- **Project End Date**
- **Project URL**

### Adding a New Project

1. In the WordPress dashboard, go to **Projects > Add New**.
2. Enter the project title and fill out the custom fields.
3. Publish the project to display it in the theme.

## Custom API Endpoint

This theme provides a custom REST API endpoint for retrieving project data.  
**Endpoint URL:** `/wp-json/ikonic/v1/projects`

### Example Response

```json
[
  {
    "title": "Project Title",
    "url": "https://example.com/project-url",
    "start_date": "2024-01-01",
    "end_date": "2024-12-31"
  },
  ...
]
