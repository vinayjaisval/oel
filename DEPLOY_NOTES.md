# Deploy notes: docroot hardening + `/public/` asset paths

Context: the live docroot (overseaseducationlane.com) is the project root, not `public/`. Confirmed live:
`GET /composer.json` → 200, `GET /composer.lock` → 200, `GET /vendor/autoload.php` → 200, `GET /artisan` → 200,
`GET /storage/logs/laravel.log` → **200** (Laravel log file, potentially containing stack traces/PII/credentials
in exception messages — this is the most serious one, see rotation checklist below).

## 1. Hotfix — ship immediately, on its own

The root `.htaccess` deny rules (this branch's first commit) are safe to deploy to production **right now**,
independently of everything else below. They only add `Require all denied` / `[F,L]` blocks for files that were
never meant to be public (`.env*`, `.git`, `composer.*`, `package*.json`, `artisan`, `phpunit.xml`, `*.log`,
`*.sql`, `storage/`, `vendor/`, `bootstrap/cache/`, `node_modules/`) — no behavior change for anything else.
Verified locally: all of those now return 403; homepage/programs/favicon.ico still 200.

## 2. Asset-path commits + the `public/$1` rewrite fallback MUST deploy together

This branch also strips the hardcoded `/public/` prefix from `asset()`/`url()` calls in `main.blade.php`,
`index.blade.php`, four email templates, `admin/invoice.blade.php`, `Program.php`, and `ContactUsController.php`
(see commit for the full list). **These calls only resolve correctly in production because the same commit
also adds the `public/$1` fallback rule to the root `.htaccess`** (serves `public/<path>` transparently when
`<path>` isn't a real file at the docroot). Deploying the asset-path changes without the `.htaccess` fallback
rule — or vice versa — will **break every image using the fixed paths** (logo, favicon, login modal image,
testimonial profile pictures, the 4 email logos, invoice logo). Deploy both in the same release.

One of the fixed spots, `Program.php`'s `logo_path` raw-SQL attribute, isn't consumed anywhere in this repo's
views — if a mobile app or other external client reads it, double-check that client doesn't have the old
`/public/`-prefixed URL hardcoded before shipping.

### Run on deploy, alongside the above
- `php artisan storage:link` — creates `public/storage` (didn't exist before this branch; `main.blade.php`
  already references `asset('storage/...')` for user profile pictures, which depends on it). Confirmed working
  locally: a file placed in `storage/app/public/` is reachable at both `/public/storage/<file>` (200) and, once
  the fallback rule is live, at the docroot-agnostic `/storage/<file>` form too.
- Double check `/public/storage` is excluded from the `storage/` deny rule after deploy (it is, by construction —
  the deny rule only matches paths starting with `storage/`, and the symlink lives under `public/`).

## 3. Proper fix (needs hosting/cPanel access — not done in this branch)

Point the web server's document root at `public/` directly. After that:
- Remove the root-level dev-server `index.php` shim and the root `.htaccess`'s rewrite-to-root-`index.php`
  front-controller rule — `public/.htaccess` (added in this branch) takes over automatically.
- The `public/$1` fallback rule and the `/public/(.*) → /$1` redirect in `public/.htaccess` both become no-ops
  for new requests, but the redirect keeps old indexed URLs / `og:image` links / already-sent emails with
  `/public/...` baked in working instead of 404ing.

## 4. Secret-rotation checklist (priority order)

1. **Razorpay keys** — payment, highest abuse potential.
2. **Twilio keys** — SMS, high abuse potential.
3. `APP_KEY`
4. DB credentials
5. Mail credentials
6. Facebook app secret
7. Any other key in the live `.env`

Also: **pull and inspect `storage/logs/laravel.log` directly from the server (not over HTTP) before rotating**,
since it's been confirmed publicly fetchable — check it for leaked credentials/tokens logged in past exceptions,
in case rotation needs to extend beyond the `.env` keys above. Check Cloudflare/server access logs for historical
hits on `.env`, `.git`, `storage/logs/*.log`, `composer.json`/`composer.lock`, `vendor/autoload.php`, `artisan`.

**Do not run `git filter-repo`/BFG or any force-push as part of this work.** Purging `.env` from git history
(it was committed between `47e7dd87` and `fba6433f`) is an **optional cleanup step to consider only after
secrets are rotated** — once rotated, the old history is harmless, so rewriting it is a nice-to-have, not a
blocker, and force-pushing rewritten history has its own risks (coordination with anyone else who has the repo
cloned).

## Known issue, not fixed in this branch

`routes/web.php:39` — `Route::fallback(fn () => view('errors.404'))` returns no explicit 404 status, so every
unmatched URL on the site currently responds with HTTP 200 (a soft-404). Worth fixing separately
(`response()->view('errors.404', [], 404)`), unrelated to this branch's scope.

## Not fixed in this branch (reported only)

~79 `asset('public/...')` calls across 11 legacy pages (`gmat`, `gre`, `ielts`, `pet`, `sat`, `toefl`, `tem`,
`home`, `studentloan`, `student_recommendation`, `student_accommodation` under
`resources/views/frontend/global/`) reference image paths (`public/home/...`, `public/mediadata/...`,
`public/pages/...`, `public/images/...`) that **don't exist anywhere under `public/`** — confirmed by searching
the whole `public/` tree. These pages are also **not reachable from any registered route** (grepped
`routes/web.php` — none of these view names are routed), so they're orphaned dead code with missing assets.
Fixing the path prefix wouldn't make the images resolve either way; left untouched rather than mechanically
"fixing" paths that have nothing to point at. Worth a separate decision: delete the dead views, or source the
missing images and wire up routes, if these pages are still wanted.
