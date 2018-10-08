## CMB2 Field: Widget Selector 

Need a field that lets you ( or your editor ) select / display an existing widget instance?  Then this is the plugin for you.

### What it does.

CMB2 Field Widget Selector introduces a new field type that displays a list of widget instances.  When you select the widget instance, you can display the widget simply by calling the normal get_post_meta( $post_id, $meta_key, true ) that you use to access any CMB2 field ( or any other post meta ) value.

### Why this could be cool.

Widget instances can contain a variety of settings.  If you need to display a particular widget instance in the context of a specific post or posts, you only have a couple of options:
1. Create a sidebar and deploy the widget with one or more conditionals. 
2. Use some sort of page builder which instantiates it's on widget instance.
3. Use a dedicated [plugin](https://wordpress.org/plugins/widgets-on-pages/#developers) 
4. Use Widget Selector.

The problem with #1 is you could be continuously going back to the your increasing complex set of conditional logic of where and how to display your Widget instance.  It's not easy for an editor to control when / where / how a specific widget is displayed.

The problem with #2 is you have to actually create multiple instances of the widget for each post you want it displayed.  You might be able to create a reusable component ( depending on the builder ), but what if you aren't already using a builder that supports this.

The [Widgets on Pages](https://wordpress.org/plugins/widgets-on-pages/#developers) plugin looks decent enough ( I haven't tested ), but if you are already using CMB2, then it makes sense to just use a field.

#### Example:

Let's say you have a widget that displays company address and phone number.  This information is displayed in various places around your site in different posts / pages ( like an About Us and a Contact Us page ).  Now let's say this company changes location, or changes phone numbers.  You are stuck going through every page of the site to find every instance of the old phone number / address to change it.  Wouldn't it be better to change it in one place?

### How it works.

Installing CMB2 Field Widget Selector automatically creates a new sidebar.  It uses PHP's uniqueid() to prevent name collisions and stores the name in an option.  It uses the label "Builder Sidebar".  Future versions may include a form to allow you to change the label since it's not really important.

![widget selector sidebar](https://github.com/scottsawyer/cmb2-field-widget-selector/raw/master/assets/images/screenshot-demo.wp-builder.net-2018.10.07-01-13-08.png "Widget Selector Sidebar")

Next you create one or more widgets by dropping them in the new sidebar and configuring them to your heart's content.

![widget selector sidebar text widget](https://github.com/scottsawyer/cmb2-field-widget-selector/raw/master/assets/images/screenshot-demo.wp-builder.net-2018.10.07-01-24-24.png "Widget Selector Sidebar text widget")

Then you create a metabox using CMB2's normal process, and add the field type: 'widget_selector'.

```
// Assumes you initiated a metabox $cmb2.
$cmb->add_field( [
  'name' => __( 'Widgets', TEXTDOMAIN ),
  'desc' => __( 'Select a widget to display', TEXTDOMAIN ),
  'id' => $my_prefix . 'widget',
  'type' => 'widget_selector',
  ]
);
```

Finally, when you edit a post, you will see the new field, which is a select widget that contains options for each widget you created.  It's a repeatable field, so you can add as many widgets as you like.

![widget selector select widget](https://github.com/scottsawyer/cmb2-field-widget-selector/raw/master/assets/images/screenshot-demo.wp-builder.net-2018.10.07-01-28-06.png "Select widget")

Back to our example, if you decide to change the address or phone number for your company, just update the widget and, amazingly, it's changed everywhere.

## Installation.

This field type installs as a plugin.  Just drop it in your plugins directory and activate.  It totally depends on CMB2, so make sure you have it installed.  I only tested with the CMB2 plugin.

## Getting you widget

You need to retrieve your [post meta](https://github.com/CMB2/CMB2/wiki/Basic-Usage#display-the-metadata).

It's going to come out as an array. 

```
$meta_data = get_post_meta( get_the_ID(), '_yourprefix_widget', true );

var_dump( $meta_data );

// Result
array(
    'widgets' => widget_id // widget id is the actual id of the widget.
)



```

If you use it as a repeater field:

```
var_dump( $meta_data );

// Result

Array(
 [0] => Array (
   'widgets' => widget_id,
   ),
  [1] => Array(
    'widgets' => widget_id,
  ),
)

```

WordPress actually makes this next part complicated, actually displaying your widget without rendering your sidebar.  

The plugin comes with a handy shortcode for rendering your widget.  It's pretty plain right now, but I might add features over time.

```
[widget_selector widget="<?php print $meta_data['widgets']; ?>"];
```

That should be good enough to render a widget.  I've only tested with a few to this point, core widgets.  There are probably cases where a plugin does something fancy and it breaks.  Just post an issue.