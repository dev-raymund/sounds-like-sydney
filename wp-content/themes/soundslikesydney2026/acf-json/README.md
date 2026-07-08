# acf-json — ACF Local JSON

This folder is ACF's **Local JSON** store. It is registered as both the *save*
and *load* point in [`inc/acf.php`](../inc/acf.php).

## How it works

- When you **create or edit** a field group in the WordPress admin, ACF writes a
  `group_XXXX.json` file here automatically.
- On load, ACF reads these files instead of the database — so field definitions
  are fast, versionable, and travel with the theme.
- If a JSON file here is newer than the DB copy, the admin shows a **"Sync
  available"** notice under *Custom Fields → Field Groups*. Click **Sync** to
  import.

## Rules

1. **Commit every file in this folder.** These *are* your field definitions.
2. Don't hand-edit the JSON in production; edit in the admin and let ACF re-save.
3. The example file below is safe to delete once you build your own groups.

## What's here

| File | Purpose |
| --- | --- |
| `group_article_meta.json` | Example: editorial fields for posts (deck, featured flag, media type, audio/video embed). Demonstrates the sync workflow. |

> Requires the free **Advanced Custom Fields** plugin. Options pages and ACF
> Blocks (see `inc/acf.php`) additionally require **ACF Pro**.
