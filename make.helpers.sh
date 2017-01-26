#!/usr/bin/env bash
php artisan optimize
php artisan ide-helper:models --dir="/app/"
php artisan ide-helper:meta
php artisan ide-helper:generate
