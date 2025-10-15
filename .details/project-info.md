# Voice Assistant Platform - Project Info

## Overview
- Laravel 10 application that manages AI-assisted voice and text conversations through a modular architecture.
- Combines traditional CMS utilities (menus, media, SEO, newsletters) with realtime AI chat, voice transcription, and chat UI modules.
- Modules are delivered via the Nwidart/laravel-modules package, keeping feature code isolated and publishable.

## Module Highlights
- `Modules/AI` provides the integration layer for large language models, binding `LlmService` to the `OllamaLlm` adapter, exposing HTTP endpoints, and registering publishable config/views.
- `Modules/Conversations` defines the `Conversation` and `Message` models, controller endpoints, and migrations for structured chat history (roles, audio paths, timing metrics).
- `Modules/Voice` ingests uploaded audio, tracks normalization and STT metadata, and seeds the `voice_notes` table for later attachment to conversations.
- `Modules/ChatUI` ships the admin/user-facing chat interface and Vite assets that consume the AI endpoints.
- Established CMS-style modules (`Menu`, `Media`, `Users`, `ActivityLog`, `Setting`, etc.) continue to supply foundational administration features.

## Data & Storage
- Core tables live under `database/migrations`, while AI-specific schemas (conversations, messages, voice_notes) live in their respective module migration folders.
- File paths for audio artifacts are stored in the message and voice note records; ensure corresponding storage disks are configured for uploads and generated audio.
- Caching, logs, and compiled Blade views land under `storage/`; make sure this directory remains writable in all environments.

## Tooling & Configuration
- Application secrets and runtime flags are read from `.env`; module enablement is controlled by `modules_statuses.json`.
- Composer manages PHP dependencies; Node/Vite drives front-end builds defined in `package.json` and `vite.config.js` (per module and root).
- Tailwind CSS and PostCSS are configured at the root; module asset pipelines follow the same Vite conventions.

## Developer Workflow
- Run `php artisan migrate` (optionally `--module=` scoped) whenever module migrations change.
- Kick off front-end builds with `npm run dev` for watch mode or `npm run build` for production bundles.
- Register additional LLM backends by binding new adapters to `Modules\AI\App\Contracts\LlmService` within `AIServiceProvider`.
- Use per-module service providers to hook into Laravel events, publish configuration, and expose routes without polluting the core `app/` namespace.
