# SitemapBundle

A simple eZ Publish 5 bundle providing a controller to generate an XML sitemap on the fly.
It provides a human-readable stylesheet.

## How to install

Install into vendors using composer:

	composer --update-no-dev require "eab/tutei-sitemap-bundle":">=0.9"

Or download into src using git:

    git clone https://github.com/eab-dev/TuteiSitemapBundle.git src/Tutei/SitemapBundle

Edit `ezpublish/EzPublishKernel.php` and add the following to the registerBundles() function:

    new Tutei\SitemapBundle\TuteiSitemapBundle()

*Important:* make sure your main bundle comes below it.

Add the following to `ezpublish/config/routing.yml`:

    tutei_sitemap:
        resource: "@TuteiSitemapBundle/Resources/config/routing.yml"

Run the following to install the bundle assets:

    php ezpublish/console assets:install --symlink web

## How to configure

### Minimal configuration

Add something like the following to your own `services.yml`:

	parameters:
	    tutei_sitemap.classes:
	        - folder
	        - article

	    tutei_sitemap.base_url:
	        http://example.com

## How to use

To view your sitemap access: `/sitemap.xml`
