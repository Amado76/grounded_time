# Tasks: Family Restrictions Management MVP

**Input**: Design documents from `specs/001-family-restrictions-mvp/`
**Prerequisites**: plan.md (required), spec.md (required for user stories), research.md, data-model.md, contracts/

**TDD WORKFLOW (MANDATORY)**: All implementation tasks MUST follow Red-Green-Refactor:

1. Red: Write a failing test that defines desired behavior
2. Green: Write minimal code to make the test pass
3. Refactor: Improve code while keeping tests green
4. Verify: Run `php artisan test` — all tests MUST pass

**Organization**: Tasks are grouped by user story to enable independent implementation and testing of each story.

---

## Phase 1: Setup (Shared Infrastructure)

**Purpose**: Project initialization and basic structure

- [ ] T001 Confirm MySQL connection defaults in config/database.php
- [ ] T002 Create base Blade layout in resources/views/layouts/app.blade.php
- [ ] T003 [P] Add locale folders in resources/lang/pt_BR, resources/lang/en, resources/lang/es
- [ ] T004 Add locale middleware in app/Http/Middleware/SetLocale.php and register in app/Http/Kernel.php
- [ ] T005 [P] Add basic navigation partial in resources/views/layouts/\_nav.blade.php
- [ ] T006 Configure default locale and fallback in config/app.php (pt_BR + en)

---

## Phase 2: Foundational (Blocking Prerequisites)

**Purpose**: Core infrastructure that MUST be complete before ANY user story can be implemented

- [ ] T007 Create family authorization policy in app/Policies/FamilyPolicy.php and register in app/Providers/AuthServiceProvider.php
- [ ] T008 Add route group scaffolding in routes/web.php (auth middleware + family scoping)
- [ ] T009 Create base Service classes folder and README in app/Services/README.md (service conventions)
- [ ] T010 Create base migration for family pivot roles enum in database/migrations/YYYY_MM_DD_create_family_user_table.php
- [ ] T011 [P] Update User model relations in app/Models/User.php for families and restrictions
- [ ] T012 [P] Add family scope helper in app/Models/Family.php

**Checkpoint**: Foundation ready - user story implementation can now begin

---

## Phase 3: User Story 1 - Authentication & Family Setup (Priority: P1)

**Goal**: Users can sign up, create a family, invite a partner, remove members, and recover access via password reset

**Independent Test**: Create account, create family, send invite, accept invite, remove a member, and complete password reset

### Red: Tests for User Story 1 (WRITE FIRST - MUST FAIL)

- [ ] T013 [P] [US1] Feature test for signup + family creation in tests/Feature/AuthTest.php
- [ ] T014 [P] [US1] Feature test for invite flow + expiry in tests/Feature/FamilyInviteTest.php
- [ ] T015 [P] [US1] Feature test for member removal in tests/Feature/FamilyInviteTest.php
- [ ] T016 [P] [US1] Feature test for password reset flow in tests/Feature/AuthTest.php
- [ ] T017 [P] [US1] Unit test for FamilyService in tests/Unit/FamilyServiceTest.php
- [ ] T018 [P] [US1] Unit test for FamilyInviteService in tests/Unit/FamilyInviteServiceTest.php

### Implementation for User Story 1

- [ ] T019 [US1] Create families migration in database/migrations/YYYY_MM_DD_create_families_table.php (include timezone default)
- [ ] T020 [US1] Create family_invites migration in database/migrations/YYYY_MM_DD_create_family_invites_table.php (include expires_at)
- [ ] T021 [P] [US1] Create Family model in app/Models/Family.php
- [ ] T022 [P] [US1] Create FamilyUser model in app/Models/FamilyUser.php
- [ ] T023 [P] [US1] Create FamilyInvite model in app/Models/FamilyInvite.php
- [ ] T024 [P] [US1] Create StoreFamilyRequest in app/Http/Requests/StoreFamilyRequest.php
- [ ] T025 [P] [US1] Create InviteFamilyMemberRequest in app/Http/Requests/InviteFamilyMemberRequest.php
- [ ] T026 [US1] Implement FamilyService in app/Services/FamilyService.php
- [ ] T027 [US1] Implement FamilyInviteService in app/Services/FamilyInviteService.php (enforce expires_at)
- [ ] T028 [US1] Create AuthController in app/Http/Controllers/AuthController.php (includes password reset actions)
- [ ] T029 [US1] Create FamilyController in app/Http/Controllers/FamilyController.php (includes member removal)
- [ ] T030 [US1] Create FamilyInviteController in app/Http/Controllers/FamilyInviteController.php
- [ ] T031 [US1] Add auth + family routes in routes/web.php (include password reset routes)
- [ ] T032 [P] [US1] Create auth views in resources/views/auth/\*.blade.php
- [ ] T033 [P] [US1] Create family views in resources/views/family/\*.blade.php
- [ ] T034 [P] [US1] Create password reset views in resources/views/auth/passwords/\*.blade.php
- [ ] T035 [US1] Add FamilyInviteNotification in app/Notifications/FamilyInviteNotification.php

**Checkpoint**: User Story 1 is fully functional and testable independently

---

## Phase 4: User Story 2 - Create and Edit Restrictions (Priority: P2)

**Goal**: Users can create, edit, and end restrictions

**Independent Test**: Create a restriction, edit it, end it, and see correct status changes

### Red: Tests for User Story 2 (WRITE FIRST - MUST FAIL)

- [ ] T036 [P] [US2] Feature test for restriction CRUD in tests/Feature/RestrictionFlowsTest.php
- [ ] T037 [P] [US2] Unit test for RestrictionService in tests/Unit/RestrictionServiceTest.php

### Implementation for User Story 2

- [ ] T038 [US2] Create restriction_categories migration in database/migrations/YYYY_MM_DD_create_restriction_categories_table.php
- [ ] T038A [US2] Seed system default categories (Gaming, Social Media, Screen Time, Phone, Tablet, Going Out, Other) in database/seeders/RestrictionCategorySeeder.php
- [ ] T038B [P] [US2] Create RestrictionCategory model in app/Models/RestrictionCategory.php
- [ ] T038C [US2] Create restrictions migration in database/migrations/YYYY_MM_DD_create_restrictions_table.php (include category_id, status enum: scheduled/active/ended)
- [ ] T039 [P] [US2] Create Restriction model in app/Models/Restriction.php
- [ ] T040 [P] [US2] Create StoreRestrictionRequest in app/Http/Requests/StoreRestrictionRequest.php
- [ ] T041 [P] [US2] Create UpdateRestrictionRequest in app/Http/Requests/UpdateRestrictionRequest.php
- [ ] T042 [P] [US2] Create EndRestrictionRequest in app/Http/Requests/EndRestrictionRequest.php
- [ ] T043 [US2] Implement RestrictionService in app/Services/RestrictionService.php
- [ ] T044 [US2] Create RestrictionController in app/Http/Controllers/RestrictionController.php
- [ ] T045 [US2] Add restriction routes in routes/web.php
- [ ] T046 [P] [US2] Create restriction views in resources/views/restrictions/\*.blade.php (include category icon selector and scheduled start date)
- [ ] T046A [US2] Add vanilla JS countdown timer to active restriction cards (reads data-ends-at timestamp attribute, no extra dependency)
- [ ] T047 [US2] Add AutoEndRestrictionsJob in app/Jobs/AutoEndRestrictionsJob.php (auto-end active restrictions past ends_at, activate scheduled restrictions past starts_at, respect family timezone)
- [ ] T048 [US2] Register auto-end/auto-activate schedule in app/Console/Kernel.php (runs every minute)

**Checkpoint**: User Story 2 is fully functional and testable independently

---

## Phase 5: User Story 3 - View Active Restrictions & History (Priority: P3)

**Goal**: Users can view active restrictions and historical restrictions

**Independent Test**: Create active and ended restrictions and verify dashboard and history views

### Red: Tests for User Story 3 (WRITE FIRST - MUST FAIL)

- [ ] T049 [P] [US3] Feature test for dashboard active list in tests/Feature/RestrictionFlowsTest.php
- [ ] T050 [P] [US3] Feature test for history list in tests/Feature/RestrictionFlowsTest.php

### Implementation for User Story 3

- [ ] T051 [US3] Add query scopes in app/Models/Restriction.php for active, scheduled, and ended
- [ ] T052 [US3] Add history controller action in app/Http/Controllers/RestrictionController.php
- [ ] T053 [US3] Add history route in routes/web.php
- [ ] T054 [P] [US3] Add history view in resources/views/restrictions/history.blade.php (with child filter)
- [ ] T055 [US3] Update dashboard view in resources/views/restrictions/index.blade.php (Active / Scheduled / Completed tabs + child filter)

**Checkpoint**: User Story 3 is fully functional and testable independently

---

## Phase 6: User Story 4 - Email & Browser Notifications (Priority: P4)

**Goal**: Users receive email notifications and can manage notification preferences

**Independent Test**: Create and edit a restriction and verify email notifications and preference toggles

### Red: Tests for User Story 4 (WRITE FIRST - MUST FAIL)

- [ ] T056 [P] [US4] Feature test for notification preferences in tests/Feature/NotificationPreferencesTest.php
- [ ] T057 [P] [US4] Feature test for restriction email notifications in tests/Feature/RestrictionFlowsTest.php

### Implementation for User Story 4

- [ ] T058 [US4] Create notification_preferences migration in database/migrations/YYYY_MM_DD_create_notification_preferences_table.php
- [ ] T059 [P] [US4] Create NotificationPreference model in app/Models/NotificationPreference.php
- [ ] T060 [P] [US4] Create UpdateNotificationPreferenceRequest in app/Http/Requests/UpdateNotificationPreferenceRequest.php
- [ ] T061 [US4] Create NotificationPreferenceController in app/Http/Controllers/NotificationPreferenceController.php
- [ ] T062 [US4] Implement NotificationService in app/Services/NotificationService.php
- [ ] T063 [US4] Add notification routes in routes/web.php
- [ ] T064 [P] [US4] Add notifications settings view in resources/views/settings/notifications.blade.php
- [ ] T065 [P] [US4] Add RestrictionCreatedNotification in app/Notifications/RestrictionCreatedNotification.php
- [ ] T066 [P] [US4] Add RestrictionUpdatedNotification in app/Notifications/RestrictionUpdatedNotification.php
- [ ] T067 [P] [US4] Add RestrictionEndedNotification in app/Notifications/RestrictionEndedNotification.php
- [ ] T068 [US4] Add SendDailyReminderJob in app/Jobs/SendDailyReminderJob.php (use family timezone)
- [ ] T069 [US4] Register daily reminder schedule in app/Console/Kernel.php (respect family timezone)
- [ ] T070 [US4] Optional: integrate web push channel in app/Notifications (requires dependency approval)

**Checkpoint**: User Story 4 is fully functional and testable independently

---

## Phase 7: User Story 5 - Manage Children (Priority: P5)

**Goal**: Users can add children and associate restrictions with a child

**Independent Test**: Create children and verify restrictions can be assigned and filtered

### Red: Tests for User Story 5 (WRITE FIRST - MUST FAIL)

- [ ] T071 [P] [US5] Feature test for children management in tests/Feature/ChildTest.php

### Implementation for User Story 5

- [ ] T072 [US5] Create children migration in database/migrations/YYYY_MM_DD_create_children_table.php
- [ ] T073 [P] [US5] Create Child model in app/Models/Child.php
- [ ] T074 [P] [US5] Create StoreChildRequest in app/Http/Requests/StoreChildRequest.php
- [ ] T075 [P] [US5] Create UpdateChildRequest in app/Http/Requests/UpdateChildRequest.php
- [ ] T076 [US5] Create ChildController in app/Http/Controllers/ChildController.php
- [ ] T077 [US5] Add children routes in routes/web.php
- [ ] T078 [P] [US5] Create child views in resources/views/children/\*.blade.php
- [ ] T079 [US5] Update restriction form to include child selector in resources/views/restrictions/\_form.blade.php
- [ ] T080 [US5] Add child filter on active list in resources/views/restrictions/index.blade.php

**Checkpoint**: User Story 5 is fully functional and testable independently

---

## Phase 7B: Restriction Categories Management

**Goal**: Family members can manage custom restriction categories with icons

**Independent Test**: Create a custom category, use it in a restriction, verify icon displays throughout UI

### Red: Tests for Categories (WRITE FIRST - MUST FAIL)

- [ ] T098 [P] Feature test for category CRUD in tests/Feature/RestrictionCategoryTest.php
- [ ] T099 [P] Unit test for category validation (system categories cannot be deleted) in tests/Unit/RestrictionCategoryTest.php

### Implementation for Categories

- [ ] T100 [P] Create RestrictionCategoryController in app/Http/Controllers/RestrictionCategoryController.php
- [ ] T101 [P] Create StoreRestrictionCategoryRequest in app/Http/Requests/StoreRestrictionCategoryRequest.php
- [ ] T102 [P] Create UpdateRestrictionCategoryRequest in app/Http/Requests/UpdateRestrictionCategoryRequest.php
- [ ] T103 Add category routes in routes/web.php (GET/POST /categories, PATCH/DELETE /categories/{category})
- [ ] T104 [P] Create category views in resources/views/categories/\*.blade.php (list + form with icon picker)
- [ ] T105 Add predefined icon set list in config/icons.php (identifiers mapped to SVG paths or Heroicons names)

**Checkpoint**: Categories are manageable and usable in restriction forms

---

## Phase 7C: Analytics

**Goal**: Users can view family restriction statistics and charts

**Independent Test**: Create several restrictions across days and children, verify analytics page shows correct counts and chart data

### Red: Tests for Analytics (WRITE FIRST - MUST FAIL)

- [ ] T106 [P] Feature test for analytics page in tests/Feature/AnalyticsTest.php
- [ ] T107 [P] Unit test for AnalyticsService data aggregation in tests/Unit/AnalyticsServiceTest.php

### Implementation for Analytics

- [ ] T108 Implement AnalyticsService in app/Services/AnalyticsService.php (active count, weekly count, compliance rate, breakdown by category, frequency by day)
- [ ] T109 Create AnalyticsController in app/Http/Controllers/AnalyticsController.php
- [ ] T110 Add analytics route in routes/web.php (GET /analytics)
- [ ] T111 [P] Create analytics view in resources/views/analytics/index.blade.php (stats cards + Chart.js charts loaded via CDN)

**Checkpoint**: Analytics page shows live data with charts

---

## Phase 8: Polish & Cross-Cutting Concerns

**Purpose**: Cross-cutting requirements not owned by a single user story

- [ ] T081 Add GDPR export models in app/Models/ExportRequest.php
- [ ] T082 Add export requests migration in database/migrations/YYYY_MM_DD_create_export_requests_table.php
- [ ] T083 Add GdprController in app/Http/Controllers/GdprController.php
- [ ] T084 Add GdprExportService in app/Services/GdprExportService.php
- [ ] T085 Add GdprDeletionService in app/Services/GdprDeletionService.php
- [ ] T086 [P] Add GDPR export/deletion views in resources/views/settings/privacy.blade.php
- [ ] T087 Add ExportUserDataJob in app/Jobs/ExportUserDataJob.php
- [ ] T088 Add ExportFamilyDataJob in app/Jobs/ExportFamilyDataJob.php
- [ ] T089 Add FinalizeDeletionJob in app/Jobs/FinalizeDeletionJob.php
- [ ] T090 Add GDPR routes in routes/web.php
- [ ] T091 Add tests for GDPR flows in tests/Feature/GdprExportDeletionTest.php
- [ ] T092 Add locale preference UI in resources/views/settings/language.blade.php
- [ ] T093 Add user locale field to users migration (new migration) in database/migrations/YYYY_MM_DD_add_locale_to_users_table.php
- [ ] T094 Add locale update controller logic in app/Http/Controllers/UserSettingsController.php
- [ ] T095 Add locale update route in routes/web.php
- [ ] T096 Add logging for failed jobs in app/Exceptions/Handler.php (all queued jobs)
- [ ] T097 Add critical error email alerts for scheduler + queue failures

---

## Dependencies

- US1 blocks US2 and US3 (auth + family context required)
- US2 blocks US3 (needs restrictions data)
- US2 blocks Categories Phase 7B (restriction form requires category model)
- US4 depends on US2 (notifications tied to restriction lifecycle)
- US5 can run after US1 but integrates with US2
- Analytics Phase 7C depends on US2 + US5 (needs restrictions and children data)
- Cross-cutting phase depends on US1 (auth) and US2 (restrictions)

---

## Parallel Execution Examples

- US1: T021-T025 and T032-T035 can run in parallel after migrations start
- US2: T039-T042 and T046 can run in parallel after migration created
- US3: T054 can run in parallel with T051-T053
- US4: T065-T067 can run in parallel with T058-T062
- US5: T073-T078 can run in parallel after migration

---

## Implementation Strategy

- Start with MVP core: US1 -> US2 (with categories + countdown) -> US3
- Add notifications (US4) once restriction lifecycle is stable
- Add children management (US5) after core flows are tested
- Add analytics (Phase 7C) after US5 (needs children data for charts)
- Implement GDPR and localization settings in final polish phase
- Chart.js loaded via CDN — no npm required for analytics charts
