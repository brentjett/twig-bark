Bark: Twig for WordPress
=========

Bark: Twig implementation for WordPress. This is an extension to the Twig templating syntax to make theming WordPress fast, safe, and easy to read.

# Rendering Twig Templates vs. traditional PHP templates.

Bark uses the same template files that WordPress naturally selects (index.php, page.php, single.php, etc...) but you can designate whether or not the template file should be rendered by the twig engine. This allows you to have some templates be traditional PHP and retrofit older themes with twig gradually.

To process a template file with twig, it should contain "{%" or "{{" opening tags. This is the simplies way, since you can't really do much with twig without those tokens. If by chance, you are using PHP to display a twig code example and want to prevent this template from being processed by the twig engine, add a php "disable_twig" comment in the file:

```
/* disable_twig */
```