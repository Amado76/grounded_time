# Data Model: Family Restrictions MVP

## Entities and Fields

### Family

- id
- name
- timezone (string, default: America/Sao_Paulo)
- created_at, updated_at

Relationships:

- has many Users (through family_user)
- has many Children
- has many Restrictions
- has many FamilyInvites

### User

- id
- name
- email
- password
- locale (string, nullable, default: pt_BR)
- email_verified_at, remember_token
- created_at, updated_at

Relationships:

- belongs to many Families (through family_user)
- has one NotificationPreference
- has many Restrictions (created_by)
- has many Restrictions (ended_by)

### FamilyUser (pivot)

- family_id
- user_id
- role (enum: creator, member)
- joined_at

### FamilyInvite

- id
- family_id
- email
- token
- expires_at
- accepted_at (nullable)
- created_at

### Child (optional MVP)

- id
- family_id
- name (required)
- photo_url (nullable)
- created_at, updated_at

Relationships:

- belongs to Family
- has many Restrictions

### Restriction

- id
- family_id
- child_id (nullable)
- title (required)
- description (nullable)
- status (enum: active, ended)
- starts_at
- ends_at (nullable, null means indefinite)
- created_by (user_id)
- ended_by (nullable user_id)
- ended_at (nullable)
- created_at, updated_at

Relationships:

- belongs to Family
- belongs to Child (optional)
- belongs to User (creator)
- belongs to User (ender)

State transitions:

- active -> ended (manual end or auto-expire)

### RestrictionEvent (optional)

- id
- restriction_id
- action (created, edited, ended)
- payload_json
- actor_id
- created_at

### NotificationPreference

- id
- user_id
- email_enabled (bool, default true)
- browser_enabled (bool, default false)
- daily_reminder_time (time, default 08:00)
- created_at, updated_at

### ExportRequest (GDPR)

- id
- requester_id
- scope (user, family)
- status (pending, processing, ready, expired, failed)
- file_path
- expires_at
- created_at, updated_at

## Validation Rules

- Family name: required, max length 100.
- User email: valid format, unique.
- Password: min 8 chars.
- Child name: required, max length 100.
- Restriction title: required, max length 120.
- Restriction starts_at: required.
- Restriction ends_at: nullable, must be after starts_at when provided.
- Invite token: unique, expires in 7 days.

## Indexing Suggestions

- restrictions: index on family_id, status, ends_at
- family_invites: index on token, expires_at
- notification_preferences: index on user_id
- export_requests: index on requester_id, status

## Data Access Rules

- All queries scoped by family_id.
- Eager load creator, child, and family relations to avoid N+1.
- Use soft deletes only where needed for GDPR workflows (users, exports).
