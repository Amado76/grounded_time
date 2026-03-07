# HTTP Routes Contract

All routes require authentication unless specified.

## Auth

- GET /login
- POST /login
- GET /register
- POST /register
- POST /logout
- GET /password/reset
- POST /password/email
- GET /password/reset/{token}
- POST /password/reset

## Family

- GET /family
- POST /family
- PATCH /family

## Family Members

- GET /family/members
- POST /family/invites
- POST /family/invites/{token}/accept
- DELETE /family/members/{user}

## Children

- GET /children
- POST /children
- PATCH /children/{child}
- DELETE /children/{child}

## Restrictions

- GET /restrictions
- GET /restrictions/history
- GET /restrictions/create
- POST /restrictions
- GET /restrictions/{restriction}/edit
- PATCH /restrictions/{restriction}
- POST /restrictions/{restriction}/end

## Notification Preferences

- GET /settings/notifications
- PATCH /settings/notifications

## Language Preferences

- GET /settings/language
- PATCH /settings/language

## GDPR

- GET /settings/privacy
- POST /gdpr/exports
- GET /gdpr/exports/{exportRequest}
- POST /gdpr/deletions

## System (internal)

- POST /jobs/auto-end-restrictions
- POST /jobs/daily-reminders
