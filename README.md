# Disable Comments Plugin
This is a simple WordPress Plugin designed to be an MU or basic utility plugin that disables comments throughout the site

## Installation
Note this plugin is only available on github.com and not on WP.org so you should manually install into your mu-plugins folder

## Advanced Usage
By default it removes all post types comments, some post types might use the comments for storing notes or similar, you might not want to remove these.
Instead you can filter the post types to be turned off for example:
```
function tn_example_enable_orders_comments($post_types){
    // make sure order comments are still enabled.
    return array_diff($post_types, ['orders']);
}
add_filter( 'tn_disabled_comment_post_types', 'tn_example_enable_orders_comments', 1 );
```
Would mean the *orders* post type comments would still be available.

## Spotted a bug?
Feel free to open an issue, here on Github.