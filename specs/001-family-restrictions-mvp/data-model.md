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
- locale (string, nullable, default: en)
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
- joined_at

Note: No role distinction — all family members have equal access.

### FamilyInvite

- id
- family_id
- email
- token
- expires_at
- accepted_at (nullable)
- created_at

### RestrictionCategory

- id
- family_id (nullable — null means system default, visible to all families)
- name (required, max 60)
- icon (string — identifier from predefined icon set, e.g. "gamepad", "phone", "tv")
- is_system (boolean, default false — system categories cannot be deleted)
- created_at, updated_at

Relationships:

- belongs to Family (nullable)
- has many Restrictions

System defaults (seeded): Gaming, Social Media, Screen Time, Phone, Tablet, Going Out, Other

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
- category_id (FK to restriction_categories, required)
- title (required, max 120)
- description (nullable)
- status (enum: scheduled, active, ended)
- starts_at (timestamp)
- ends_at (nullable timestamp — null means indefinite)
- created_by (user_id)
- ended_by (nullable user_id)
- ended_at (nullable timestamp)
- created_at, updated_at

Relationships:

- belongs to Family
- belongs to RestrictionCategory
- belongs to Child (optional)
- belongs to User (creator)
- belongs to User (ender)

State transitions:

- scheduled -> active (scheduler activates when starts_at arrives)
- active -> ended (manual "End Now" or auto-expire when ends_at passes)

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
- RestrictionCategory name: required, max length 60.
- RestrictionCategory icon: required, must be in predefined icon set.
- Restriction title: required, max length 120.
- Restriction category_id: required, must belong to family or be a system category.
- Restriction starts_at: required.
- Restriction ends_at: nullable, must be after starts_at when provided.
- Invite token: unique, expires in 7 days.

## Indexing Suggestions

- restriction_categories: index on family_id, is_system
- restrictions: index on family_id, status, ends_at, starts_at
- family_invites: index on token, expires_at
- notification_preferences: index on user_id
- export_requests: index on requester_id, status

## Data Access Rules

- All queries scoped by family_id.
- Eager load creator, child, and family relations to avoid N+1.
- Use soft deletes only where needed for GDPR workflows (users, exports).
