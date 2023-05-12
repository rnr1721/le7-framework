# Place for your view templates or themes folders

You can store your templates here or in theme folder.
When le7 find template, finding template will be in this places:

1 ./App/View/{your_theme_name}
2 ./App/View

So, ./App/View folder is universal for any theme.

Any theme contain two parts - public and templates.
Public (css, js, fonts etc) - placed in ./public/themes/{your_theme}
Templates (Twig, Smarty or PHP) - placed in ./App/View/{your_theme}

To create your own theme:

1. Copy default tpl ./public/themes/main to folder ./public/themes/{your_theme}
2. Create templates theme folder ./App/View/{your_theme}
3. change theme in config (./config/config.php)

Theme name is similar to theme folder name (letter register is matter!)

Templates can be in Twig, Smarty or clean PHP. For change template engine
in Di container see ./config/Di/README.md
