# Cut and Critical CSS extension for Magento 2

This Magento 2 module provides ways to set already generated  **cut** and **critical** CSS files for various page layouts.

***Important: This extension doesn't remove redundant CSS nor does it help you create a critical CSS file. It mearly helps with placing already created files in right spots on Magento pages + it removes already existing Magento 2 CSS files. Contact [Magento developer](https://www.goivvy.com/contacts) for help with CSS optimization.***

It removes all the current CSS files from pages and let's you add two files: one will be inserted in **head** section of HTML, the other will be inserted at the bottom before **</body>**.

![Cut File](https://www.goivvy.com/media/cut-css-example.png)

![Critical File](https://www.goivvy.com/media/critical-css-example.png)

Here is the configuration page of the module:

![Cut and Critical CSS module configuration page.](https://www.goivvy.com/media/goivvyllc-css.png)

## Installation

To install this module, create a directory inside your Magento 2 root folder:

```
mkdir -p [MAGENTO-ROOT]/app/code/Goivvyllc/CSS
```

Download the code from this github page and unzip it in the newly created _app/code/Goivvyllc/CSS_ folder.

Then run the following commands:

```
php bin/magento setup:upgrade
php bin/magento deploy:mode:set production
```

Proceed to the configuration page at _Stores > Configuration > Goivvy LLC > CSS Optimizations_ and set up the extension.

## Why Do I Need This Module?

It will place **cut** and **critical** CSS files in right spots thus improving Core Web Vitals.

## What are Cut and Critical CSS Files?

**Cut File** - CSS file that's necessary to display page layout but with redundant code removed. Magento 2 places lots of unused CSS on pages, removing that code will greatly improve your Core Web Vitals.

**Critical File** - CSS file that's needed to render above-the-fold content, i.e. the content that displayed before you scroll down the page.

If you need other ways to improve Magento performance - check out my [35 tips to speed up Magento](https://www.goivvy.com/blog/speed-up-magento)
