# Implementation Plan: Family Restrictions Management MVP

**Branch**: `001-family-restrictions-mvp` | **Date**: 2026-03-07 | **Spec**: specs/001-family-restrictions-mvp/spec.md
**Input**: Feature specification from `specs/001-family-restrictions-mvp/spec.md`

## Summary

Deliver a Laravel web MVP for family-based restriction management with authentication, shared family data, restriction lifecycle, notifications (email, optional browser push), GDPR export/deletion, multi-language UI (pt-BR, en, es), and family-level timezone scheduling. Implementation follows Controller -> Service -> Model with Eloquent, uses Blade + Tailwind for mobile-first UI, and enforces TDD.

## Technical Context

**Language/Version**: PHP 8+  
**Primary Dependencies**: Laravel, Blade templates, TailwindCSS, Eloquent ORM  
**Storage**: MySQL  
**Testing**: PHPUnit, Laravel test helpers  
**Target Platform**: Web (responsive for mobile)  
**Project Type**: web-application (Laravel MVC + Services)  
**Notifications**: Laravel Notifications (mail), optional web push (see research)  
**Jobs/Queues**: Laravel queues for exports, reminders, auto-expire  
**I18n**: Laravel localization (lang/ files), user locale preference  
**Performance Goals**: Standard web response times (<200ms p95 for core actions)  
**Constraints**: Mobile-first UI, simple architecture (no microservices), avoid unnecessary dependencies  
**Scale/Scope**: Small household use (dozens of users per family, not high-traffic)

## Constitution Check

_GATE: Must pass before Phase 0 research. Re-check after Phase 1 design._

Reference: `.specify/memory/constitution.md`

**Required checks for GroundedTime**:

- [x] **Simplicity**: Feature set limited to family auth, restrictions, and notifications.
- [x] **Readable code**: Use standard Laravel conventions and clear service boundaries.
- [x] **Mobile-first**: Blade views designed for responsive layouts.
- [x] **User experience**: Dashboard shows active restrictions first; quick actions kept minimal.
- [x] **Dependencies**: Only add web push package if required for MVP; otherwise defer.
- [x] **TDD (NON-NEGOTIABLE)**: Tests planned before implementation for all flows.
- [x] **Architecture**: Controller -> Service -> Model preserved.
- [x] **Thin controllers**: Controllers only validate and route to services.
- [x] **Business logic in Services**: Restriction, invite, GDPR, and notification logic in services.
- [x] **Definition of Done**: Includes migrations, models, validation, UI, and passing tests.

**Notes on complexity**:
No constitution violations. Optional browser push is scoped as a stretch to avoid dependency bloat.

## Project Structure

### Documentation (this feature)

```text
specs/001-family-restrictions-mvp/
├── plan.md
├── research.md
├── data-model.md
├── quickstart.md
├── contracts/
│   └── http-routes.md
└── tasks.md
```

### Source Code (repository root)

```text
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   ├── FamilyController.php
│   │   ├── FamilyInviteController.php
│   │   ├── RestrictionController.php
│   │   ├── ChildController.php
│   │   ├── NotificationPreferenceController.php
│   │   └── GdprController.php
│   └── Requests/
│       ├── StoreFamilyRequest.php
│       ├── InviteFamilyMemberRequest.php
│       ├── StoreRestrictionRequest.php
│       ├── UpdateRestrictionRequest.php
│       ├── EndRestrictionRequest.php
│       ├── StoreChildRequest.php
│       ├── UpdateChildRequest.php
│       └── UpdateNotificationPreferenceRequest.php
├── Models/
│   ├── Family.php
│   ├── FamilyUser.php
│   ├── FamilyInvite.php
│   ├── Child.php
│   ├── Restriction.php
│   ├── RestrictionEvent.php
│   ├── NotificationPreference.php
│   └── ExportRequest.php
├── Services/
│   ├── FamilyService.php
│   ├── FamilyInviteService.php
│   ├── RestrictionService.php
│   ├── NotificationService.php
│   ├── GdprExportService.php
│   └── GdprDeletionService.php
├── Notifications/
│   ├── RestrictionCreatedNotification.php
│   ├── RestrictionUpdatedNotification.php
│   ├── RestrictionEndedNotification.php
│   ├── DailyReminderNotification.php
│   └── FamilyInviteNotification.php
└── Jobs/
  ├── AutoEndRestrictionsJob.php
  ├── SendDailyReminderJob.php
  ├── ExportUserDataJob.php
  ├── ExportFamilyDataJob.php
  └── FinalizeDeletionJob.php

database/
├── migrations/
│   ├── YYYY_MM_DD_create_families_table.php
│   ├── YYYY_MM_DD_create_family_user_table.php
│   ├── YYYY_MM_DD_create_family_invites_table.php
│   ├── YYYY_MM_DD_create_children_table.php
│   ├── YYYY_MM_DD_create_restrictions_table.php
│   ├── YYYY_MM_DD_create_restriction_events_table.php
│   ├── YYYY_MM_DD_create_notification_preferences_table.php
│   └── YYYY_MM_DD_create_export_requests_table.php
└── seeders/

resources/
├── views/
│   ├── auth/
│   ├── family/
│   ├── restrictions/
│   ├── children/
│   ├── settings/
│   └── layouts/
└── lang/
  ├── en/
  ├── es/
  └── pt_BR/

routes/
└── web.php

tests/
├── Feature/
│   ├── AuthTest.php
│   ├── FamilyInviteTest.php
│   ├── RestrictionFlowsTest.php
│   ├── NotificationPreferencesTest.php
│   └── GdprExportDeletionTest.php
└── Unit/
  ├── RestrictionServiceTest.php
  ├── FamilyInviteServiceTest.php
  └── GdprExportServiceTest.php
```

**Structure Decision**: Use standard Laravel controllers, form requests, services, Eloquent models, notifications, and jobs to keep logic separated and testable.

## Phase 0: Research

Artifacts: `research.md`

Topics resolved:

- Browser push notifications approach for MVP
- Laravel localization and user locale handling
- GDPR export and deletion patterns

## Phase 1: Design

Artifacts:

- `data-model.md`
- `contracts/http-routes.md`
- `quickstart.md`

Agent context updated via `.specify/scripts/bash/update-agent-context.sh copilot`.

## Constitution Check (Post-Design)

All checks pass. No additional dependencies required beyond Laravel defaults; web push remains optional.

## Phase 2: Implementation Plan (High-Level)

1. Auth + family setup + invites flow with tests first.
2. Restriction CRUD + end-now + auto-expire job.
3. Notifications: email + daily reminders + preference settings.
4. Localization middleware + language preference UI.
5. GDPR export/deletion flows with queued jobs and signed URLs.
6. Optional browser push if time permits and dependency approved.
