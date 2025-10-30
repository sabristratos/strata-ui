<laravel-boost-guidelines>
=== foundation rules ===

# Laravel Boost Guidelines

The Laravel Boost guidelines are specifically curated by Laravel maintainers for this application. These guidelines should be followed closely to enhance the user's satisfaction building Laravel applications.

## Foundational Context
This application is a Laravel application and its main Laravel ecosystems package & versions are below. You are an expert with them all. Ensure you abide by these specific packages & versions.

- php - 8.3.20
- laravel/framework (LARAVEL) - v12
- laravel/prompts (PROMPTS) - v0
- livewire/livewire (LIVEWIRE) - v3
- laravel/mcp (MCP) - v0
- laravel/pint (PINT) - v1
- laravel/sail (SAIL) - v1
- pestphp/pest (PEST) - v4
- phpunit/phpunit (PHPUNIT) - v12
- tailwindcss (TAILWINDCSS) - v4


## Conventions
- You must follow all existing code conventions used in this application. When creating or editing a file, check sibling files for the correct structure, approach, naming.
- Use descriptive names for variables and methods. For example, `isRegisteredForDiscounts`, not `discount()`.
- Check for existing components to reuse before writing a new one.

## Verification Scripts
- Do not create verification scripts or tinker when tests cover that functionality and prove it works. Unit and feature tests are more important.

## Application Structure & Architecture
- Stick to existing directory structure - don't create new base folders without approval.
- Do not change the application's dependencies without approval.

## Frontend Bundling
- If the user doesn't see a frontend change reflected in the UI, it could mean they need to run `npm run build`, `npm run dev`, or `composer run dev`. Ask them.

## Replies
- Be concise in your explanations - focus on what's important rather than explaining obvious details.

## Documentation Files
- You must only create documentation files if explicitly requested by the user.


=== boost rules ===

## Laravel Boost
- Laravel Boost is an MCP server that comes with powerful tools designed specifically for this application. Use them.

## Artisan
- Use the `list-artisan-commands` tool when you need to call an Artisan command to double check the available parameters.

## URLs
- Whenever you share a project URL with the user you should use the `get-absolute-url` tool to ensure you're using the correct scheme, domain / IP, and port.

## Tinker / Debugging
- You should use the `tinker` tool when you need to execute PHP to debug code or query Eloquent models directly.
- Use the `database-query` tool when you only need to read from the database.

## Reading Browser Logs With the `browser-logs` Tool
- You can read browser logs, errors, and exceptions using the `browser-logs` tool from Boost.
- Only recent browser logs will be useful - ignore old logs.

## Searching Documentation (Critically Important)
- Boost comes with a powerful `search-docs` tool you should use before any other approaches. This tool automatically passes a list of installed packages and their versions to the remote Boost API, so it returns only version-specific documentation specific for the user's circumstance. You should pass an array of packages to filter on if you know you need docs for particular packages.
- The 'search-docs' tool is perfect for all Laravel related packages, including Laravel, Inertia, Livewire, Filament, Tailwind, Pest, Nova, Nightwatch, etc.
- You must use this tool to search for Laravel-ecosystem documentation before falling back to other approaches.
- Search the documentation before making code changes to ensure we are taking the correct approach.
- Use multiple, broad, simple, topic based queries to start. For example: `['rate limiting', 'routing rate limiting', 'routing']`.
- Do not add package names to queries - package information is already shared. For example, use `test resource table`, not `filament 4 test resource table`.

### Available Search Syntax
- You can and should pass multiple queries at once. The most relevant results will be returned first.

1. Simple Word Searches with auto-stemming - query=authentication - finds 'authenticate' and 'auth'
2. Multiple Words (AND Logic) - query=rate limit - finds knowledge containing both "rate" AND "limit"
3. Quoted Phrases (Exact Position) - query="infinite scroll" - Words must be adjacent and in that order
4. Mixed Queries - query=middleware "rate limit" - "middleware" AND exact phrase "rate limit"
5. Multiple Queries - queries=["authentication", "middleware"] - ANY of these terms


=== php rules ===

## PHP

- Always use curly braces for control structures, even if it has one line.

### Constructors
- Use PHP 8 constructor property promotion in `__construct()`.
    - <code-snippet>public function __construct(public GitHub $github) { }</code-snippet>
- Do not allow empty `__construct()` methods with zero parameters.

### Type Declarations
- Always use explicit return type declarations for methods and functions.
- Use appropriate PHP type hints for method parameters.

<code-snippet name="Explicit Return Types and Method Params" lang="php">
protected function isAccessible(User $user, ?string $path = null): bool
{
    ...
}
</code-snippet>

## Comments
- Prefer PHPDoc blocks over comments. Never use comments within the code itself unless there is something _very_ complex going on.

## PHPDoc Blocks
- Add useful array shape type definitions for arrays when appropriate.

## Enums
- Typically, keys in an Enum should be TitleCase. For example: `FavoritePerson`, `BestLake`, `Monthly`.


=== herd rules ===

## Laravel Herd

- The application is served by Laravel Herd and will be available at: https?://[kebab-case-project-dir].test. Use the `get-absolute-url` tool to generate URLs for the user to ensure valid URLs.
- You must not run any commands to make the site available via HTTP(s). It is _always_ available through Laravel Herd.


=== laravel/core rules ===

## Do Things the Laravel Way

- Use `php artisan make:` commands to create new files (i.e. migrations, controllers, models, etc.). You can list available Artisan commands using the `list-artisan-commands` tool.
- If you're creating a generic PHP class, use `artisan make:class`.
- Pass `--no-interaction` to all Artisan commands to ensure they work without user input. You should also pass the correct `--options` to ensure correct behavior.

### Database
- Always use proper Eloquent relationship methods with return type hints. Prefer relationship methods over raw queries or manual joins.
- Use Eloquent models and relationships before suggesting raw database queries
- Avoid `DB::`; prefer `Model::query()`. Generate code that leverages Laravel's ORM capabilities rather than bypassing them.
- Generate code that prevents N+1 query problems by using eager loading.
- Use Laravel's query builder for very complex database operations.

### Model Creation
- When creating new models, create useful factories and seeders for them too. Ask the user if they need any other things, using `list-artisan-commands` to check the available options to `php artisan make:model`.

### APIs & Eloquent Resources
- For APIs, default to using Eloquent API Resources and API versioning unless existing API routes do not, then you should follow existing application convention.

### Controllers & Validation
- Always create Form Request classes for validation rather than inline validation in controllers. Include both validation rules and custom error messages.
- Check sibling Form Requests to see if the application uses array or string based validation rules.

### Queues
- Use queued jobs for time-consuming operations with the `ShouldQueue` interface.

### Authentication & Authorization
- Use Laravel's built-in authentication and authorization features (gates, policies, Sanctum, etc.).

### URL Generation
- When generating links to other pages, prefer named routes and the `route()` function.

### Configuration
- Use environment variables only in configuration files - never use the `env()` function directly outside of config files. Always use `config('app.name')`, not `env('APP_NAME')`.

### Testing
- When creating models for tests, use the factories for the models. Check if the factory has custom states that can be used before manually setting up the model.
- Faker: Use methods such as `$this->faker->word()` or `fake()->randomDigit()`. Follow existing conventions whether to use `$this->faker` or `fake()`.
- When creating tests, make use of `php artisan make:test [options] <name>` to create a feature test, and pass `--unit` to create a unit test. Most tests should be feature tests.

### Vite Error
- If you receive an "Illuminate\Foundation\ViteException: Unable to locate file in Vite manifest" error, you can run `npm run build` or ask the user to run `npm run dev` or `composer run dev`.


=== laravel/v12 rules ===

## Laravel 12

- Use the `search-docs` tool to get version specific documentation.
- Since Laravel 11, Laravel has a new streamlined file structure which this project uses.

### Laravel 12 Structure
- No middleware files in `app/Http/Middleware/`.
- `bootstrap/app.php` is the file to register middleware, exceptions, and routing files.
- `bootstrap/providers.php` contains application specific service providers.
- **No app\Console\Kernel.php** - use `bootstrap/app.php` or `routes/console.php` for console configuration.
- **Commands auto-register** - files in `app/Console/Commands/` are automatically available and do not require manual registration.

### Database
- When modifying a column, the migration must include all of the attributes that were previously defined on the column. Otherwise, they will be dropped and lost.
- Laravel 11 allows limiting eagerly loaded records natively, without external packages: `$query->latest()->limit(10);`.

### Models
- Casts can and likely should be set in a `casts()` method on a model rather than the `$casts` property. Follow existing conventions from other models.


=== livewire/core rules ===

## Livewire Core
- Use the `search-docs` tool to find exact version specific documentation for how to write Livewire & Livewire tests.
- Use the `php artisan make:livewire [Posts\\CreatePost]` artisan command to create new components
- State should live on the server, with the UI reflecting it.
- All Livewire requests hit the Laravel backend, they're like regular HTTP requests. Always validate form data, and run authorization checks in Livewire actions.

## Livewire Best Practices
- Livewire components require a single root element.
- Use `wire:loading` and `wire:dirty` for delightful loading states.
- Add `wire:key` in loops:

    ```blade
    @foreach ($items as $item)
        <div wire:key="item-{{ $item->id }}">
            {{ $item->name }}
        </div>
    @endforeach
    ```

- Prefer lifecycle hooks like `mount()`, `updatedFoo()` for initialization and reactive side effects:

<code-snippet name="Lifecycle hook examples" lang="php">
    public function mount(User $user) { $this->user = $user; }
    public function updatedSearch() { $this->resetPage(); }
</code-snippet>


## Testing Livewire

<code-snippet name="Example Livewire component test" lang="php">
    Livewire::test(Counter::class)
        ->assertSet('count', 0)
        ->call('increment')
        ->assertSet('count', 1)
        ->assertSee(1)
        ->assertStatus(200);
</code-snippet>


    <code-snippet name="Testing a Livewire component exists within a page" lang="php">
        $this->get('/posts/create')
        ->assertSeeLivewire(CreatePost::class);
    </code-snippet>


=== livewire/v3 rules ===

## Livewire 3

### Key Changes From Livewire 2
- These things changed in Livewire 2, but may not have been updated in this application. Verify this application's setup to ensure you conform with application conventions.
    - Use `wire:model.live` for real-time updates, `wire:model` is now deferred by default.
    - Components now use the `App\Livewire` namespace (not `App\Http\Livewire`).
    - Use `$this->dispatch()` to dispatch events (not `emit` or `dispatchBrowserEvent`).
    - Use the `components.layouts.app` view as the typical layout path (not `layouts.app`).

### New Directives
- `wire:show`, `wire:transition`, `wire:cloak`, `wire:offline`, `wire:target` are available for use. Use the documentation to find usage examples.

### Alpine
- Alpine is now included with Livewire, don't manually include Alpine.js.
- Plugins included with Alpine: persist, intersect, collapse, and focus.

### Lifecycle Hooks
- You can listen for `livewire:init` to hook into Livewire initialization, and `fail.status === 419` for the page expiring:

<code-snippet name="livewire:load example" lang="js">
document.addEventListener('livewire:init', function () {
    Livewire.hook('request', ({ fail }) => {
        if (fail && fail.status === 419) {
            alert('Your session expired');
        }
    });

    Livewire.hook('message.failed', (message, component) => {
        console.error(message);
    });
});
</code-snippet>


=== pint/core rules ===

## Laravel Pint Code Formatter

- You must run `vendor/bin/pint --dirty` before finalizing changes to ensure your code matches the project's expected style.
- Do not run `vendor/bin/pint --test`, simply run `vendor/bin/pint` to fix any formatting issues.


=== pest/core rules ===

## Pest

### Testing
- If you need to verify a feature is working, write or update a Unit / Feature test.

### Pest Tests
- All tests must be written using Pest. Use `php artisan make:test --pest <name>`.
- You must not remove any tests or test files from the tests directory without approval. These are not temporary or helper files - these are core to the application.
- Tests should test all of the happy paths, failure paths, and weird paths.
- Tests live in the `tests/Feature` and `tests/Unit` directories.
- Pest tests look and behave like this:
<code-snippet name="Basic Pest Test Example" lang="php">
it('is true', function () {
    expect(true)->toBeTrue();
});
</code-snippet>

### Running Tests
- Run the minimal number of tests using an appropriate filter before finalizing code edits.
- To run all tests: `php artisan test`.
- To run all tests in a file: `php artisan test tests/Feature/ExampleTest.php`.
- To filter on a particular test name: `php artisan test --filter=testName` (recommended after making a change to a related file).
- When the tests relating to your changes are passing, ask the user if they would like to run the entire test suite to ensure everything is still passing.

### Pest Assertions
- When asserting status codes on a response, use the specific method like `assertForbidden` and `assertNotFound` instead of using `assertStatus(403)` or similar, e.g.:
<code-snippet name="Pest Example Asserting postJson Response" lang="php">
it('returns all', function () {
    $response = $this->postJson('/api/docs', []);

    $response->assertSuccessful();
});
</code-snippet>

### Mocking
- Mocking can be very helpful when appropriate.
- When mocking, you can use the `Pest\Laravel\mock` Pest function, but always import it via `use function Pest\Laravel\mock;` before using it. Alternatively, you can use `$this->mock()` if existing tests do.
- You can also create partial mocks using the same import or self method.

### Datasets
- Use datasets in Pest to simplify tests which have a lot of duplicated data. This is often the case when testing validation rules, so consider going with this solution when writing tests for validation rules.

<code-snippet name="Pest Dataset Example" lang="php">
it('has emails', function (string $email) {
    expect($email)->not->toBeEmpty();
})->with([
    'james' => 'james@laravel.com',
    'taylor' => 'taylor@laravel.com',
]);
</code-snippet>


=== pest/v4 rules ===

## Pest 4

- Pest v4 is a huge upgrade to Pest and offers: browser testing, smoke testing, visual regression testing, test sharding, and faster type coverage.
- Browser testing is incredibly powerful and useful for this project.
- Browser tests should live in `tests/Browser/`.
- Use the `search-docs` tool for detailed guidance on utilizing these features.

### Browser Testing
- You can use Laravel features like `Event::fake()`, `assertAuthenticated()`, and model factories within Pest v4 browser tests, as well as `RefreshDatabase` (when needed) to ensure a clean state for each test.
- Interact with the page (click, type, scroll, select, submit, drag-and-drop, touch gestures, etc.) when appropriate to complete the test.
- If requested, test on multiple browsers (Chrome, Firefox, Safari).
- If requested, test on different devices and viewports (like iPhone 14 Pro, tablets, or custom breakpoints).
- Switch color schemes (light/dark mode) when appropriate.
- Take screenshots or pause tests for debugging when appropriate.

### Example Tests

<code-snippet name="Pest Browser Test Example" lang="php">
it('may reset the password', function () {
    Notification::fake();

    $this->actingAs(User::factory()->create());

    $page = visit('/sign-in'); // Visit on a real browser...

    $page->assertSee('Sign In')
        ->assertNoJavascriptErrors() // or ->assertNoConsoleLogs()
        ->click('Forgot Password?')
        ->fill('email', 'nuno@laravel.com')
        ->click('Send Reset Link')
        ->assertSee('We have emailed your password reset link!')

    Notification::assertSent(ResetPassword::class);
});
</code-snippet>

<code-snippet name="Pest Smoke Testing Example" lang="php">
$pages = visit(['/', '/about', '/contact']);

$pages->assertNoJavascriptErrors()->assertNoConsoleLogs();
</code-snippet>


=== tailwindcss/core rules ===

## Tailwind Core

- Use Tailwind CSS classes to style HTML, check and use existing tailwind conventions within the project before writing your own.
- Offer to extract repeated patterns into components that match the project's conventions (i.e. Blade, JSX, Vue, etc..)
- Think through class placement, order, priority, and defaults - remove redundant classes, add classes to parent or child carefully to limit repetition, group elements logically
- You can use the `search-docs` tool to get exact examples from the official documentation when needed.

### Spacing
- When listing items, use gap utilities for spacing, don't use margins.

    <code-snippet name="Valid Flex Gap Spacing Example" lang="html">
        <div class="flex gap-8">
            <div>Superior</div>
            <div>Michigan</div>
            <div>Erie</div>
        </div>
    </code-snippet>


### Dark Mode
- If existing pages and components support dark mode, new pages and components must support dark mode in a similar way, typically using `dark:`.


=== tailwindcss/v4 rules ===

## Tailwind 4

- Always use Tailwind CSS v4 - do not use the deprecated utilities.
- `corePlugins` is not supported in Tailwind v4.
- In Tailwind v4, you import Tailwind using a regular CSS `@import` statement, not using the `@tailwind` directives used in v3:

<code-snippet name="Tailwind v4 Import Tailwind Diff" lang="diff">
   - @tailwind base;
   - @tailwind components;
   - @tailwind utilities;
   + @import "tailwindcss";
</code-snippet>


### Replaced Utilities
- Tailwind v4 removed deprecated utilities. Do not use the deprecated option - use the replacement.
- Opacity values are still numeric.

| Deprecated |	Replacement |
|------------+--------------|
| bg-opacity-* | bg-black/* |
| text-opacity-* | text-black/* |
| border-opacity-* | border-black/* |
| divide-opacity-* | divide-black/* |
| ring-opacity-* | ring-black/* |
| placeholder-opacity-* | placeholder-black/* |
| flex-shrink-* | shrink-* |
| flex-grow-* | grow-* |
| overflow-ellipsis | text-ellipsis |
| decoration-slice | box-decoration-slice |
| decoration-clone | box-decoration-clone |


=== strata-ui rules ===

## Strata UI Component Library

This project is a development ground for Strata UI, a Blade and Livewire component library. The library provides clean, flexible, and powerful UI components that work seamlessly with Livewire and use Alpine for interactions.

### Core Philosophy
- Provide sensible defaults with beautiful, clean UI
- Allow extensive customization without sacrificing simplicity
- Use the path of least resistance while achieving desired outcomes
- Build modern, flexible components using modern HTML API, Tailwind v4, and PHP

### Component Design Principles
- Components should work seamlessly with Livewire
- Use Alpine.js for interactions (already included via Livewire)
- Each component should be clean, flexible, and powerful
- Always provide sensible defaults
- Ensure beautiful, clean UI out of the box

### State Management Architecture
Understanding when to use Alpine.js versus Livewire for state management is critical for building performant components.

#### Core Principle
**Alpine for transient UI state, Livewire for persistence.**

Alpine.js should manage temporary UI state that doesn't need immediate server persistence (dropdown open/closed, highlighted items, search queries, working selections). Livewire should handle final state that needs to be saved to the backend.

#### When to Use Immediate Sync
Use `wire:model` or `wire:model.live` for simple, single-value interactions where immediate persistence makes sense:

- Single checkbox toggles
- Radio button selections
- Toggle switches
- Simple text inputs
- Single file uploads

<code-snippet name="Immediate Sync Pattern" lang="blade">
<input
    type="checkbox"
    wire:model.live="agreed"
/>
</code-snippet>

These components work perfectly with native HTML form behavior and don't benefit from deferred syncing.

#### When to Use Deferred Sync
Use Alpine.js for working state with deferred Livewire sync for complex interactions involving multiple operations before persistence:

- Multi-select with "Apply" button
- Batch file uploads with preview/removal
- Complex filtering and sorting
- Drag-and-drop reordering
- Form builders (add/remove/reorder fields)
- Tag inputs with batched additions

<code-snippet name="Deferred Sync Pattern" lang="blade">
<div x-data="{
    selected: @entangle('selectedIds').defer,
    working: [],
    dirty: false,

    init() {
        this.working = [...this.selected];
    },

    toggle(id) {
        if (this.working.includes(id)) {
            this.working = this.working.filter(i => i !== id);
        } else {
            this.working.push(id);
        }
        this.dirty = JSON.stringify(this.working) !== JSON.stringify(this.selected);
    },

    save() {
        this.selected = [...this.working];
        this.dirty = false;
    },

    cancel() {
        this.working = [...this.selected];
        this.dirty = false;
    }
}">
    <!-- Multi-select UI with working state -->

    <div x-show="dirty" class="flex gap-2">
        <button @click="save()">Save Changes</button>
        <button @click="cancel()">Cancel</button>
    </div>
</div>
</code-snippet>

#### Performance Benefits
The deferred sync pattern reduces network requests from potentially dozens (one per interaction) to a single request on save. This is especially important for:

- Production environments with network latency
- Components with frequent user interactions
- Operations that trigger expensive backend calculations
- Mobile devices with slower connections

#### Current Component Examples
Our existing components already follow these patterns:

- **SELECT** - Alpine manages `open`, `highlighted`, `search` state; Livewire syncs final `selected` value
- **FILE INPUT** - Alpine validates client-side; Livewire handles upload only when ready
- **INPUT CLEAR/TOGGLE** - Alpine manages UI actions; Livewire syncs actual input value
- **CHECKBOX/RADIO/TOGGLE** - Native HTML with `wire:model` (appropriate for single-value interactions)

#### Implementation Guidelines

1. **Identify state boundaries** - Determine what's UI-only vs what needs persistence
2. **Use computed properties** - Leverage Alpine's reactivity for derived state (filtering, sorting)
3. **Track dirty state** - Maintain a boolean flag to show when changes are unsaved
4. **Provide clear actions** - Give users explicit Save/Cancel controls for deferred changes
5. **Validate client-side** - Use Alpine for instant validation feedback before syncing
6. **Cache DOM references** - Store element references in `init()` to avoid repeated queries
7. **Use semantic data attributes** - Target elements with `data-strata-*` attributes, not generic selectors

#### Anti-Patterns to Avoid
- Making Livewire requests just to update UI state (use Alpine instead)
- Syncing every keystroke for search/filter inputs (use Alpine with debouncing)
- Creating separate Livewire properties for UI state like `isOpen`, `highlighted` (use Alpine)
- Bypassing validation by syncing directly to Livewire (validate in Alpine first)

### Component Naming Convention
- Use dot notation for related components that work together
- Example: `checkbox` and `checkbox.group`
- Example: `button`, `button.group`, `button.icon`
- This groups related components logically and shows their relationship

### Component File Structure
- **ALL components must live in their own folder** with the base component named `index.blade.php`
- Child/sibling components live alongside `index.blade.php` in the same folder
- Laravel automatically resolves `folder/index.blade.php` when referencing `<x-strata::folder />`
- This structure applies to ALL components, even those without children

#### Structure Pattern
```
components/
  button/
    index.blade.php     → <x-strata::button />
    icon.blade.php      → <x-strata::button.icon />
  input/
    index.blade.php     → <x-strata::input />
    clear.blade.php     → <x-strata::input.clear />
    counter.blade.php   → <x-strata::input.counter />
  alert/
    index.blade.php     → <x-strata::alert /> (even with no children)
```

#### Special Cases
- **form/** - Helper components only (no base form component)
  - Contains: error.blade.php, field.blade.php, hint.blade.php, label.blade.php
- **icon/** - Icon library only (no base icon component)
  - Contains: Individual icon files (a-arrow-up.blade.php, accessibility.blade.php, etc.)

#### Benefits
1. **Organization** - All related files grouped together in one folder
2. **Consistency** - Every component follows the same pattern
3. **Scalability** - Easy to see component families and their children
4. **Clean Hierarchy** - No mixing of files and folders at the same level
5. **No Breaking Changes** - Laravel's auto-resolution means existing code keeps working

### Data Attributes for Component Targeting
- Use package-specific data attributes to enable reliable element targeting
- All data attributes must be prefixed with `data-strata-` to avoid conflicts
- This pattern enables child components and Alpine.js to find parent/sibling elements precisely

#### Common Data Attributes
- `data-strata-avatar` - Marks avatar components for targeting by avatar.group
- `data-strata-input` - Marks the input element within input components
- `data-strata-input-wrapper` - Marks the input wrapper container
- Always use `data-strata-*` prefix for any new targeting attributes

#### Why Use Data Attributes
1. **Reliable targeting** - No conflicts with generic selectors like `querySelector('input')`
2. **Package-scoped** - `data-strata-*` ensures uniqueness across the application
3. **Works at any nesting level** - `closest('[data-strata-input-wrapper]')` finds the parent regardless of DOM depth
4. **Alpine.js friendly** - Makes element lookup straightforward and predictable

#### Example Pattern
For action components that need to interact with parent elements:

<code-snippet name="Data Attribute Targeting Pattern" lang="javascript">
// In Alpine.js component (e.g., input/clear.blade.php)
init() {
    // Find parent wrapper using data attribute
    const wrapper = this.$el.closest('[data-strata-input-wrapper]');

    // Find target element within wrapper
    this.input = wrapper.querySelector('[data-strata-input]');
}
</code-snippet>

This pattern:
- Avoids fragile selectors like `closest('div')` which depend on DOM structure
- Works regardless of how deeply the action component is nested
- Is self-documenting through semantic data attribute names

#### Implementation in Components
When creating components that need to be targeted:

<code-snippet name="Component with Data Attributes" lang="blade">
{{-- Main wrapper gets data-strata-{component}-wrapper --}}
<div data-strata-input-wrapper {{ $attributes->merge(['class' => $classes]) }}>

    {{-- Target element gets data-strata-{component} --}}
    <input data-strata-input type="{{ $type }}" />

</div>
</code-snippet>

When creating action/child components that target parents:

<code-snippet name="Action Component Targeting Parent" lang="blade">
<div x-data="{
    input: null,
    init() {
        // Reliable targeting using data attributes
        this.input = this.$el
            .closest('[data-strata-input-wrapper]')
            .querySelector('[data-strata-input]');
    }
}">
    {{-- Action component content --}}
</div>
</code-snippet>

### Customization Methods
Components can be customized through three main approaches:
1. **Data attributes** - Pass configuration via HTML attributes
2. **Base theme** - Customize through theme variables
3. **Slots** - Provide custom implementations for specific parts

### Theming System
- Use the `light-dark()` CSS function for light/dark mode support
- Define semantic colors as base variables (e.g., `--color-success`)
- Extend with semantic tokens:
  - `--color-success-foreground` for text colors
  - `--color-success-hover` for hover states
  - Additional states as needed (focus, active, disabled, etc.)
- Tailwind automatically generates utilities from CSS variables:
  - `bg-success` from `--color-success`
  - `text-success-foreground` from `--color-success-foreground`
  - etc.

### Component Registration
- Components use Laravel auto-discovery
- No manual registration in service providers is required
- Simply create components and they'll be automatically available

### Asset Management

#### Blade Directives for Asset Serving
The package provides two Blade directives to include compiled CSS and JavaScript assets in your layout files:

- **`@strataStyles`** - Include in the `<head>` section to load compiled CSS
- **`@strataScripts`** - Include before the closing `</body>` tag to load compiled JavaScript

These directives serve assets directly from the package:

<code-snippet name="Layout File Asset Directives" lang="blade">
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>App</title>

    @strataStyles
</head>
<body>
    {{ $slot }}

    @strataScripts
</body>
</html>
</code-snippet>

#### CSS Customization in Host Projects
Users can override package styles in their host project's `app.css` file. Import order is important:

<code-snippet name="app.css Override Example" lang="css">
@import "tailwindcss";

/* Package CSS is already loaded via @strataStyles directive */

/* Custom overrides go here */
@layer components {
  .btn {
    /* Override button styles */
  }
}

/* Or use @theme to override theme variables */
@theme {
  --color-primary: oklch(0.5 0.2 250);
}
</code-snippet>

The host project can:
1. Override theme variables using `@theme`
2. Override component styles using `@layer`
3. Add custom utilities that extend package components

#### Vite Asset Bundling
The package uses Vite to bundle CSS and JavaScript assets:

- **Source files** - Located in package `resources/` directory
- **Compiled assets** - Output to package `public/` directory
- **Process** - Vite compiles, minifies, and optimizes all assets
- **HMR Support** - Hot Module Replacement during development

The build process handles:
- Tailwind CSS compilation with tree-shaking
- JavaScript bundling and minification
- Alpine.js integration (via Livewire)
- CSS custom property extraction from `@theme`
- Asset fingerprinting for cache busting

#### Development Build Command
During package development, use an Artisan command to trigger the Vite build process:

<code-snippet name="Build Command Usage" lang="bash">
php artisan strata:build

# Or for watch mode during development
php artisan strata:build --watch
</code-snippet>

This command should:
1. Trigger Vite to compile CSS and JavaScript
2. Process Tailwind CSS with the package's configuration
3. Output compiled assets to the correct directory
4. Support watch mode for automatic rebuilds during development

The command internally runs the Vite build process and ensures all assets are properly compiled and ready to serve via the Blade directives.

### JavaScript Usage Policy
- Keep reliance on JavaScript to a minimum
- Only use JavaScript when absolutely necessary
- For small interactions: use inline Alpine.js
- For extensive or complex interactions: create separate JS files
- Never manually initialize Alpine.js (Livewire includes and initializes it)

### Modern CSS with Tailwind
- Tailwind v4 supports all modern CSS features
- Before writing custom CSS, look up Tailwind documentation first
- Use built-in variants, container queries, and modern selectors
- Leverage theme variables and CSS custom properties

### Tailwind Modern Features

#### Container Queries
Use `@container` class to mark elements as containers, then use variants like `@sm` and `@md` to style children based on container size:

<code-snippet name="Container Query Example" lang="html">
<div class="@container">
  <div class="flex flex-col @md:flex-row">
    <!-- ... -->
  </div>
</div>
</code-snippet>

Use `@max-sm`, `@max-md` for max-width queries, and combine them for ranges:

<code-snippet name="Container Query Range Example" lang="html">
<div class="@container">
  <div class="flex flex-row @sm:@max-md:flex-col">
    <!-- ... -->
  </div>
</div>
</code-snippet>

#### Named Containers
For nested containers, name them using `@container/{name}`:

<code-snippet name="Named Container Example" lang="html">
<div class="@container/main">
  <div class="@container/sidebar">
    <!-- ... -->
  </div>
</div>
</code-snippet>

#### Tailwind Variants Reference
All available variants in Tailwind v4:

| Variant | CSS |
|---------|-----|
| hover | @media (hover: hover) { &:hover } |
| focus | &:focus |
| focus-within | &:focus-within |
| focus-visible | &:focus-visible |
| active | &:active |
| visited | &:visited |
| target | &:target |
| * | :is(& > *) |
| ** | :is(& *) |
| has-[...] | &:has(...) |
| group-[...] | &:is(:where(.group)... *) |
| peer-[...] | &:is(:where(.peer)... ~ *) |
| in-[...] | :where(...) & |
| not-[...] | &:not(...) |
| inert | &:is([inert], [inert] *) |
| first | &:first-child |
| last | &:last-child |
| only | &:only-child |
| odd | &:nth-child(odd) |
| even | &:nth-child(even) |
| first-of-type | &:first-of-type |
| last-of-type | &:last-of-type |
| only-of-type | &:only-of-type |
| nth-[...] | &:nth-child(...) |
| nth-last-[...] | &:nth-last-child(...) |
| nth-of-type-[...] | &:nth-of-type(...) |
| nth-last-of-type-[...] | &:nth-last-of-type(...) |
| empty | &:empty |
| disabled | &:disabled |
| enabled | &:enabled |
| checked | &:checked |
| indeterminate | &:indeterminate |
| default | &:default |
| optional | &:optional |
| required | &:required |
| valid | &:valid |
| invalid | &:invalid |
| user-valid | &:user-valid |
| user-invalid | &:user-invalid |
| in-range | &:in-range |
| out-of-range | &:out-of-range |
| placeholder-shown | &:placeholder-shown |
| details-content | &:details-content |
| autofill | &:autofill |
| read-only | &:read-only |
| before | &::before |
| after | &::after |
| first-letter | &::first-letter |
| first-line | &::first-line |
| marker | &::marker, & *::marker |
| selection | &::selection |
| file | &::file-selector-button |
| backdrop | &::backdrop |
| placeholder | &::placeholder |
| sm | @media (width >= 40rem) |
| md | @media (width >= 48rem) |
| lg | @media (width >= 64rem) |
| xl | @media (width >= 80rem) |
| 2xl | @media (width >= 96rem) |
| min-[...] | @media (width >= ...) |
| max-sm | @media (width < 40rem) |
| max-md | @media (width < 48rem) |
| max-lg | @media (width < 64rem) |
| max-xl | @media (width < 80rem) |
| max-2xl | @media (width < 96rem) |
| max-[...] | @media (width < ...) |
| @3xs | @container (width >= 16rem) |
| @2xs | @container (width >= 18rem) |
| @xs | @container (width >= 20rem) |
| @sm | @container (width >= 24rem) |
| @md | @container (width >= 28rem) |
| @lg | @container (width >= 32rem) |
| @xl | @container (width >= 36rem) |
| @2xl | @container (width >= 42rem) |
| @3xl | @container (width >= 48rem) |
| @4xl | @container (width >= 56rem) |
| @5xl | @container (width >= 64rem) |
| @6xl | @container (width >= 72rem) |
| @7xl | @container (width >= 80rem) |
| @min-[...] | @container (width >= ...) |
| @max-3xs | @container (width < 16rem) |
| @max-2xs | @container (width < 18rem) |
| @max-xs | @container (width < 20rem) |
| @max-sm | @container (width < 24rem) |
| @max-md | @container (width < 28rem) |
| @max-lg | @container (width < 32rem) |
| @max-xl | @container (width < 36rem) |
| @max-2xl | @container (width < 42rem) |
| @max-3xl | @container (width < 48rem) |
| @max-4xl | @container (width < 56rem) |
| @max-5xl | @container (width < 64rem) |
| @max-6xl | @container (width < 72rem) |
| @max-7xl | @container (width < 80rem) |
| @max-[...] | @container (width < ...) |
| dark | @media (prefers-color-scheme: dark) |
| motion-safe | @media (prefers-reduced-motion: no-preference) |
| motion-reduce | @media (prefers-reduced-motion: reduce) |
| contrast-more | @media (prefers-contrast: more) |
| contrast-less | @media (prefers-contrast: less) |
| forced-colors | @media (forced-colors: active) |
| inverted-colors | @media (inverted-colors: inverted) |
| pointer-fine | @media (pointer: fine) |
| pointer-coarse | @media (pointer: coarse) |
| pointer-none | @media (pointer: none) |
| any-pointer-fine | @media (any-pointer: fine) |
| any-pointer-coarse | @media (any-pointer: coarse) |
| any-pointer-none | @media (any-pointer: none) |
| portrait | @media (orientation: portrait) |
| landscape | @media (orientation: landscape) |
| noscript | @media (scripting: none) |
| print | @media print |
| supports-[…] | @supports (…) |
| aria-busy | &[aria-busy="true"] |
| aria-checked | &[aria-checked="true"] |
| aria-disabled | &[aria-disabled="true"] |
| aria-expanded | &[aria-expanded="true"] |
| aria-hidden | &[aria-hidden="true"] |
| aria-pressed | &[aria-pressed="true"] |
| aria-readonly | &[aria-readonly="true"] |
| aria-required | &[aria-required="true"] |
| aria-selected | &[aria-selected="true"] |
| aria-[…] | &[aria-…] |
| data-[…] | &[data-…] |
| rtl | &:where(:dir(rtl), [dir="rtl"], [dir="rtl"] *) |
| ltr | &:where(:dir(ltr), [dir="ltr"], [dir="ltr"] *) |
| open | &:is([open], :popover-open, :open) |
| starting | @starting-style |

#### Modern CSS Features
- `accent-(color)` for form field accent colors
- `will-change-(mode)` for performance optimization
- `light-dark()` function for color scheme handling
- `@starting-style` for entry animations
- Native `@container` queries
- `@layer` for cascade layer management
- `@theme` for theme variable definitions

### Component Reuse
- Always build new components using existing ones when possible
- Example: When building a file upload component:
  - Use the existing button component for buttons
  - Use the existing icon component for icons
  - Use the existing input component for file inputs
- This ensures consistency and reduces code duplication

### Documentation
- **README.md** - Keep clean and minimal with only: overview, installation, quick start, links to docs, development commands
- **docs/** folder - All detailed component documentation goes here
- **docs/index.md** - Main documentation hub, update when adding new components
- **docs/{component}.md** - Individual component documentation files

#### Documentation Standards
- Write for **users of the package**, not developers
- Be clear, clean, and straightforward
- Include practical, real-world examples
- Show all variants, sizes, and options
- Include props reference tables
- Avoid verbose explanations

#### Component Development Workflow
1. Create component Blade file(s) in `packages/strata-ui/resources/views/components/`
2. Test component on welcome page with examples
3. Create `docs/{component}.md` with comprehensive user documentation
4. Update `docs/index.md` to link to new component
5. Ensure README.md links to docs (if needed)
6. Remove test examples from welcome page

### Livewire Component Testing

For components with Livewire integration (like checkboxes, radios, toggles, forms, etc.), follow this pattern to test all Livewire features:

#### Testing Pattern
1. **Create Livewire Component** in `app/Livewire/{ComponentName}Demo.php`
   - Add properties for all testable states
   - Include methods for interactions (submit, toggle, update, etc.)
   - Demonstrate reactive properties and computed values

2. **Create Livewire View** in `resources/views/livewire/{component-name}-demo.blade.php`
   - Show all component features (sizes, states, variants)
   - Demonstrate `wire:model`, `wire:model.live`, `wire:click` directives
   - Include real-time state display to show reactivity
   - Show validation states and error handling
   - Test form submission workflows

3. **Include in Welcome Page** - Add to `resources/views/welcome.blade.php`
   - Wrap in a card for visual organization
   - Include before theme switcher section
   - Use `@livewire()` directive to render component

#### Example Structure

<code-snippet name="Livewire Test Component" lang="php">
namespace App\Livewire;

use Livewire\Component;

class CheckboxDemo extends Component
{
    public bool $agreed = false;
    public array $selectedOptions = [];

    public function updatedSelectAll($value): void
    {
        // Reactive logic here
    }

    public function submit(): void
    {
        // Test form submission
    }

    public function render()
    {
        return view('livewire.checkbox-demo');
    }
}
</code-snippet>

<code-snippet name="Adding to Welcome Page" lang="blade">
<div>
    <h2 class="text-xl font-semibold mb-4">Component - Livewire Integration Demo</h2>
    <x-strata::card style="elevated">
        <x-strata::card.body padding="lg">
            @livewire('checkbox-demo')
        </x-strata::card.body>
    </x-strata::card>
</div>
</code-snippet>

#### What to Test
- All `wire:model` variations (live, blur, defer)
- All `wire:click` interactions
- State changes and reactivity
- Form validation and error states
- Computed properties
- Array/collection bindings
- Conditional rendering based on state
- Integration with other Strata UI components

**Note:** Do not create a separate route for testing. Always use the welcome page to keep testing simple and consolidated.

### Code Quality Rules (Non-Negotiable)
1. **Absolutely no comments anywhere in the code** - This is non-negotiable
   - No inline comments
   - No block comments
   - PHPDoc blocks are allowed (they serve a different purpose)
2. **Use the path of least resistance** - Achieve the desired outcome with minimal complexity
3. **No thin wrappers** - Don't create unnecessary abstraction layers
4. **No hacky solutions** - Code should be clean and maintainable
5. **No outdated or complex code** - Use modern, simple approaches
6. **Check existing components** - Always look for existing components to reuse before creating new ones

</laravel-boost-guidelines>
