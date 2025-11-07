<laravel-boost-guidelines>
=== foundation rules ===

# Laravel Boost Guidelines

The Laravel Boost guidelines are specifically curated by Laravel maintainers for this application. These guidelines should be followed closely to enhance the user's satisfaction building Laravel applications.

## Foundational Context
This application is a Laravel application and its main Laravel ecosystems package & versions are below. You are an expert with them all. Ensure you abide by these specific packages & versions.

- php - 8.3.25
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


=== tests rules ===

## Test Enforcement

- Every change must be programmatically tested. Write a new test or update an existing test, then run the affected tests to make sure they pass.
- Run the minimum number of tests needed to ensure code quality and speed. Use `php artisan test` with a specific filename or filter.


=== strata-ui rules ===

## Strata UI Design System

### Theme & Design System
- Always use the `packages/strata-ui/resources/css/theme.css` design system - never hardcode color values, spacing, shadows, or other design tokens.
- All theme variables use CSS custom properties with semantic naming (e.g., `--color-primary`, `--color-border`, `--spacing-*`, `--radius-*`, `--shadow-*`).
- The design system supports both light and dark modes using the `light-dark()` CSS function.
- Color palette includes: neutral, primary, success, warning, destructive, info with shades from 50-950.
- Spacing, border radius, and shadows are all defined as CSS variables - use these via Tailwind utilities.

### Technology Stack Priority
1. **Prioritize native HTML and PHP first** - Use semantic HTML and PHP for structure and server-side rendering.
2. **Use Tailwind CSS** for all styling - Tailwind v4 supports all modern CSS functionality, no custom CSS needed.
3. **Use Alpine.js for interactivity** - Only when state or interactivity cannot be achieved with HTML/PHP.
4. **Leverage Alpine plugins**: persist, intersect, collapse, and focus.

### Floating Elements & Positioning
Strata UI uses **native browser APIs** for all floating elements - no JavaScript positioning libraries required.

#### Popover API (Top Layer Management)
- **Use native Popover API** for floating elements (tooltips, dropdowns, modals)
- **Automatic top-layer rendering** - popovers appear above all other content without z-index management
- **Automatic light dismiss** - clicking outside or pressing Escape closes the popover
- **Not limited to button triggers** - Use programmatic JavaScript methods:
  - `HTMLElement.showPopover()` - Show a popover
  - `HTMLElement.hidePopover()` - Hide a popover
  - `HTMLElement.togglePopover()` - Toggle a popover
  - `popovertarget` attribute - Connect trigger to popover element

#### CSS Anchor Positioning (Layout)
- **Use CSS Anchor Positioning** for positioning floating elements relative to triggers
- **Pure CSS solution** - no JavaScript calculations or repositioning logic required
- **Intelligent fallbacks** - automatically repositions when primary placement doesn't fit
- **Key concepts**:
  - `anchor-name: --name` - Define an anchor point on trigger element
  - `position-anchor: --name` - Connect positioned element to anchor
  - `anchor(side)` - Reference anchor edges in positioning (e.g., `top: anchor(bottom)`)
  - `@position-try` - Define fallback positions
  - `position-try-fallbacks` - Specify ordered list of fallbacks

<code-snippet name="Popover API + CSS Anchor Positioning Example" lang="blade">
{{-- Trigger with anchor-name --}}
<button
    popovertarget="my-dropdown"
    style="anchor-name: --my-trigger;"
>
    Open Menu
</button>

{{-- Popover content positioned with CSS Anchor --}}
<div
    id="my-dropdown"
    popover="auto"
    style="
        position: absolute;
        position-anchor: --my-trigger;
        inset: auto;
        margin-top: 8px;
        top: anchor(bottom);
        left: anchor(left);
    "
>
    Dropdown content
</div>
</code-snippet>

#### Positioning Helper
- **Centralized logic**: `PositioningHelper::getAnchorPositioning($placement, $offset)`
- **Returns**: CSS style string with proper anchor positioning
- **Directional margins**: Uses `margin-top`, `margin-bottom`, etc. (NOT uniform `margin`)
- **Supported placements**: `bottom-start`, `bottom-end`, `bottom`, `top-start`, `top-end`, `top`, `right-start`, `right-end`, `right`, `left-start`, `left-end`, `left`

<code-snippet name="Using PositioningHelper" lang="php">
use Stratos\StrataUI\Support\PositioningHelper;

$positioning = PositioningHelper::getAnchorPositioning('bottom-start', 8);
// Returns: [
//   'style' => 'position: absolute; inset: auto; margin-top: 8px; top: anchor(bottom); left: anchor(left);',
//   'insetProperty' => 'top',
//   'anchorSide' => 'bottom',
//   'alignProperty' => 'left',
//   'alignSide' => 'left'
// ]
</code-snippet>

#### Fallback Positioning
- **Placement-specific fallbacks** maintain alignment when flipping
- **Example**: `bottom-start` → `top-start` (maintains left alignment, not `top-end`)
- **Defined in CSS**: `dropdown-positioning.css` with `@position-try` rules
- **Automatic selection**: Browser chooses first fallback that fits viewport
- **DO NOT use `position-try-order`** - it overrides intended placement

<code-snippet name="Fallback CSS Pattern" lang="css">
@position-try --fallback-bottom-start-1 {
    inset: auto;
    margin-bottom: 8px;
    bottom: anchor(top);
    left: anchor(left);
}

[data-strata-dropdown-content][data-placement="bottom-start"] {
    position-try-fallbacks:
        --fallback-bottom-start-1,
        --fallback-bottom-start-2,
        --fallback-bottom-start-3;
}
</code-snippet>

#### Dialog Elements
- **Use HTML `<dialog>` elements** for modal-like interactions
- **Native backdrop** with `::backdrop` pseudo-element
- **Focus trap** built-in with `inert` on background content

### Alpine.js Guidelines
- **Data nesting**: Alpine supports nested data scopes similar to JavaScript function scoping.
- **Use Alpine Persist plugin** for state that should survive page reloads (https://alpinejs.dev/plugins/persist).
- **Custom directives and modules**: Leverage Alpine's extensibility for reusable functionality.
- **Nested scoping example**:
```html
<div x-data="{ open: false }">
    <div x-data="{ label: 'Content:' }">
        <span x-text="label"></span>
        <span x-show="open"></span>
    </div>
</div>
```

### Livewire Integration
- **Reference entangleable system** for Alpine ↔ Livewire state synchronization:
  - `packages/strata-ui/resources/js/entangleable.js` - Core bidirectional state sync
  - `packages/strata-ui/resources/js/entangleable-mixin.js` - Mixin for standardized setup
- **Avoid Livewire morph issues** by using the entangleable system for state management.
- The entangleable system handles dynamic wire:model property detection during morphing.

### Component Architecture
- **Sensible defaults**: Every component should work out of the box with minimal configuration.
- **Extensibility & modularity**: Support slots and sub-components that communicate with each other.
- **Example**: The input component has sub-components for actions that can be easily swapped or extended.
- **Reuse existing components**: Always check for buttons, icon-buttons, separators, cards, icons before creating new ones.
- **Use the icon component** for all icon needs to maintain consistency.

### Component Documentation
- **Location**: `packages/strata-ui/docs/` directory
- **Style**: Simple, straightforward, and easy to skim
- **Content**: Avoid excessive information or too many examples
- **Update requirement**: Every new or updated component must have corresponding documentation
- **Reference existing docs** for structure and tone

### JavaScript Element Targeting
- **Prefer Alpine's `x-ref` and `$refs`** for local targeting within the same Alpine component scope - this is the most powerful and maintainable approach.
- **Use data attributes** (e.g., `data-strata-input`, `data-strata-dropdown-trigger`) for:
  - Cross-component targeting
  - Vanilla JavaScript selectors
  - Third-party library integration
- **Never rely on classes or IDs** for JavaScript selectors.
- **Example with `x-ref`**:
```html
<div x-data="{ open: false }">
    <button @click="open = !open" x-ref="trigger">Toggle</button>
    <div x-show="open">Dropdown content</div>
</div>
```

### Asset Serving
- Assets are served directly from package files during development.
- Entry points: `app.css` and `app.js` main files.

### Tailwind v4 Advanced Features

#### Pseudo-Classes & Variants
- `:target` - `target:shadow-lg`
- `:first-child` - `first:pt-0`
- `:last-child` - `last:pb-0`
- `:only-child` - `only:py-0`
- `:nth-child(odd)` - `odd:bg-gray-100`
- `:nth-child(even)` - `even:bg-gray-100`
- `:first-of-type` - `first-of-type:ml-6`
- `:last-of-type` - `last-of-type:mr-6`
- `:only-of-type` - `only-of-type:mx-6`
- `:nth-child()` - `nth-3:mx-6` or `nth-[3n+1]:mx-7`
- `:nth-last-child()` - `nth-last-3:mx-6` or `nth-last-[3n+1]:mx-7`
- `:nth-of-type()` - `nth-of-type-3:mx-6` or `nth-of-type-[3n+1]:mx-7`
- `:nth-last-of-type()` - `nth-last-of-type-3:mx-6`
- `:empty` - `empty:hidden`
- `:disabled` - `disabled:opacity-75`
- `:enabled` - `enabled:hover:border-gray-400`
- `:checked` - `checked:bg-blue-500`
- `:indeterminate` - `indeterminate:bg-gray-300`
- `:default` - `default:outline-2`
- `:optional` - `optional:border-red-500`
- `:required` - `required:border-red-500`
- `:valid` - `valid:border-green-500`
- `:invalid` - `invalid:border-red-500`
- `:user-valid` - `user-valid:border-green-500` (after user interaction)
- `:user-invalid` - `user-invalid:border-red-500` (after user interaction)
- `:in-range` - `in-range:border-green-500`
- `:out-of-range` - `out-of-range:border-red-500`
- `:placeholder-shown` - `placeholder-shown:border-gray-500`
- `:details-content` - `details-content:bg-gray-100` (for `<details>` elements)
- `:autofill` - `autofill:bg-yellow-200`
- `:read-only` - `read-only:bg-gray-100`

#### Theme Variable Namespaces
Tailwind v4 generates utilities from CSS variable namespaces. Define variables in these namespaces to auto-generate utilities:

| Namespace | Utility Classes |
|-----------|----------------|
| `--color-*` | Color utilities: `bg-red-500`, `text-sky-300`, etc. |
| `--font-*` | Font families: `font-sans` |
| `--text-*` | Font sizes: `text-xl` |
| `--font-weight-*` | Font weights: `font-bold` |
| `--tracking-*` | Letter spacing: `tracking-wide` |
| `--leading-*` | Line height: `leading-tight` |
| `--breakpoint-*` | Responsive breakpoints: `sm:*` |
| `--container-*` | Container queries: `@sm:*`, sizing: `max-w-md` |
| `--spacing-*` | Spacing/sizing: `px-4`, `max-h-16`, etc. |
| `--radius-*` | Border radius: `rounded-sm` |
| `--shadow-*` | Box shadows: `shadow-md` |
| `--inset-shadow-*` | Inset box shadows: `inset-shadow-xs` |
| `--drop-shadow-*` | Drop shadows: `drop-shadow-lg` |

#### Dynamic Class Names (Important)
- **Never construct class names dynamically** via string concatenation or interpolation.
- **Always use complete class names** that exist in full in your source files.

❌ **Don't do this**:
```html
<div class="text-{{ error ? 'red' : 'green' }}-600"></div>
<button class="bg-{{ color }}-600 hover:bg-{{ color }}-500">Click</button>
```

✅ **Do this instead**:
```html
<div class="{{ error ? 'text-red-600' : 'text-green-600' }}"></div>
<button :class="color === 'blue' ? 'bg-blue-600 hover:bg-blue-500' : 'bg-green-600 hover:bg-green-500'">
  Click
</button>
```

### Package Maintainability Principles
- **Keep it simple but powerful**: Balance flexibility with ease of use.
- **Leverage Alpine's extensibility**: Use custom directives and modules.
- **Modular sub-components**: Components should be composable.
- **Consistent system**: Use existing buttons, icons, cards, separators across all components.


=== strata-ui/packaging rules ===

## Package Structure & Distribution

### Service Provider Setup
- Register components in the service provider using namespace autoloading (preferred for large libraries).
- Publish views, config, and assets following Laravel conventions.
- Use Laravel package auto-discovery in `composer.json`.

<code-snippet name="Service Provider Component Registration" lang="php">
public function boot(): void
{
    // Namespace autoloading (preferred for libraries)
    Blade::componentNamespace('Strata\\UI\\Components', 'strata');
    // Usage: <x-strata::button />

    // Views
    $this->loadViewsFrom(__DIR__.'/../resources/views', 'strata-ui');
    $this->publishes([
        __DIR__.'/../resources/views' => resource_path('views/vendor/strata-ui'),
    ], 'strata-ui-views');

    // Config
    $this->mergeConfigFrom(__DIR__.'/../config/strata-ui.php', 'strata-ui');
    $this->publishes([
        __DIR__.'/../config/strata-ui.php' => config_path('strata-ui.php'),
    ], 'strata-ui-config');

    // Assets
    $this->publishes([
        __DIR__.'/../resources/css' => public_path('vendor/strata-ui/css'),
        __DIR__.'/../resources/js' => public_path('vendor/strata-ui/js'),
    ], 'strata-ui-assets');
}
</code-snippet>

### Auto-Discovery Configuration
<code-snippet name="composer.json Auto-Discovery" lang="json">
{
    "extra": {
        "laravel": {
            "providers": [
                "Strata\\UI\\StrataUIServiceProvider"
            ],
            "aliases": {
                "StrataUI": "Strata\\UI\\Facades\\StrataUI"
            }
        }
    }
}
</code-snippet>

### Package Structure
```
packages/strata-ui/
├── config/
│   └── strata-ui.php
├── resources/
│   ├── css/
│   │   ├── theme.css
│   │   └── app.css
│   ├── js/
│   │   ├── app.js
│   │   └── components/
│   └── views/
│       └── components/
├── src/
│   ├── Components/
│   ├── Livewire/
│   └── StrataUIServiceProvider.php
└── tests/
```


=== strata-ui/component-api rules ===

## Component API Design

### Props vs Attributes Pattern
- **Props**: Component-specific configuration (variants, sizes, behavior flags)
- **Attributes**: HTML attributes forwarded to the underlying element

<code-snippet name="Props and Attributes" lang="php">
class Button extends Component
{
    // Props (component configuration)
    public string $variant = 'primary'; // solid, outline, ghost, destructive
    public string $size = 'md'; // xs, sm, md, lg, xl
    public bool $loading = false;
    public bool $disabled = false;

    public function render(): View
    {
        return view('strata-ui::components.button');
    }
}
</code-snippet>

### Intelligent Class Merging
- Use `$attributes->class()` for intelligent class merging that allows user overrides.
- Build classes conditionally based on props.

<code-snippet name="Class Merging Strategy" lang="php">
@php
$classes = $attributes->class([
    'btn', // Base class always applied
    'btn-'.$variant, // Variant classes
    'btn-'.$size, // Size classes
    'opacity-50 cursor-not-allowed pointer-events-none' => $disabled || $loading,
]);
@endphp

<button {{ $attributes->merge(['type' => 'button', 'class' => $classes]) }}>
    @if($loading)
        <x-strata::icon name="spinner" class="animate-spin" />
    @endif
    {{ $slot }}
</button>
</code-snippet>

### Variant System Design
- Define a consistent variant system across all components.
- Standard variants: `primary`, `outline`, `ghost`, `destructive`, `success`, `warning`, `info`

### Size System
- Standard sizes: `xs`, `sm`, `md` (default), `lg`, `xl`
- Maintain consistent sizing across components.

### Boolean Props
- Use boolean props for component behavior: `loading`, `disabled`, `readonly`, `required`, `optional`
- Default to `false` unless there's a strong reason otherwise.

### Slot Naming Conventions
- Use typed slots with descriptive names.
- Common slot names: `header`, `footer`, `icon`, `prefix`, `suffix`, `content`

<code-snippet name="Named Slots" lang="blade">
<x-strata::card>
    <x-slot:header>
        Card Header
    </x-slot:header>

    <x-slot:footer class="flex justify-end gap-2">
        <x-strata::button>Cancel</x-strata::button>
        <x-strata::button variant="primary">Save</x-strata::button>
    </x-slot:footer>

    Default card content here
</x-strata::card>
</code-snippet>

### Attribute Forwarding
- Always forward unrecognized attributes to the root element.
- Use `$attributes->except()` to exclude component props.
- Preserve Alpine directives, data attributes, and event handlers.


=== strata-ui/accessibility rules ===

## Accessibility (a11y) Patterns

### ARIA Patterns for Common Components

#### Dialog/Modal
<code-snippet name="Accessible Modal" lang="blade">
<dialog
    x-ref="modal"
    role="dialog"
    aria-modal="true"
    :aria-labelledby="$id('modal-title')"
    :aria-describedby="$id('modal-description')"
    class="backdrop:bg-black/50"
    @close="handleClose()"
>
    <h2 :id="$id('modal-title')">Modal Title</h2>
    <p :id="$id('modal-description')">Modal description</p>

    <button @click="$refs.modal.close()">Close</button>
</dialog>
</code-snippet>

#### Dropdown/Menu
<code-snippet name="Accessible Dropdown" lang="blade">
<div x-data="{ open: false }">
    <button
        popovertarget="menu"
        :aria-expanded="open"
        aria-haspopup="true"
        :aria-controls="$id('dropdown-menu')"
        type="button"
        style="anchor-name: --menu-trigger;"
    >
        Options
    </button>

    <ul
        id="menu"
        popover="auto"
        :id="$id('dropdown-menu')"
        role="menu"
        tabindex="-1"
        x-trap.noscroll="open"
        @toggle="open = $event.newState === 'open'"
        @keydown.arrow-down.prevent="$focus.wrap().next()"
        @keydown.arrow-up.prevent="$focus.wrap().previous()"
        @keydown.home.prevent="$focus.first()"
        @keydown.end.prevent="$focus.last()"
        style="
            position: absolute;
            position-anchor: --menu-trigger;
            inset: auto;
            margin-top: 8px;
            top: anchor(bottom);
            left: anchor(left);
        "
    >
        <li role="menuitem" tabindex="0">Action 1</li>
        <li role="menuitem" tabindex="0">Action 2</li>
        <li role="menuitem" tabindex="0">Action 3</li>
    </ul>
</div>
</code-snippet>

#### Tabs
<code-snippet name="Accessible Tabs" lang="blade">
<div x-data="{ activeTab: 'tab1' }">
    <div role="tablist" aria-label="Content tabs">
        <button
            role="tab"
            :aria-selected="activeTab === 'tab1'"
            :aria-controls="$id('panel-1')"
            :tabindex="activeTab === 'tab1' ? 0 : -1"
            @click="activeTab = 'tab1'"
        >
            Tab 1
        </button>
        <button
            role="tab"
            :aria-selected="activeTab === 'tab2'"
            :aria-controls="$id('panel-2')"
            :tabindex="activeTab === 'tab2' ? 0 : -1"
            @click="activeTab = 'tab2'"
        >
            Tab 2
        </button>
    </div>

    <div
        :id="$id('panel-1')"
        role="tabpanel"
        x-show="activeTab === 'tab1'"
        :aria-labelledby="$id('tab-1')"
    >
        Panel 1 content
    </div>

    <div
        :id="$id('panel-2')"
        role="tabpanel"
        x-show="activeTab === 'tab2'"
        :aria-labelledby="$id('tab-2')"
    >
        Panel 2 content
    </div>
</div>
</code-snippet>

#### Accordion
<code-snippet name="Accessible Accordion" lang="blade">
<div x-data="{ expanded: false }">
    <h3>
        <button
            @click="expanded = !expanded"
            :aria-expanded="expanded"
            :aria-controls="$id('accordion-content')"
        >
            Accordion Header
        </button>
    </h3>

    <div
        :id="$id('accordion-content')"
        role="region"
        x-show="expanded"
        x-collapse
    >
        Accordion content
    </div>
</div>
</code-snippet>

#### Alert/Toast
<code-snippet name="Accessible Alert" lang="blade">
<div
    role="alert"
    aria-live="assertive"
    aria-atomic="true"
    class="bg-destructive text-destructive-foreground"
>
    Error message content
</div>

<div
    role="status"
    aria-live="polite"
    aria-atomic="true"
    class="bg-success text-success-foreground"
>
    Success message content
</div>
</code-snippet>

### Keyboard Navigation Requirements
- **Arrow Keys**: Navigate through lists, menus, tabs
- **Home/End**: Jump to first/last item
- **Escape**: Close modals, dropdowns, cancel actions
- **Enter/Space**: Activate buttons, toggle checkboxes
- **Tab/Shift+Tab**: Navigate between focusable elements
- **Page Up/Down**: Navigate through large lists

### Focus Management
- Use Alpine's `x-trap` to trap focus within modals.
- Use `$focus` magic for programmatic focus control.
- Ensure visible focus indicators (ring classes).
- Restore focus after closing modals.

<code-snippet name="Focus Trap Pattern" lang="blade">
<div
    x-show="open"
    x-trap.noscroll="open"
    @keydown.escape="open = false"
>
    {{-- Focus trapped here when open --}}
</div>
</code-snippet>

### Screen Reader Support
- Use semantic HTML elements (`<button>`, `<nav>`, `<main>`, `<aside>`).
- Provide `aria-label` or `aria-labelledby` for interactive elements.
- Use `aria-describedby` for additional context.
- Hide decorative elements with `aria-hidden="true"`.
- Use `sr-only` class for screen-reader-only text.

### Color Contrast
- Ensure WCAG AA compliance (4.5:1 for normal text, 3:1 for large text).
- Test all color combinations in light and dark modes.
- Don't rely solely on color to convey information.

### Reduced Motion
- Respect `prefers-reduced-motion` user preference.
- Disable animations when this preference is set.

<code-snippet name="Reduced Motion Support" lang="css">
@media (prefers-reduced-motion: reduce) {
  *,
  *::before,
  *::after {
    animation-duration: 0.01ms !important;
    animation-iteration-count: 1 !important;
    transition-duration: 0.01ms !important;
  }
}
</code-snippet>


=== strata-ui/testing rules ===

## Component Testing Strategies

### Blade Component Unit Tests
- Test component rendering with different props.
- Verify class merging behavior.
- Test slot rendering.
- Ensure attribute forwarding works correctly.

<code-snippet name="Blade Component Tests" lang="php">
it('renders button with correct variant classes', function () {
    $view = $this->blade(
        '<x-strata::button variant="outline">Click</x-strata::button>'
    );

    $view->assertSee('Click')
        ->assertSee('btn-outline', false); // false = check HTML source
});

it('forwards attributes to underlying element', function () {
    $view = $this->blade(
        '<x-strata::button data-test="submit" @click="handleClick">Submit</x-strata::button>'
    );

    $view->assertSee('data-test="submit"', false)
        ->assertSee('@click="handleClick"', false);
});

it('merges user classes with component classes', function () {
    $view = $this->blade(
        '<x-strata::button class="custom-class">Button</x-strata::button>'
    );

    $view->assertSee('btn', false) // Base class
        ->assertSee('custom-class', false); // User class
});

it('renders slots correctly', function () {
    $view = $this->blade(
        '<x-strata::card>
            <x-slot:header>Header Content</x-slot:header>
            Body Content
        </x-strata::card>'
    );

    $view->assertSee('Header Content')
        ->assertSee('Body Content');
});
</code-snippet>

### Browser Tests for Interactive Components
- Test Alpine.js interactions (click, keyboard navigation).
- Verify state changes and reactivity.
- Test Livewire component integration.

<code-snippet name="Browser Tests" lang="php">
it('opens dropdown on click and closes on escape', function () {
    $page = visit('/components/dropdown');

    $page->click('[data-dropdown-trigger]')
        ->assertVisible('[data-dropdown-menu]')
        ->press('Escape')
        ->assertNotVisible('[data-dropdown-menu]');
});

it('navigates through menu items with arrow keys', function () {
    $page = visit('/components/dropdown');

    $page->click('[data-dropdown-trigger]')
        ->press('ArrowDown')
        ->assertFocused('[role="menuitem"]:first-child')
        ->press('ArrowDown')
        ->assertFocused('[role="menuitem"]:nth-child(2)');
});

it('traps focus within modal', function () {
    $page = visit('/components/modal');

    $page->click('[data-modal-trigger]')
        ->assertVisible('[role="dialog"]')
        ->press('Tab') // Should cycle through focusable elements
        ->assertFocused('[data-modal-close]');
});
</code-snippet>

### Accessibility Testing
- Verify ARIA attributes are present and correct.
- Test keyboard navigation paths.
- Use axe-core integration for automated a11y checks.

<code-snippet name="Accessibility Tests" lang="php">
it('has proper ARIA attributes for modal', function () {
    $page = visit('/components/modal');

    $page->click('[data-modal-trigger]')
        ->assertAttribute('[role="dialog"]', 'aria-modal', 'true')
        ->assertAttribute('[role="dialog"]', 'aria-labelledby', fn($value) => !empty($value));
});

it('has proper roles for dropdown menu', function () {
    $view = $this->blade('<x-strata::dropdown />');

    $view->assertSee('role="menu"', false)
        ->assertSee('role="menuitem"', false);
});

it('supports keyboard navigation', function () {
    $page = visit('/components/tabs');

    $page->press('Tab') // Focus first tab
        ->assertFocused('[role="tab"]:first-child')
        ->press('ArrowRight')
        ->assertFocused('[role="tab"]:nth-child(2)');
});
</code-snippet>

### Visual Regression Testing
- Take screenshots of components in different states.
- Compare against baseline screenshots.
- Test in light and dark modes.

<code-snippet name="Visual Regression Tests" lang="php">
it('matches button snapshot in all variants', function () {
    $page = visit('/components/button');

    $page->assertScreenshotMatches('button-primary.png', '[data-variant="primary"]')
        ->assertScreenshotMatches('button-outline.png', '[data-variant="outline"]')
        ->assertScreenshotMatches('button-ghost.png', '[data-variant="ghost"]');
});

it('matches button snapshot in dark mode', function () {
    $page = visit('/components/button?theme=dark');

    $page->assertScreenshotMatches('button-dark.png');
});
</code-snippet>

### Livewire Component Testing
- Test Livewire properties and methods.
- Verify wire:model bindings.
- Test event dispatching and listening.

<code-snippet name="Livewire Component Tests" lang="php">
it('updates state when input changes', function () {
    Livewire::test(Select::class)
        ->set('value', 'option1')
        ->assertSet('value', 'option1')
        ->call('selectOption', 'option2')
        ->assertSet('value', 'option2')
        ->assertDispatched('value-changed');
});
</code-snippet>


=== strata-ui/performance rules ===

## Performance Optimization

### Component Lazy Loading
- Use `wire:init` to defer loading heavy components.
- Use `wire:ignore` to prevent Livewire from morphing certain elements.

<code-snippet name="Lazy Loading" lang="blade">
{{-- Defer loading until component is visible --}}
<div wire:init="loadChartData">
    @if($chartDataLoaded)
        <x-strata::chart :data="$chartData" />
    @else
        <x-strata::skeleton type="chart" />
    @endif
</div>

{{-- Prevent morphing for Alpine-heavy components --}}
<div wire:ignore>
    <x-strata::color-picker wire:model="color" />
</div>
</code-snippet>

### Script and Style Loading
- Use `@once` to ensure scripts/styles are only loaded once per page.
- Push assets to appropriate stacks (`@push('scripts')`, `@push('styles')`).

<code-snippet name="Script Loading" lang="blade">
@once
    @push('scripts')
        <script src="/vendor/strata-ui/chart.js" defer></script>
    @endpush
@endonce

@once
    @push('styles')
        <link rel="stylesheet" href="/vendor/strata-ui/chart.css">
    @endpush
@endonce
</code-snippet>

### Alpine.js Optimization
- Use `x-cloak` to prevent flash of unstyled content.
- Use event modifiers to optimize event handling (`.prevent`, `.stop`, `.once`, `.debounce`).
- Use `x-show` for frequently toggled elements, `x-if` for conditionally rendered elements.

<code-snippet name="Alpine Optimization" lang="blade">
<div
    x-data="{ open: false }"
    x-cloak  {{-- Prevent FOUC --}}
    @click.outside="open = false"  {{-- Event modifier --}}
    @scroll.window.debounce.500ms="handleScroll"  {{-- Debounced event --}}
>
    {{-- Use x-show for frequently toggled content --}}
    <div x-show="open" x-transition>
        Dropdown content
    </div>

    {{-- Use x-if for rarely shown content --}}
    <template x-if="showModal">
        <div>Modal content</div>
    </template>
</div>
</code-snippet>

### Bundle Optimization
- Split vendor code from application code.
- Use tree-shaking to eliminate unused code.
- Minimize and compress assets.

<code-snippet name="Vite Bundle Configuration" lang="js">
// vite.config.js
export default defineConfig({
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    'vendor': ['alpinejs'],
                    'strata-ui': [
                        './packages/strata-ui/resources/js/app.js'
                    ]
                }
            }
        },
        minify: 'terser',
        terserOptions: {
            compress: {
                drop_console: true,
            }
        }
    }
});
</code-snippet>

### Blade Component Caching
- Blade components are cached by default in production.
- Use `php artisan view:clear` to clear cached views during development.

### Reducing Livewire Re-renders
- Use `wire:model.defer` for form inputs that don't need real-time updates.
- Use `wire:model.live.debounce` for search inputs.
- Avoid heavy computations in computed properties.

<code-snippet name="Optimized Livewire" lang="blade">
{{-- Deferred binding --}}
<input wire:model.defer="title" />

{{-- Debounced real-time binding --}}
<input wire:model.live.debounce.500ms="search" />

{{-- Target specific elements for loading states --}}
<button wire:click="save" wire:loading.attr="disabled" wire:target="save">
    <span wire:loading.remove wire:target="save">Save</span>
    <span wire:loading wire:target="save">Saving...</span>
</button>
</code-snippet>


=== strata-ui/documentation rules ===

## Documentation Structure

### Directory Organization
```
docs/
├── getting-started/
│   ├── installation.md
│   ├── configuration.md
│   ├── theming.md
│   └── troubleshooting.md
├── components/
│   ├── button.md
│   ├── dropdown.md
│   ├── modal.md
│   ├── input.md
│   └── ...
├── patterns/
│   ├── forms.md
│   ├── data-tables.md
│   └── navigation.md
├── accessibility/
│   ├── guidelines.md
│   ├── keyboard-navigation.md
│   └── screen-readers.md
├── testing/
│   ├── component-testing.md
│   ├── browser-testing.md
│   └── accessibility-testing.md
├── migration/
│   ├── v1-to-v2.md
│   └── breaking-changes.md
└── api/
    └── component-api.md
```

### Component Documentation Template
Each component should follow this structure:

```markdown
# Button Component

## Import
```blade
<x-strata::button />
```

## API Reference

### Props
| Prop | Type | Default | Description |
|------|------|---------|-------------|
| variant | string | 'primary' | Visual style: primary, outline, ghost, destructive |
| size | string | 'md' | Size: xs, sm, md, lg, xl |
| loading | boolean | false | Shows loading spinner |
| disabled | boolean | false | Disables button |

### Slots
| Slot | Description |
|------|-------------|
| default | Button content (required) |
| icon | Icon displayed before text |

### Events
| Event | Payload | Description |
|-------|---------|-------------|
| click | MouseEvent | Emitted when button is clicked |

## Examples

### Basic Usage
```blade
<x-strata::button>Click me</x-strata::button>
```

### With Variant
```blade
<x-strata::button variant="outline">Outline Button</x-strata::button>
```

### With Loading State
```blade
<x-strata::button :loading="$isLoading">
    Save Changes
</x-strata::button>
```

### With Icon
```blade
<x-strata::button>
    <x-slot:icon>
        <x-strata::icon name="plus" />
    </x-slot:icon>
    Add Item
</x-strata::button>
```

## Accessibility
- Uses semantic `<button>` element
- Respects `disabled` attribute
- Supports keyboard navigation (Enter/Space)
- Has visible focus indicator
- Screen reader accessible with proper labels

## Related Components
- [Icon Button](#icon-button)
- [Button Group](#button-group)
- [Link Button](#link-button)

## Styling Customization
The button component uses the theme design system. Override these CSS variables to customize:
- `--color-primary` - Primary button background
- `--color-primary-foreground` - Primary button text
- `--radius-md` - Button border radius
```

### Installation Documentation
- Clear step-by-step installation instructions.
- List all requirements and dependencies.
- Include configuration examples.
- Provide troubleshooting section.

### API Reference Format
- Auto-generated from PHPDoc blocks when possible.
- List all props with types, defaults, and descriptions.
- Document all slots and their purposes.
- List all events and their payloads.
- Include usage examples for each prop/slot/event.

### Interactive Examples
- Provide copy-paste ready code examples.
- Show component in different states (loading, disabled, error).
- Demonstrate all variants and sizes.
- Include real-world usage patterns.


=== strata-ui/versioning rules ===

## Versioning & Breaking Changes

### Semantic Versioning
- Follow semantic versioning (MAJOR.MINOR.PATCH).
- **MAJOR**: Breaking changes (API changes, removed features).
- **MINOR**: New features (backward compatible).
- **PATCH**: Bug fixes (backward compatible).

### Deprecation Workflow
- Announce deprecations in MINOR versions.
- Log deprecation warnings in development mode.
- Remove deprecated features in next MAJOR version.
- Provide migration path and auto-migration when possible.

<code-snippet name="Deprecation Pattern" lang="php">
class Button extends Component
{
    public ?string $color = null; // Deprecated in v2.1
    public string $variant = 'primary'; // New prop

    public function mount(): void
    {
        if ($this->color !== null) {
            if (app()->environment('local', 'development')) {
                logger()->warning(
                    'The "color" prop is deprecated and will be removed in v3.0. Use "variant" instead.',
                    [
                        'component' => static::class,
                        'file' => debug_backtrace()[0]['file'] ?? 'unknown',
                        'line' => debug_backtrace()[0]['line'] ?? 'unknown',
                    ]
                );
            }

            // Auto-migrate for now
            $this->variant = $this->mapColorToVariant($this->color);
        }
    }

    protected function mapColorToVariant(string $color): string
    {
        return match($color) {
            'blue' => 'primary',
            'red' => 'destructive',
            'gray' => 'outline',
            default => 'primary',
        };
    }
}
</code-snippet>

### CHANGELOG.md Structure
<code-snippet name="CHANGELOG Format" lang="markdown">
# Changelog

All notable changes to Strata UI will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [2.0.0] - 2025-01-15

### Breaking Changes
- **Button**: Removed `color` prop, use `variant` instead
- **Input**: Changed default wire:model behavior to deferred
- **Modal**: Renamed `show` prop to `open` for consistency

### Migration Guide
See [Migration Guide v1 → v2](docs/migration/v1-to-v2.md)

### Added
- New `Chart` component with full accessibility support
- Dark mode support for all components
- `size` prop for all interactive components
- Alpine Persist plugin integration

### Changed
- Updated Tailwind from v3 to v4
- Improved class merging strategy
- Enhanced accessibility for all components

### Fixed
- Modal scroll locking on iOS
- Dropdown positioning edge cases
- Focus trap issues in nested modals
- Color picker contrast in dark mode

### Deprecated
- `Button` `color` prop (use `variant` instead)
- `Input` `type="legacy"` (use standard types)

## [1.5.0] - 2024-12-01

...
</code-snippet>

### Migration Guide Structure
<code-snippet name="Migration Guide Format" lang="markdown">
# Migration Guide: v1.x to v2.0

## Overview
Version 2.0 introduces several breaking changes focused on consistency and modern web standards.

Estimated migration time: 30-60 minutes for most projects.

## Breaking Changes

### Button Component

#### Removed `color` prop
**Before (v1.x):**
```blade
<x-strata::button color="blue">Click</x-strata::button>
<x-strata::button color="red">Delete</x-strata::button>
```

**After (v2.0):**
```blade
<x-strata::button variant="primary">Click</x-strata::button>
<x-strata::button variant="destructive">Delete</x-strata::button>
```

**Automated Migration:**
```bash
php artisan strata-ui:migrate v1-to-v2
```

### Input Component

#### Default wire:model behavior
The default wire:model behavior is now deferred.

**Before (v1.x):**
```blade
<x-strata::input wire:model="name" /> {{-- Real-time by default --}}
```

**After (v2.0):**
```blade
<x-strata::input wire:model="name" /> {{-- Deferred by default --}}
<x-strata::input wire:model.live="search" /> {{-- Explicitly real-time --}}
```

## New Features

### Size Prop
All components now support a standardized `size` prop:
```blade
<x-strata::button size="sm">Small</x-strata::button>
<x-strata::button size="md">Medium (default)</x-strata::button>
<x-strata::button size="lg">Large</x-strata::button>
```

### Dark Mode
All components now support dark mode out of the box.

## Deprecation Warnings
If you see deprecation warnings, update your code before upgrading to v3.0.

## Need Help?
- Check the [troubleshooting guide](../getting-started/troubleshooting.md)
- Open an issue on [GitHub](https://github.com/your-org/strata-ui/issues)
</code-snippet>

### Backward Compatibility
- Maintain backward compatibility within MINOR versions.
- Use feature flags for gradual rollout of breaking changes.
- Provide codemods or migration scripts when possible.


=== strata-ui/validation rules ===

## Component Prop Validation

### Validate Props in mount()
- Always validate component props to provide helpful error messages.
- Validate allowed values for enum-like props (variant, size).
- Check required props are provided.

<code-snippet name="Prop Validation" lang="php">
class Button extends Component
{
    public string $variant;
    public string $size;

    protected array $allowedVariants = ['primary', 'outline', 'ghost', 'destructive'];
    protected array $allowedSizes = ['xs', 'sm', 'md', 'lg', 'xl'];

    public function mount(): void
    {
        // Validate variant
        if (!in_array($this->variant, $this->allowedVariants)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Invalid variant "%s" for %s component. Allowed values: %s',
                    $this->variant,
                    static::class,
                    implode(', ', $this->allowedVariants)
                )
            );
        }

        // Validate size
        if (!in_array($this->size, $this->allowedSizes)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Invalid size "%s" for %s component. Allowed values: %s',
                    $this->size,
                    static::class,
                    implode(', ', $this->allowedSizes)
                )
            );
        }
    }
}
</code-snippet>

### User-Friendly Error Messages
- Provide clear, actionable error messages.
- Include the component name, invalid value, and allowed values.
- Link to documentation when helpful.

<code-snippet name="Helpful Error Messages" lang="php">
throw new InvalidArgumentException(
    sprintf(
        'Invalid variant "%s" for Button component. '.
        'Allowed values are: %s. '.
        'See https://strata-ui.test/docs/components/button for more information.',
        $this->variant,
        implode(', ', $this->allowedVariants)
    )
);
</code-snippet>

### Debug Mode
- Add verbose logging in development/local environments.
- Suppress validation in production for performance.

<code-snippet name="Debug Mode Pattern" lang="php">
public function mount(): void
{
    if (app()->environment('local', 'development')) {
        $this->validateProps();
        $this->logComponentUsage();
    }
}

protected function validateProps(): void
{
    // Validation logic
}

protected function logComponentUsage(): void
{
    logger()->debug('Component rendered', [
        'component' => static::class,
        'props' => get_object_vars($this),
    ]);
}
</code-snippet>

### Invariant Checks
- Use assertions for internal consistency checks.
- Fail fast during development to catch bugs early.

<code-snippet name="Invariant Checks" lang="php">
public function render(): View
{
    // Invariant: if loading is true, button must have content
    if ($this->loading) {
        assert(
            !empty($this->slot),
            'Button with loading state must have content'
        );
    }

    return view('strata-ui::components.button');
}
</code-snippet>

</laravel-boost-guidelines>
- No comments in code. This is non negociable. Keep the code clean and only add docblocks or js blocks.