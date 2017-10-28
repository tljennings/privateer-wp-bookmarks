# privateer-wp-bookmarks
Let users bookmark different post types on a wordpress web site.

## Planned functionality

__Plugin Configuration Screen__

1. Ability to restrict bookmark usage/visibility by role
2. Ability to choose post types that can be bookmarked
3. Ability to automatically show bookmark info in singular templates
4. Ability to automatically show bookmark info in multiple templates
5. Ability to purge all bookmarks from the system
6. Ability to automatically redirect back end to bookmark list for users lacking specified role
7. Ability to share bookmarks
8. Ability to set required role for viewing reports

__Custom Page Templates__

1. __Bookmark List__ : Display and manage your bookmarks or view someone elses bookmarks
2. Report __Bookmark Counts__ : Display bookmarked pages/posts with number of people who have bookmarked them
3. Report __Bookmark Users__ : Display name and email of users who have bookmarked a specified page/post

Report templates should have the following extra capabilities:

* View without site header or footer
* Download as .csv file
* Download as .json file

__Custom Widget__

1. __Manage Your Bookmarks__ : Take a user to their bookmark list

__Custom Shortcode__

1. __bookmark__ : Show "Bookmark This" or "Delete Bookmark". Show counts and link to Bookmark Users report if applicable.
2. __bookmark-count__ : Show number of people who have bookmarked an item. As link to Bookmark Users report if applicable.

__Editor Screens__

Post types that can be bookmarked should show a custom editor box that 
allows one to see who has bookmarked the current post/page and view the 
Bookmark Users report.
