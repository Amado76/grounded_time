---
description: "Task list template for feature implementation"
---

# Tasks: [FEATURE NAME]

**Input**: Design documents from `/specs/[###-feature-name]/`
**Prerequisites**: plan.md (required), spec.md (required for user stories), research.md, data-model.md, contracts/

**TDD WORKFLOW (MANDATORY)**: All implementation tasks MUST follow Red-Green-Refactor:

1. 🔴 **Red**: Write a failing test that defines desired behavior
2. ✅ **Green**: Write minimal code to make the test pass
3. 🔄 **Refactor**: Improve code while keeping tests green
4. ▶️ **Verify**: Run `php artisan test` — all tests MUST pass

**Organization**: Tasks are grouped by user story to enable independent implementation and testing of each story.

## Format: `[ID] [P?] [Story] Description`

- **[P]**: Can run in parallel (different files, no dependencies)
- **[Story]**: Which user story this task belongs to (e.g., US1, US2, US3)
- Include exact file paths in descriptions

## Path Conventions

For GroundedTime (Laravel project):

- **Controllers**: `app/Http/Controllers/`
- **Form Requests**: `app/Http/Requests/`
- **Models**: `app/Models/`
- **Services**: `app/Services/`
- **Notifications**: `app/Notifications/`
- **Migrations**: `database/migrations/`
- **Views**: `resources/views/`
- **Routes**: `routes/web.php`
- **Feature Tests**: `tests/Feature/` (HTTP-level)
- **Unit Tests**: `tests/Unit/` (Service/Model logic)

<!--
  ============================================================================
  IMPORTANT: The tasks below are SAMPLE TASKS for illustration purposes only.

  The /speckit.tasks command MUST replace these with actual tasks based on:
  - User stories from spec.md (with their priorities P1, P2, P3...)
  - Feature requirements from plan.md
  - Entities from data-model.md
  - Endpoints from contracts/

  Tasks MUST be organized by user story so each story can be:
  - Implemented independently
  - Tested independently
  - Delivered as an MVP increment

  DO NOT keep these sample tasks in the generated tasks.md file.
  ============================================================================
-->

## Phase 1: Setup (Shared Infrastructure)

**Purpose**: Project initialization and basic structure

- [ ] T001 Create Laravel project structure per implementation plan
- [ ] T002 Configure environment (.env) and database connection
- [ ] T003 [P] Setup TailwindCSS in Laravel asset pipeline

---

## Phase 2: Foundational (Blocking Prerequisites)

**Purpose**: Core infrastructure that MUST be complete before ANY user story can be implemented

**⚠️ CRITICAL**: No user story work can begin until this phase is complete

Examples of foundational tasks for Laravel (adjust based on your project):

- [ ] T004 Create base database schema and migrations (families, users tables)
- [ ] T005 [P] Setup Laravel authentication scaffolding
- [ ] T006 [P] Configure route structure and middleware in routes/web.php
- [ ] T007 Create base Eloquent models that all stories depend on (User, Family)
- [ ] T008 Setup global error handling and logging (Laravel handlers)
- [ ] T009 Create base Blade layout (resources/views/layouts/app.blade.php)
- [ ] T010 [P] Configure Laravel Scheduler if needed
- [ ] T011 [P] Setup family authorization policies

**Checkpoint**: Foundation ready - user story implementation can now begin in parallel

---

## Phase 3: User Story 1 - [Title] (Priority: P1) 🎯 MVP

**Goal**: [Brief description of what this story delivers]

**Independent Test**: [How to verify this story works on its own]

### 🔴 RED: Tests for User Story 1 (WRITE FIRST - MUST FAIL)

> **NOTE: Write these tests FIRST, ensure they FAIL before implementation**

- [ ] T012 [P] [US1] Feature test for [user journey] in tests/Feature/[Feature]Test.php
- [ ] T013 [P] [US1] Unit test for [service logic] in tests/Unit/[Service]Test.php

### Implementation for User Story 1

- [ ] T014 [US1] Create migration: database/migrations/YYYY*MM_DD_create*[table].php
- [ ] T015 [P] [US1] Create Eloquent model: app/Models/[Entity].php
- [ ] T016 [P] [US1] Create Form Request: app/Http/Requests/[Feature]Request.php
- [ ] T017 [US1] Create Service class: app/Services/[Feature]Service.php (depends on T015)
- [ ] T018 [US1] Create Controller: app/Http/Controllers/[Feature]Controller.php (thin, delegates to service)
- [ ] T019 [US1] Define routes in routes/web.php
- [ ] T020 [P] [US1] Create Blade views: resources/views/[feature]/index.blade.php, show.blade.php
- [ ] T021 [US1] Add responsive styling with TailwindCSS (mobile-first)
- [ ] T022 [US1] Add validation error handling in views

**Checkpoint**: At this point, User Story 1 should be fully functional and testable independently

---

## Phase 4: User Story 2 - [Title] (Priority: P2)

**Goal**: [Brief description of what this story delivers]

**Independent Test**: [How to verify this story works on its own]

### 🔴 RED: Tests for User Story 2 (WRITE FIRST - MUST FAIL)

> **TDD STEP 1: These tests MUST be written FIRST and MUST FAIL before any implementation**

- [ ] T028 [P] [US2] 🔴 Write FAILING Feature test: tests/Feature/[Feature]Test.php
- [ ] T029 [P] [US2] 🔴 Write FAILING Unit test: tests/Unit/[Service]Test.php
- [ ] T030 [US2] ▶️ Run `php artisan test` — confirm tests FAIL as expected

### ✅ GREEN: Implementation for User Story 2

> **TDD STEP 2: Write minimal code to make tests pass**

- [ ] T031 [US2] Create migration if needed: database/migrations/YYYY*MM_DD*[table].php
- [ ] T032 [P] [US2] Create/update Eloquent model: app/Models/[Entity].php
- [ ] T033 [P] [US2] Create Form Request: app/Http/Requests/[Feature]Request.php
- [ ] T034 [US2] Create/update Service: app/Services/[Feature]Service.php (minimal implementation)
- [ ] T035 [US2] ▶️ Run `php artisan test` — Unit tests should now PASS
- [ ] T036 [US2] Create Controller: app/Http/Controllers/[Feature]Controller.php
- [ ] T037 [US2] Define routes in routes/web.php
- [ ] T038 [P] [US2] Create Blade views: resources/views/[feature]/[view].blade.php
- [ ] T039 [US2] ▶️ Run `php artisan test` — ALL tests should now PASS

### 🔄 REFACTOR: Polish User Story 2

> **TDD STEP 3: Improve code quality while keeping tests green**

- [ ] T040 [US2] Add responsive styling with TailwindCSS
- [ ] T041 [US2] Integrate with User Story 1 components (if needed)
- [ ] T042 [US2] Refactor for clarity
- [ ] T043 [US2] ▶️ Run `php artisan test` — ALL tests MUST still PASS

**Checkpoint**: At this point, User Stories 1 AND 2 should both work independently

---

## Phase 5: User Story 3 - [Title] (Priority: P3)

**Goal**: [Brief description of what this story delivers]

**Independent Test**: [How to verify this story works on its own]

### 🔴 RED: Tests for User Story 3 (WRITE FIRST - MUST FAIL)

> **TDD STEP 1: These tests MUST be written FIRST and MUST FAIL before any implementation**

- [ ] T044 [P] [US3] 🔴 Write FAILING Feature test: tests/Feature/[Feature]Test.php
- [ ] T045 [P] [US3] 🔴 Write FAILING Unit test: tests/Unit/[Service]Test.php
- [ ] T046 [US3] ▶️ Run `php artisan test` — confirm tests FAIL as expected

### ✅ GREEN: Implementation for User Story 3

> **TDD STEP 2: Write minimal code to make tests pass**

- [ ] T047 [US3] Create migration if needed: database/migrations/YYYY*MM_DD*[table].php
- [ ] T048 [P] [US3] Create/update Eloquent model: app/Models/[Entity].php
- [ ] T049 [P] [US3] Create Form Request: app/Http/Requests/[Feature]Request.php
- [ ] T050 [US3] Create/update Service: app/Services/[Feature]Service.php (minimal implementation)
- [ ] T051 [US3] ▶️ Run `php artisan test` — Unit tests should now PASS
- [ ] T052 [US3] Create Controller: app/Http/Controllers/[Feature]Controller.php
- [ ] T053 [US3] Define routes in routes/web.php
- [ ] T054 [P] [US3] Create Blade views: resources/views/[feature]/[view].blade.php
- [ ] T055 [US3] ▶️ Run `php artisan test` — ALL tests should now PASS

### 🔄 REFACTOR: Polish User Story 3

> **TDD STEP 3: Improve code quality while keeping tests green**

- [ ] T056 [US3] Add responsive styling with TailwindCSS
- [ ] T057 [US3] Refactor for clarity
- [ ] T058 [US3] ▶️ Run `php artisan test` — ALL tests MUST still PASS

**Checkpoint**: All user stories should now be independently functional

---

[Add more user story phases as needed, following the same pattern]

---

## Phase N: Polish & Cross-Cutting Concerns

**Purpose**: Improvements that affect multiple user stories

- [ ] TXXX [P] Documentation updates in docs/
- [ ] TXXX Code cleanup and refactoring
- [ ] TXXX Performance optimization across all stories
- [ ] TXXX [P] Additional unit tests (if requested) in tests/unit/
- [ ] TXXX Security hardening
- [ ] TXXX Run quickstart.md validation

---

## Dependencies & Execution Order

### Phase Dependencies

- **Setup (Phase 1)**: No dependencies - can start immediately
- **Foundational (Phase 2)**: Depends on Setup completion - BLOCKS all user stories
- **User Stories (Phase 3+)**: All depend on Foundational phase completion
  - User stories can then proceed in parallel (if staffed)
  - Or sequentially in priority order (P1 → P2 → P3)
- **Polish (Final Phase)**: Depends on all desired user stories being complete

### User Story Dependencies

- **User Story 1 (P1)**: Can start after Foundational (Phase 2) - No dependencies on other stories
- **User Story 2 (P2)**: Can start after Foundational (Phase 2) - May integrate with US1 but should be independently testable
- **User Story 3 (P3)**: Can start after Foundational (Phase 2) - May integrate with US1/US2 but should be independently testable

### Within Each User Story

- Tests (if included) MUST be written and FAIL before implementation
- Models before services
- Services before endpoints
- Core implementation before integration
- Story complete before moving to next priority

### Parallel Opportunities

- All Setup tasks marked [P] can run in parallel
- All Foundational tasks marked [P] can run in parallel (within Phase 2)
- Once Foundational phase completes, all user stories can start in parallel (if team capacity allows)
- All tests for a user story marked [P] can run in parallel
- Models within a story marked [P] can run in parallel
- Different user stories can be worked on in parallel by different team members

---

## Parallel Example: User Story 1

```bash
# Launch all tests for User Story 1 together (if tests requested):
Task: "Feature test for [user journey] in tests/Feature/[Feature]Test.php"
Task: "Unit test for [service logic] in tests/Unit/[Service]Test.php"

# Launch all Laravel components for User Story 1 together when possible:
Task: "Create Eloquent model: app/Models/[Entity].php"
Task: "Create Form Request: app/Http/Requests/[Feature]Request.php"
Task: "Create Blade view: resources/views/[feature]/index.blade.php"
```

---

## Implementation Strategy

### MVP First (User Story 1 Only)

1. Complete Phase 1: Setup
2. Complete Phase 2: Foundational (CRITICAL - blocks all stories)
3. Complete Phase 3: User Story 1
4. **STOP and VALIDATE**: Test User Story 1 independently
5. Deploy/demo if ready

### Incremental Delivery

1. Complete Setup + Foundational → Foundation ready
2. Add User Story 1 → Test independently → Deploy/Demo (MVP!)
3. Add User Story 2 → Test independently → Deploy/Demo
4. Add User Story 3 → Test independently → Deploy/Demo
5. Each story adds value without breaking previous stories

### Parallel Team Strategy

With multiple developers:

1. Team completes Setup + Foundational together
2. Once Foundational is done:
   - Developer A: User Story 1
   - Developer B: User Story 2
   - Developer C: User Story 3
3. Stories complete and integrate independently

---

## Notes

- [P] tasks = different files, no dependencies
- [Story] label maps task to specific user story for traceability
- Each user story should be independently completable and testable
- Verify tests fail before implementing
- Commit after each task or logical group
- Stop at any checkpoint to validate story independently
- Avoid: vague tasks, same file conflicts, cross-story dependencies that break independence
