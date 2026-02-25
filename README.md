# AdSense Injector

A lightweight Drupal 11 module that automatically injects your Google AdSense script into every page for all user roles **except** the `administrator` role.

Built using modern Drupal 11.3 architecture: `#[Hook]` attributes, constructor autowiring, and correct cache context handling.

---

## Features

- Injects the AdSense `<script>` tag into the `<head>` on every page
- Skips injection for users with the `administrator` role
- Correctly declares `user.roles` cache context to prevent cache poisoning
- No configuration UI needed — just install and go

---

## Requirements

- Drupal `^11`
- PHP `^8.2`

---

## Installation

### Via Composer (recommended)

1. Add the repository to your project's `composer.json`:

```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/idflorin/adsense_injector"
    }
]
```

2. Require the module:

```bash
composer require idflorin/adsense_injector
```

3. Enable the module:

```bash
drush en adsense_injector
drush cr
```

### Manual installation

Download or clone this repository into `web/modules/custom/adsense_injector`, then enable it via Drush or the Drupal admin UI (`/admin/modules`).

---

## Configuration

Open `adsense_injector.libraries.yml` and replace the AdSense URL with your own publisher ID (`ca-pub-XXXXXXXXXXXXXXXX`):

```yaml
js:
  https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-XXXXXXXXXXXXXXXX:
    type: external
    attributes:
      async: true
      crossorigin: anonymous
```

Then clear the cache:

```bash
drush cr
```

---

## How it works

The module hooks into `hook_page_attachments()` via a modern PHP attribute (`#[Hook]`). On every page request it:

1. Always adds `user.roles` to the cache context so Drupal's page cache correctly distinguishes between admin and non-admin users.
2. Attaches the AdSense library only when the current user does **not** have the `administrator` role.

---

## License

GPL-2.0-or-later. See [LICENSE](https://www.gnu.org/licenses/old-licenses/gpl-2.0.html).
