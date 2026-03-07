# Research Notes: Family Restrictions MVP

## Browser Push Notifications (Laravel)

**Decision**: Defer full browser push to post-MVP unless critical; keep as optional stretch using Laravel Notifications with the webpush channel.

**Rationale**:

- Requires Service Worker, VAPID keys, HTTPS, and subscription storage.
- Adds dependency and UX friction (permission prompts) with uncertain opt-in rates.
- Email notifications already cover core reminder needs for MVP.

**Alternatives considered**:

- Implement now with `laravel-notification-channels/webpush` (standard package).
- Use OneSignal/FCM for easier setup but adds vendor dependency.

## Localization (pt-BR, en, es)

**Decision**: Use Laravel `lang/` PHP array files with middleware to resolve locale; store user preference in `users.locale` and default to `pt_BR` with fallback to `en`.

**Rationale**:

- Native Laravel support, no new dependencies.
- Clear structure for grouping UI strings.
- Middleware centralizes locale resolution and keeps UI consistent.

**Alternatives considered**:

- JSON translation files for keyless strings.
- Database-backed translations (more complex, not needed for MVP).

## GDPR Export and Deletion

**Decision**: Implement GDPR export and deletion now with asynchronous jobs. Export as ZIP of JSON files, store temporarily with signed URLs. Use pseudonymization for user deletion, and full cascade delete for family deletion.

**Rationale**:

- Satisfies GDPR access and erasure requirements early.
- Async jobs prevent request timeouts and keep UI responsive.
- Pseudonymization preserves shared family history when a user leaves.

**Alternatives considered**:

- Synchronous exports (risk timeouts).
- Only family-level exports (insufficient for per-user requests).
- Hard-delete user data (breaks shared history).
