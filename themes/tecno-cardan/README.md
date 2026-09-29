# Tecno Cardan theme

## ACF JSON synchronization

ACF field groups under `includes/acf/json-sync/` are version-controlled schema
and are not synchronized on normal requests. To apply all JSON field groups to
the database, an authenticated user with the `manage_options` capability can
request this URL:

```text
https://example.com/wp-admin/?sync-acf-from-json=true
```

The request returns a success or failure response and does not execute for
non-admin users or for any query-string value other than the exact value
`true`. The sync requires ACF Pro and does not expose field-group details in
error responses. There is no WP-CLI synchronization command.
