---
name: anti-spaghetti-architecture
description: Prevent tangled architecture and encourage separation of concerns in backend and frontend code. Use when implementing features, refactoring large files, designing services, or reviewing code that feels hard to reason about.
---

# Anti-Spaghetti Architecture

Use this skill when code risks becoming tangled, oversized, or responsibility-heavy.

## Core Rules
- One module, class, or component should have one clear reason to change.
- Prefer explicit boundaries over convenience shortcuts.
- Keep orchestration separate from domain logic.
- Keep IO, validation, transformation, and persistence responsibilities separated where practical.
- Avoid burying business rules inside controllers, views, or utility dumping grounds.

## Smell Detection
Watch for:
- giant files combining fetching, validation, formatting, and side effects
- controllers or routes doing business logic directly
- utility files becoming catch-all buckets
- duplicated logic across components/services
- hidden coupling through globals or copy-paste
- functions that both decide and execute too many things

## Refactor Direction
- Extract actions, services, or use-cases for business workflows
- Extract query logic from controllers when non-trivial
- Extract reusable frontend components only when the abstraction is real
- Prefer composition over mega-helpers
- Keep naming tied to domain intent

## Guardrails
- Do not over-engineer tiny changes.
- Match the existing architecture style when it is already coherent.
- Refactor only as far as needed to restore clarity.