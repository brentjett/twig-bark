Bark: Twig for WordPress
=========

Bark: Twig implementation for WordPress. This is an extension to the Twig templating syntax to make theming WordPress fast, safe, and easy to read.

## Rendering Twig Templates vs. traditional PHP templates.

Bark uses the same template files that WordPress naturally selects (index.php, page.php, single.php, etc...) but you can designate whether or not the template file should be rendered by the twig engine. This allows you to have some templates be traditional PHP and retrofit older themes with twig gradually.

To process a template file with twig, it should contain "{%" or "{{" opening tags. This is the simplies way, since you can't really do much with twig without those tokens. If by chance, you are using PHP to display a twig code example and want to prevent this template from being processed by the twig engine, add a php "disable_twig" comment in the file:

``` php
<?php
// This file contains twig syntax examples like {% this } or {{ this }} in it, 
// but should not be processed by the twig engine.
// Add the disable_twig PHP comment to prevent Twig from compiling the file.
/* disable_twig */
?>
```

## Including a root template with extend

Twig eliminates the need for before and after includes like get_header, get_footer or anything with get_template_part. Instead, all Twig templates are complete HTML structures. Starting with a common root template is simple with the `{% extend %}` tag. This is similar to subclassing in object-oriented programming.

```twig
// base.twig
<!Doctype {% block doctype 'html' %}>
<html>
	<head>
	{% block head %}
		<title>{% block title 'default title' %}</title>
		{% block meta %}
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="referrer" content="always">
		{% endblock %}
		{% block head_icons '' %}
		{{ wp_head() }}
	{% endblock %}
	</head>
	<body {{ body_class() }}>
		{{ do_action('neh_after_body_open') }}
		
		{% block content '' %}
		{% block footer '' %}
		{{ wp_footer() }}
	</body>
</html>
```

```twig
// index.php
{% extends "base.twig" %}

{% block title %}Title for this page or template{% endblock %}

{% block content %}
	<h1>Content Goes Here</h1>
{% endblock %}
```

In this example.