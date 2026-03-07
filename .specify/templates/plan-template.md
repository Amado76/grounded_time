# Implementation Plan: [FEATURE]

**Branch**: `[###-feature-name]` | **Date**: [DATE] | **Spec**: [link]
**Input**: Feature specification from `/specs/[###-feature-name]/spec.md`

**Note**: This template is filled in by the `/speckit.plan` command. See `.specify/templates/plan-template.md` for the execution workflow.

## Summary

[Extract from feature spec: primary requirement + technical approach from research]

## Technical Context

<!--
  ACTION REQUIRED: Update values below based on feature requirements.
  Default values reflect GroundedTime constitution (Laravel web app).
-->

**Language/Version**: PHP 8+  
**Primary Dependencies**: Laravel, Blade templates, TailwindCSS  
**Storage**: PostgreSQL  
**Testing**: PHPUnit, Laravel test helpers  
**Target Platform**: Web (responsive for mobile)  
**Project Type**: web-application (Laravel MVC + Services)  
**Performance Goals**: Standard web response times (<200ms p95 for core actions)  
**Constraints**: Mobile-first UI, simple architecture (no microservices)  
**Scale/Scope**: Small household use (dozens of users per family, not high-traffic)

## Constitution Check

_GATE: Must pass before Phase 0 research. Re-check after Phase 1 design._

Reference: `.specify/memory/constitution.md`

**Required checks for GroundedTime**:

- [ ] **Simplicity**: Does this feature add unnecessary complexity? Can it be simpler?
- [ ] **Readable code**: Is the approach clear and maintainable using Laravel conventions?
- [ ] **Mobile-first**: Is the UI responsive and mobile-friendly?
- [ ] **User experience**: Does the feature reduce mental load and provide immediate clarity?
- [ ] **Dependencies**: Are new dependencies justified (reliability, speed, security)?
- [ ] **TDD (NON-NEGOTIABLE)**: Will tests be written FIRST before implementation? Is Red-Green-Refactor cycle planned?
- [ ] **Architecture**: Does it follow Controller → Service → Model pattern?
- [ ] **Thin controllers**: Controllers only handle HTTP, validation, response formatting?
- [ ] **Business logic in Services**: Core logic lives in Service classes, not Controllers or Models?
- [ ] **Definition of Done**: Plans include TDD workflow, migrations, models, controllers, services, validation, responsive UI, all tests passing?

**Notes on complexity**:
[Document any justified complexity or unusual architectural decisions]

## Project Structure

### Documentation (this feature)

```text
specs/[###-feature]/
├── plan.md              # This file (/speckit.plan command output)
├── research.md          # Phase 0 output (/speckit.plan command)
├── data-model.md        # Phase 1 output (/speckit.plan command)
├── quickstart.md        # Phase 1 output (/speckit.plan command)
├── contracts/           # Phase 1 output (/speckit.plan command)
└── tasks.md             # Phase 2 output (/speckit.tasks command - NOT created by /speckit.plan)
```

### Source Code (repository root)

<!--
  ACTION REQUIRED: Replace the placeholder tree below with the concrete paths
  for this specific feature. Expand with exact filenames where possible.
  For GroundedTime, use Laravel structure.
-->

```text
# Laravel structure (GroundedTime default)
app/
├── Http/
│   ├── Controllers/
│   │   └── [FeatureController.php]  # Thin controllers for HTTP handling
│   └── Requests/
│       └── [FeatureRequest.php]     # Form validation
├── Models/
│   └── [Entity.php]                  # Eloquent models
├── Services/
│   └── [FeatureService.php]          # Business logic
└── Notifications/
    └── [FeatureNotification.php]     # Laravel notifications

database/
├── migrations/
│   └── [YYYY_MM_DD_create_table.php]
└── seeders/

resources/
└── views/
    ├── [feature]/
    │   ├── index.blade.php           # List view
    │   ├── show.blade.php            # Detail view
    │   └── _form.blade.php           # Form partial
    └── layouts/
        └── app.blade.php

routes/
└── web.php                           # Route definitions

tests/
├── Feature/                          # Feature tests (HTTP-level)
│   └── [FeatureTest.php]
└── Unit/                             # Unit tests (Service/Model)
    └── [ServiceTest.php]
```

**Structure Decision**: [Document which Laravel components are needed for this feature]

## Complexity Tracking

> **Fill ONLY if Constitution Check has violations that must be justified**

| Violation                  | Why Needed         | Simpler Alternative Rejected Because |
| -------------------------- | ------------------ | ------------------------------------ |
| [e.g., 4th project]        | [current need]     | [why 3 projects insufficient]        |
| [e.g., Repository pattern] | [specific problem] | [why direct DB access insufficient]  |
