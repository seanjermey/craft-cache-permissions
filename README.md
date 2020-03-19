# Cache Permissions plugin for Craft CMS 3.x

Plugin allows you to restrict who can clear each cache group based on their user group.

![Screenshot](resources/img/plugin-logo.svg)

## Requirements

This plugin requires Craft CMS 3.0.0-beta.23 or later.

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require seanjermey/craft-cache-permissions

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for Cache Permissions.

## Cache Permissions Overview

Individually choose which caches a user group can clear.

<img src="https://github.com/seanjermey/craft-cache-permissions/raw/master/resources/img/permissions.png" width="250">

Users will only be able to clear the caches they have permission for.

<img src="https://github.com/seanjermey/craft-cache-permissions/raw/master/resources/img/caches.png" width="500">

Works great with [CP Clear Cache](https://plugins.craftcms.com/cp-clearcache)

---

Brought to you by [Sean Jermey](https://github.com/seanjermey)
