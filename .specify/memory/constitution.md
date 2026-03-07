<!--
Sync Impact Report

Version change: 0.2.1 → 0.2.2 (Database changed to MySQL)
Modified principles: N/A
Added sections: N/A
Removed sections: N/A
Clarifications: Scope updated to MySQL as the database
Templates requiring updates:
  ✅ .specify/templates/spec-template.md (database reference)
  ✅ .specify/templates/plan-template.md (database reference)
  ✅ .specify/templates/tasks-template.md (no changes needed)
Follow-up TODOs: None
-->

# GroundedTime Web Constitution

**Constitution Version**: 0.2.2  
**Ratification Date**: 2026-03-05  
**Last Amended**: 2026-03-07

---

## Scope

This constitution defines the non-negotiable development rules for the **GroundedTime web application**.

The initial version focuses on:

- Web application (responsive for mobile)
- Laravel (PHP 8+)
- Blade templates + TailwindCSS
- MySQL
- REST-style controllers
- Laravel Scheduler + Notifications

Future mobile apps MAY reuse the same backend but are not part of the initial scope.

---

## Core Idea of the Product

GroundedTime helps parents coordinate and track **children restrictions** such as:

- No TV
- No video games
- No phone
- No tablet

Parents can:

- create restrictions
- set start and end times
- see active restrictions
- receive reminders
- stay synchronized with other parents in the same household

---

## Principles (Non-Negotiable)

### I. Keep the product simple

The system exists to solve a simple problem: Parents should never forget a restriction.

Avoid unnecessary features or architecture complexity.

**Rationale**: This is a focused tool for a specific problem. Feature creep would undermine usability and maintainability.

---

### II. Readable code over clever code

Maintainability is more important than clever abstractions.

Prefer clear Laravel conventions.

**Rationale**: The goal is to build software that can be maintained and extended reliably. Code clarity enables faster debugging and safer changes.

---

### III. Mobile-first thinking

Although the system is web-only initially, every UI MUST be responsive and usable on mobile.

**Rationale**: Parents use phones throughout the day. Desktop-only interfaces would miss the primary use case.

---

### IV. User experience first

Parents should be able to:

- see active restrictions immediately
- understand when a restriction ends
- quickly add or remove restrictions

The dashboard MUST prioritize clarity over density.

**Rationale**: The app's value comes from reducing mental load. Confusing interfaces defeat the purpose.

---

### V. Avoid unnecessary dependencies

New dependencies MUST only be introduced if they clearly improve:

- reliability
- development speed
- security

**Rationale**: Each dependency adds maintenance burden and potential attack surface. The benefit must justify the cost.

---

### VI. Test-Driven Development (TDD) — NON-NEGOTIABLE

All code changes MUST follow the Red-Green-Refactor cycle:

1. **Red**: Write a failing test that defines the desired behavior
2. **Green**: Write the minimal code to make the test pass
3. **Refactor**: Improve the code while keeping tests green
4. **Verify**: Run all tests after each change — they MUST pass

**Rules**:

- Tests MUST be written BEFORE implementation
- No implementation code without a failing test first
- Every code change MUST be validated by running the test suite
- All tests MUST pass before committing
- Pull requests with failing tests MUST NOT be merged

**Test Types**:

- **Unit Tests** (tests/Unit/): Test Services and Model logic in isolation
- **Feature Tests** (tests/Feature/): Test full HTTP request/response flows

**Rationale**: TDD prevents regressions, improves design, and ensures every line of code is justified by a test. It catches bugs early when they're cheapest to fix. The discipline of writing tests first leads to better architected, more maintainable code.

---

## Architecture (Lean MVC)

GroundedTime follows a **simple Laravel architecture**.

**Flow**: Controller → Service → Model

### Controllers

Controllers handle:

- HTTP requests
- validation
- response formatting

Controllers MUST NOT contain complex business logic.

---

### Services

Services implement business logic such as:

- creating restrictions
- ending restrictions
- calculating remaining time
- triggering notifications

Services MUST NOT depend on HTTP concerns.

---

### Models

**ORM**: Eloquent (Laravel's ORM) is MANDATORY for all database interactions.

Eloquent models handle:

- database persistence
- relationships
- query scopes
- database queries and eager loading

Models MUST:

- use Eloquent query builder and relationships
- NOT contain complex business workflows
- define scopes for frequently used query patterns
- eager load relations to avoid N+1 queries

**Rationale**: Eloquent is Laravel's native ORM and provides a clean, maintainable abstraction over the database. Consistency in using Eloquent across the project ensures predictable, readable code and eliminates ad-hoc SQL.

---

## Project Structure

```text
app/
  Http/
    Controllers/
  Models/
  Services/
  Notifications/

database/
  migrations/
  seeders/

resources/
  views/
    dashboard/
    restrictions/
    layouts/

routes/
  web.php
```

**Rules**:

- Controllers MUST remain thin
- Business logic MUST live in Services
- Views MUST NOT contain business logic

---

## Database Design Principles

The database MUST remain simple and predictable.

Initial core entities:

### families

Represents a household.

### users

Parents or guardians.

### children

Children belonging to a family.

### restrictions

Represents a punishment or restriction.

Fields SHOULD include:

- title
- description
- child_id
- created_by
- start_at
- end_at
- status

---

## Validation

All external input MUST be validated.

Laravel Form Requests SHOULD be used for:

- creating restrictions
- updating restrictions
- user management

Validation rules MUST live in dedicated request classes.

---

## Notifications & Scheduling

GroundedTime relies on reminders.

The system SHOULD support:

- reminder notifications before a restriction ends
- notification when a restriction expires
- notification when another parent creates a restriction

The Laravel Scheduler MUST handle:

- checking expiring restrictions
- sending reminders

Scheduled jobs MUST be lightweight.

---

## Error Handling

Application errors MUST be consistent.

Controllers MUST return predictable responses.

User-facing errors SHOULD be clear and actionable.

Sensitive internal details MUST NOT be exposed.

---

## Performance Principles

GroundedTime is not a high-traffic system, but basic rules apply.

Queries MUST avoid unnecessary N+1 problems.

Frequently accessed relations SHOULD be eager loaded.

Lists MUST paginate when appropriate.

Heavy jobs MUST be handled via queues when needed.

---

## Security Baseline

The system MUST follow Laravel security best practices.

Requirements:

- CSRF protection enabled
- authentication required for all actions
- authorization checks for family ownership
- secrets stored in environment variables
- sensitive data MUST NOT be logged

---

## Testing Philosophy

**TDD is mandatory** (see Principle VI).

Every feature MUST follow Red-Green-Refactor:

1. Write failing test
2. Implement minimal code to pass
3. Refactor while keeping tests green
4. Run full test suite

Tests MUST focus on:

- **Service logic** (Unit tests in tests/Unit/)
- **Critical user flows** (Feature tests in tests/Feature/)
- **Permission checks** (authorization policies)

Minimum coverage areas:

- restriction creation
- restriction ending
- permission checks
- validation rules

Testing tools:

- PHPUnit (required)
- Laravel test helpers (required)
- Laravel Dusk (if browser testing needed)

**Running tests**:

```bash
php artisan test           # Run all tests
php artisan test --filter [TestName]  # Run specific test
```

---

## Definition of Done

A feature is complete only when:

- tests written FIRST (following TDD)
- migrations exist
- models exist
- controller exists
- service logic exists
- validation exists
- responsive UI exists
- ALL tests pass (php artisan test)
- no debug statements remain
- no uncommitted code with failing tests

---

## Non-Goals

GroundedTime intentionally avoids:

- complex microservice architecture
- unnecessary abstractions
- premature optimization
- heavy frontend frameworks

**The goal is simple and reliable software.**

---

## Governance

### Branch Naming

Branches MUST follow this convention:

```text
feature/GT-<number>
bug-fix/GT-<number>
```

Examples:

- `feature/GT-1`
- `feature/GT-12`
- `bug-fix/GT-4`

---

### Amendment Procedure

Changes to this constitution MUST:

- be proposed via pull request
- update the Last Amended date
- include a version bump rationale

---

### Versioning Policy (SemVer)

**MAJOR**: Breaking governance change.  
**MINOR**: New principle or section added.  
**PATCH**: Clarifications or wording improvements.

---

### Compliance Expectations

Reviewers MUST ensure that:

- new code respects Laravel conventions
- controllers remain thin
- services contain business logic
- UI remains responsive
- code remains simple and readable
