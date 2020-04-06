#!/bin/bash
git add . &&
git commit -m "bosta dfasfdsadfasf" &&
git push heroku master &&
heroku run php artisan cache:clear &&
echo "Nao esquecer de limpar o cache na cloudflare"