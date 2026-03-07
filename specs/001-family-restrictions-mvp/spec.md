# Feature Specification: Family Restrictions Management MVP

**Feature Branch**: `001-family-restrictions-mvp`  
**Created**: 2026-03-05  
**Status**: Draft  
**Input**: User description: "Sistema completo de gerenciamento de castigos/restrições (grounding) para famílias. Inclui: login + família (household), múltiplos responsáveis (pais/mães), castigos com título/descrição/datas, visibilidade para todos os responsáveis, histórico, e notificações (email, browser, possivelmente Google Calendar)."

## Clarifications

### Session 2026-03-07

- Q: How should GroundedTime handle GDPR compliance and user data portability? → A: Option A - Implement GDPR compliance now (export/deletion); child data limited to name and photo only (no birthdate).
- Q: What observability and logging strategy should GroundedTime implement? → A: Option B - Lightweight monitoring for MVP (Laravel file logs + error emails); defer advanced metrics/error tracking.
- Q: How should timezones be handled for reminders and restriction expiration? → A: Option A - Store timezone per family (default America/Sao_Paulo) and process reminders/expiration in family timezone.
- Q: Which canonical term should be used for the domain concept: punishment or restriction? → A: Use `Restriction` as canonical technical term; `Consequence` may be used in UX copy.
- Q: Which database should be used? → A: MySQL.

## User Scenarios & Testing _(mandatory)_

### User Story 1 - Authentication & Family Setup (Priority: P1) 🎯

A parent signs up for GroundedTime, creates their household account, and invites their partner to join the same family.

**Why this priority**: This is the foundational requirement. Without authentication and family setup, no other features can function. This establishes the multi-user, shared-family context that makes GroundedTime valuable.

**Independent Test**: Can be fully tested by creating an account, setting up a family name, and seeing a dashboard (even if empty). Delivers immediate value by establishing the family context.

**Acceptance Scenarios**:

1. **Given** I am a new user, **When** I visit GroundedTime, **Then** I see options to sign up or log in
2. **Given** I click sign up, **When** I provide email and password, **Then** my account is created and I'm asked to name my family
3. **Given** I name my family "Silva Family", **When** I complete setup, **Then** I see my dashboard with family name displayed
4. **Given** I am logged in, **When** I navigate to family settings, **Then** I can see my family members and invite others by email
5. **Given** my partner receives an invite email, **When** they click the link and sign up, **Then** they join my existing family automatically
6. **Given** I am logged in, **When** I log out and log back in, **Then** I see my same family and data

---

### User Story 2 - Create and Edit Restrictions (Priority: P2) 🎯

A parent creates a restriction (consequence) with a title, optional description, start time, and end time. They can edit or end it early if needed.

**Why this priority**: This is the core value proposition. Once authenticated, parents need to immediately create and manage restrictions. This is the primary use case.

**Independent Test**: Can be fully tested by creating a restriction "No TV", setting start/end dates, seeing it display, and editing or ending it. Delivers the core value of tracking restrictions.

**Acceptance Scenarios**:

1. **Given** I am logged in, **When** I click "Create Restriction", **Then** I see a form asking for title, description (optional), start date/time, and end date/time
2. **Given** I fill in title "No video games" and set start to "today 6pm" and end to "tomorrow 6pm", **When** I save, **Then** the restriction is created and appears in my active list
3. **Given** I have an active restriction, **When** I click "Edit", **Then** I can change the title, description, or end time
4. **Given** I have an active restriction "No TV until Friday", **When** I click "End Now", **Then** it moves to ended status with current timestamp as ended_at
5. **Given** I create a restriction, **When** I leave the end date empty, **Then** it's saved as "indefinite" and displays accordingly
6. **Given** I try to create a restriction with end date before start date, **When** I submit, **Then** I see a validation error

---

### User Story 3 - View Active Restrictions & History (Priority: P3)

Both parents can see a feed of currently active restrictions and browse historical (ended) ones. Each restriction shows who created it and when it ends.

**Why this priority**: After creating restrictions, visibility and coordination between parents is essential. This prevents miscommunication and ensures both parents are on the same page.

**Independent Test**: Can be fully tested by creating several restrictions (some active, some ended), then verifying both parents see the same list with creator names and end times.

**Acceptance Scenarios**:

1. **Given** I am logged in, **When** I view my dashboard, **Then** I see a list of all currently active restrictions ordered by end date
2. **Given** there are active restrictions, **When** I look at each one, **Then** I see the title, description, who created it, start time, and end time
3. **Given** I navigate to "History", **When** the page loads, **Then** I see all ended restrictions with who ended them and when
4. **Given** my partner creates a restriction, **When** I refresh my dashboard, **Then** I immediately see their newly created restriction in my active list
5. **Given** there are no active restrictions, **When** I view the dashboard, **Then** I see a friendly message like "No active restrictions" with a button to create one

---

### User Story 4 - Email & Browser Notifications (Priority: P4)

Parents receive notifications when restrictions are created, modified, or expire. Notifications are sent via email and browser (if supported).

**Why this priority**: This ensures parents don't forget about restrictions and stay coordinated. Without notifications, the system is just a list - notifications make it proactive.

**Independent Test**: Can be fully tested by creating a restriction and verifying both parents receive an email. Set up a daily reminder and verify it fires. Test expiry notifications.

**Acceptance Scenarios**:

1. **Given** I create a restriction, **When** I save it, **Then** my partner receives an email notification with the restriction details
2. **Given** my partner edits a restriction, **When** they save changes, **Then** I receive an email about the modification
3. **Given** I enable browser notifications in settings, **When** a new restriction is created by my partner, **Then** I see a browser notification (if I'm logged in)
4. **Given** there is an active restriction ending today, **When** the daily reminder time arrives (e.g., 8am), **Then** both parents receive an email: "Active today: No TV until 8pm"
5. **Given** a restriction's end time is reached, **When** the system detects expiration, **Then** both parents receive an "Restriction ended" notification
6. **Given** I am in notification settings, **When** I disable email notifications, **Then** I stop receiving emails but my partner still does (if they haven't disabled)

---

### User Story 5 - Manage Children (Priority: P5)

Parents can add children to their family and associate restrictions with specific children. This provides better organization and clarity.

**Why this priority**: While optional for MVP, this adds significant value for families with multiple children. It prevents confusion about who is grounded. Lower priority because restrictions can work without it (using title/description to mention child name).

**Independent Test**: Can be fully tested by adding children "João" and "Maria", creating restrictions for each, and verifying the restrictions display which child they apply to.

**Acceptance Scenarios**:

1. **Given** I am logged in, **When** I navigate to "Children", **Then** I see a list of children in my family and an "Add Child" button
2. **Given** I click "Add Child", **When** I enter name "João" and optionally upload a photo, **Then** the child is added to my family
3. **Given** I create a restriction, **When** I see the form, **Then** there's an optional dropdown to select which child this applies to
4. **Given** I select child "Maria" when creating a restriction, **When** I save, **Then** the restriction displays "Maria: No phone" clearly showing it's for her
5. **Given** I have multiple children, **When** I view active restrictions, **Then** I can filter by child to see only their restrictions
6. **Given** I create a restriction without selecting a child, **When** I save, **Then** it's saved as applying to "all" or "household" (general restriction)

---

### Edge Cases

- What happens when a restriction end time has passed but the system hasn't processed it yet? (Should still display as active until cron runs, then auto-end)
- How does system handle if both parents try to edit the same restriction simultaneously? (Last save wins, with timestamp tracking)
- What happens if a parent's email bounces when sending notification? (Log error, don't block restriction creation)
- What happens when a parent tries to create a restriction with start time in the past? (Allow it - might be recording a restriction that already started)
- What happens if a family has no children added but tries to filter by child? (Show empty state or all restrictions)
- What happens when a parent is removed from a family? (Their created restrictions remain but show "Former member" as creator)
- What happens if email invite expires or is used twice? (Invite expires after 7 days, used invites become invalid)

## Requirements _(mandatory)_

### Functional Requirements

**Authentication & Authorization**

- **FR-001**: System MUST allow users to create accounts with email and password
- **FR-002**: System MUST validate email format and password strength (minimum 8 characters)
- **FR-003**: System MUST allow users to log in with email and password
- **FR-004**: System MUST allow users to log out
- **FR-005**: System MUST restrict all features to authenticated users only
- **FR-006**: System MUST ensure users can only access data from their own family
- **FR-007**: System MUST provide password reset via email

**Family Management**

- **FR-008**: System MUST allow a new user to create a family with a name during signup
- **FR-009**: System MUST allow family members to invite others via email
- **FR-010**: System MUST generate unique invite links that expire after 7 days
- **FR-011**: System MUST automatically add invited users to the correct family when they sign up via invite link
- **FR-012**: System MUST display all family members with their roles (creator, member)
- **FR-013**: System MUST allow family creators to remove members from the family
- **FR-013A**: System MUST store a `timezone` per family (default: `America/Sao_Paulo`) and use it for reminder scheduling and automatic restriction expiration

**Children Management (Optional for MVP)**

- **FR-014**: System SHOULD allow family members to add children with name and optional photo
- **FR-015**: System SHOULD allow family members to edit or remove children
- **FR-016**: System SHOULD display children in restriction forms for optional association

**Restrictions Management**

- **FR-017**: System MUST allow family members to create restrictions with required fields: title, start_at, end_at
- **FR-018**: System MUST allow optional fields: description, child_id
- **FR-019**: System MUST validate that end_at is after start_at (or allow null for indefinite)
- **FR-020**: System MUST store who created the restriction (created_by)
- **FR-021**: System MUST allow family members to edit restriction title, description, and end_at
- **FR-022**: System MUST allow family members to end a restriction early with "End Now" action
- **FR-023**: System MUST store who ended the restriction (ended_by) and when (ended_at)
- **FR-024**: System MUST automatically mark restrictions as ended when current time passes end_at
- **FR-025**: System MUST display active restrictions (status=active) on dashboard
- **FR-026**: System MUST display historical restrictions (status=ended) in history view
- **FR-027**: System MUST display each restriction with: title, description, creator name, start time, end time, status

**Notifications**

- **FR-028**: System MUST send email notification to all family members (except creator) when a restriction is created
- **FR-029**: System MUST send email notification to all family members (except editor) when a restriction is edited
- **FR-030**: System MUST send email notification to all family members when a restriction ends (automatically or manually)
- **FR-031**: System SHOULD send daily reminder email at a configured time (e.g., 8am) listing all currently active restrictions
- **FR-032**: System SHOULD support browser push notifications (if user grants permission) for restriction events
- **FR-033**: System MUST allow users to configure notification preferences (enable/disable email, browser)
- **FR-034**: System MUST continue to function if email notifications fail (log error, don't block operations)

**Localization & Language Support (MVP)**

- **FR-034A**: System MUST support UI localization in Portuguese (`pt-BR`), English (`en`), and Spanish (`es`)
- **FR-034B**: System MUST allow each user to select preferred language in settings
- **FR-034C**: System SHOULD default new users to Portuguese (`pt-BR`) and provide fallback to English (`en`) when translation keys are missing

**Observability & Monitoring (MVP)**

- **FR-035**: System MUST log application errors and key background job failures using Laravel default file logging
- **FR-036**: System MUST send error alerts via email for critical failures in notification and scheduler flows
- **FR-037**: System SHOULD defer advanced monitoring tools (e.g., Sentry/APM dashboards) to post-MVP

**Future Enhancements (Not in MVP)**

- **FR-038**: System MAY integrate with Google Calendar to create events for restrictions
- **FR-039**: System MAY provide audit trail (`restriction_events` table) showing all changes
- **FR-040**: System MAY allow restrictions to recur (e.g., "No TV every weekday 6-8pm")

### Key Entities _(include if feature involves data)_

**Family**

Represents a household. Attributes: name, created_at. Has many Users (through family_user pivot), has many Children, has many Restrictions.

**User**

Represents a parent/guardian. Attributes: name, email, password_hash, email_verified_at, remember_token, created_at. Belongs to many Families (through family_user pivot).

**FamilyUser** (pivot table)

Links users to families. Attributes: family_id, user_id, role (enum: creator, member), joined_at. Belongs to Family and User.

**Child** (optional for MVP)

Represents a child in the family. Attributes: family_id, name (required), photo_url (optional), created_at. Belongs to Family, has many Restrictions.

**Restriction** (formerly referred to as "Punishment")

Represents a family restriction. Attributes:

- family_id (which family)
- child_id (nullable - which child, or null for household-wide)
- title (required, e.g., "No TV")
- description (nullable, e.g., "for bad behavior at school")
- status (enum: active, ended)
- starts_at (timestamp, when it begins)
- ends_at (nullable timestamp, when it ends - null = indefinite)
- created_by (user_id of creator)
- ended_by (nullable user_id who ended it)
- ended_at (nullable timestamp when actually ended)
- created_at, updated_at

Belongs to Family, belongs to Child (optional), belongs to User (creator), belongs to User (ender).

**RestrictionEvent** (optional audit trail)

Records all changes to restrictions. Attributes: restriction_id, action (created, edited, ended), payload_json (what changed), actor_id (who did it), created_at. Belongs to Restriction and User (actor).

**NotificationPreference** (for user settings)

Stores notification preferences per user. Attributes: user_id, email_enabled (boolean, default true), browser_enabled (boolean, default false), daily_reminder_time (time, default 08:00), created_at. Belongs to User.

## Success Criteria _(mandatory)_

### Measurable Outcomes

- **SC-001**: Parents can complete account creation, family setup, and first restriction creation in under 3 minutes
- **SC-002**: Both parents see the same restriction list within 5 seconds of one creating a restriction (after page refresh)
- **SC-003**: Email notifications are delivered within 60 seconds of restriction events (creation, modification, expiration)
- **SC-004**: 95% of parents successfully create their first restriction on first attempt without errors
- **SC-005**: Users can view restriction history going back 30 days without performance degradation
- **SC-006**: Daily reminder emails are sent within 5 minutes of configured time (e.g., 8:00-8:05am)
- **SC-007**: Mobile browsers can use all features comfortably (responsive design works on phones)
- **SC-008**: Parents report feeling "in sync" with their partner regarding active restrictions (qualitative survey after 1 week)
- **SC-009**: Users can switch app language between `pt-BR`, `en`, and `es` and see translated navigation/pages immediately after reload

## Assumptions

- Users have valid email addresses and can receive emails
- Users understand basic concepts of "restriction" or "consequence" in parenting context
- Initial MVP will support one family per user (no switching between multiple families)
- Browser notification support is optional and not all browsers will support it
- Google Calendar integration is deferred to post-MVP based on user feedback
- Audit trail (`restriction_events`) may be added post-MVP if needed for dispute resolution
- Time zones: MVP will use family-level timezone (default `America/Sao_Paulo`), user-specific timezones are post-MVP
- Laravel's built-in email notification system is sufficient (using Mailgun, SendGrid, or similar)
- No mobile apps initially - responsive web is sufficient for MVP
- No SMS notifications (email only for MVP)

## Out of Scope (for MVP)

- Multiple families per user
- Role-based permissions within family (all members have equal access for MVP)
- Restriction templates or presets
- Photo attachments to restrictions
- Comments or discussions on restrictions
- Geolocation-based reminders
- Integration with parental control apps
- Reward systems (only restrictions, no positive reinforcement tracking)
- Teacher or school integration
- Social features (sharing restrictions with other families)
- AI suggestions for restriction timing or duration
- Gamification elements
