# Toast

Beautiful, accessible toast notifications with smooth animations, auto-dismiss, and support for both Livewire and JavaScript usage.

## Installation

Add the toast container to your layout (typically in `app.blade.php` or `welcome.blade.php`):

```blade
<!DOCTYPE html>
<html>
<head>
    {{-- Your head content --}}
</head>
<body>
    {{-- Your page content --}}

    {{-- Add toast container before closing body tag --}}
    <x-strata::toast />
</body>
</html>
```

That's it! The toast container will handle displaying all notifications.

## Basic Usage

### From Livewire (PHP)

Use the `Strata` facade in your Livewire components:

```php
<?php

namespace App\Livewire;

use Livewire\Component;
use Stratos\StrataUI\Strata;

class UserProfile extends Component
{
    public function save()
    {
        // Save logic...

        Strata::toast($this)->success('Saved!', 'Your profile has been updated.');
    }

    public function delete()
    {
        // Delete logic...

        Strata::toast($this)->error('Error', 'Failed to delete the item.');
    }
}
```

### From JavaScript

Use the global `toast()` function:

```javascript
// Simple message
toast('Your changes have been saved');

// With title and description
toast.success('Success!', 'Your profile has been updated.');

// With custom options
toast({
    variant: 'warning',
    title: 'Warning',
    description: 'This action cannot be undone.',
    duration: 10000
});
```

## API Reference

### PHP/Livewire API

```php
use Stratos\StrataUI\Strata;

// Variant methods
Strata::toast($this)->success(string $title, ?string $description = null);
Strata::toast($this)->error(string $title, ?string $description = null);
Strata::toast($this)->warning(string $title, ?string $description = null);
Strata::toast($this)->info(string $title, ?string $description = null);

// Custom options
Strata::toast($this)->show([
    'variant' => 'success',        // info|success|warning|error
    'title' => 'Custom Title',
    'description' => 'Message...',
    'duration' => 5000,            // milliseconds (0 = persistent)
    'dismissible' => true,         // show close button
]);
```

**Important:** Always pass `$this` (the Livewire component instance) to `Strata::toast()`.

### JavaScript API

```javascript
// Variant methods
toast.success(title, description);
toast.error(title, description);
toast.warning(title, description);
toast.info(title, description);

// Simple message (shorthand)
toast('Simple message text');

// Custom options
toast({
    variant: 'success',        // info|success|warning|error
    title: 'Custom Title',
    description: 'Message...',
    duration: 5000,            // milliseconds (0 = persistent)
    dismissible: true,         // show close button
});
```

## Variants

Four semantic variants with appropriate colors and icons:

```blade
{{-- Info (blue) --}}
<x-strata::button wire:click="showInfo">
    Show Info
</x-strata::button>

{{-- Success (green) --}}
<x-strata::button wire:click="showSuccess">
    Show Success
</x-strata::button>

{{-- Warning (yellow) --}}
<x-strata::button wire:click="showWarning">
    Show Warning
</x-strata::button>

{{-- Error (red) --}}
<x-strata::button wire:click="showError">
    Show Error
</x-strata::button>
```

```php
public function showInfo()
{
    Strata::toast($this)->info('Info', 'This is informational.');
}

public function showSuccess()
{
    Strata::toast($this)->success('Success!', 'Operation completed.');
}

public function showWarning()
{
    Strata::toast($this)->warning('Warning', 'Please review your input.');
}

public function showError()
{
    Strata::toast($this)->error('Error', 'Something went wrong.');
}
```

Each variant includes:
- **Icon**: Semantic icon (info, check-circle, alert-triangle, x-circle)
- **Color scheme**: Matching border, background, and icon colors
- **Progress bar**: Variant-specific subtle color

## Positioning

Control where toasts appear on screen with the `position` prop:

```blade
{{-- Bottom right (default) --}}
<x-strata::toast position="bottom-right" />

{{-- Bottom left --}}
<x-strata::toast position="bottom-left" />

{{-- Bottom center --}}
<x-strata::toast position="bottom-center" />

{{-- Top right --}}
<x-strata::toast position="top-right" />

{{-- Top left --}}
<x-strata::toast position="top-left" />

{{-- Top center --}}
<x-strata::toast position="top-center" />
```

**Note:** Only include one toast container per page. The position applies to all toasts shown from that container.

Toasts animate in from the edge:
- **Right positions**: Slide in from right, exit to right
- **Left positions**: Slide in from left, exit to left
- **Center positions**: Slide in from bottom/top, fade out

## Configuration

### Auto-Dismiss Duration

Set custom duration (in milliseconds) for individual toasts:

```php
// PHP - 10 second duration
Strata::toast($this)->show([
    'variant' => 'info',
    'title' => 'Please read this',
    'description' => 'Important information...',
    'duration' => 10000,
]);
```

```javascript
// JavaScript - 3 second duration
toast({
    variant: 'success',
    title: 'Quick notification',
    duration: 3000
});
```

**Default duration:** 5000ms (5 seconds)

### Persistent Toasts

Set `duration: 0` to create persistent toasts that don't auto-dismiss:

```php
// Persistent toast (must be manually dismissed)
Strata::toast($this)->show([
    'variant' => 'warning',
    'title' => 'Important',
    'description' => 'This message requires acknowledgment.',
    'duration' => 0,
]);
```

```javascript
// JavaScript persistent toast
toast({
    variant: 'error',
    title: 'Critical Error',
    description: 'Please contact support.',
    duration: 0
});
```

Persistent toasts:
- Show no progress bar
- Must be manually dismissed using the close button
- Useful for critical information or errors

### Default Duration

Set a default duration for all toasts on the container:

```blade
<x-strata::toast duration="3000" />
```

Individual toast durations override this default.

### Dismissible Control

Disable the close button for specific toasts:

```php
// PHP - no close button
Strata::toast($this)->show([
    'variant' => 'success',
    'title' => 'Auto-dismiss only',
    'dismissible' => false,
]);
```

```javascript
// JavaScript - no close button
toast({
    variant: 'info',
    title: 'Auto-dismiss only',
    dismissible: false
});
```

**Note:** If `dismissible: false` and `duration: 0`, the toast cannot be closed!

## Props Reference

### Toast Container Component

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `position` | string | `'bottom-right'` | Toast position: `top-left`, `top-center`, `top-right`, `bottom-left`, `bottom-center`, `bottom-right` |
| `duration` | integer | `5000` | Default auto-dismiss duration in milliseconds (0 = persistent) |

### Toast Options (PHP/JavaScript)

| Option | Type | Default | Description |
|--------|------|---------|-------------|
| `variant` | string | `'info'` | Visual style: `info`, `success`, `warning`, `error` |
| `title` | string | `null` | Toast title (main text) |
| `description` | string | `null` | Toast description (secondary text) |
| `duration` | integer | `5000` | Auto-dismiss duration in milliseconds (0 = persistent) |
| `dismissible` | boolean | `true` | Show close button |

## Dos and Don'ts

### ✅ Do

**Use appropriate variants**
```php
// Use success for completed actions
Strata::toast($this)->success('Saved!', 'Your changes have been saved.');

// Use error for failures
Strata::toast($this)->error('Failed', 'Could not save changes.');

// Use warning for important notices
Strata::toast($this)->warning('Warning', 'This action cannot be undone.');

// Use info for general information
Strata::toast($this)->info('Tip', 'You can use keyboard shortcuts.');
```

**Provide clear, concise messages**
```php
// Good: Clear and actionable
Strata::toast($this)->success('Profile Updated', 'Your profile changes have been saved.');

// Good: Brief but informative
Strata::toast($this)->error('Login Failed', 'Invalid email or password.');
```

**Use persistent toasts for critical information**
```php
// Critical errors should not auto-dismiss
Strata::toast($this)->show([
    'variant' => 'error',
    'title' => 'Payment Failed',
    'description' => 'Your card was declined. Please try another payment method.',
    'duration' => 0,
]);
```

**Pass Livewire component instance**
```php
// Correct - pass $this
Strata::toast($this)->success('Success', 'It works!');

// Correct - pass component from method
public function notify(Component $component)
{
    Strata::toast($component)->info('Info', 'Notification sent.');
}
```

**Use one toast container per page**
```blade
{{-- Good: Single container in layout --}}
<!DOCTYPE html>
<html>
<body>
    {{ $slot }}
    <x-strata::toast />
</body>
</html>
```

**Combine title and description effectively**
```php
// Title = what happened, description = details
Strata::toast($this)->success(
    'Email Sent',
    'Confirmation email has been sent to user@example.com'
);
```

### ❌ Don't

**Don't use toasts for complex forms or long content**
```php
// Bad: Too much content for a toast
Strata::toast($this)->info(
    'Terms of Service',
    'By using this service, you agree to... [hundreds of words]'
);

// Good: Use a modal instead
$this->dispatch('open-modal', name: 'terms-modal');
```

**Don't spam multiple toasts**
```php
// Bad: Creates too many toasts at once
foreach ($users as $user) {
    Strata::toast($this)->success('Saved', "User {$user->name} saved.");
}

// Good: Single summary toast
Strata::toast($this)->success(
    'Users Updated',
    count($users) . ' users have been saved successfully.'
);
```

**Don't use wrong variants**
```php
// Bad: Success variant for error
Strata::toast($this)->success('Oops', 'Something went wrong!');

// Good: Error variant for errors
Strata::toast($this)->error('Error', 'Something went wrong!');
```

**Don't make non-critical toasts persistent**
```php
// Bad: Success message that never dismisses
Strata::toast($this)->show([
    'variant' => 'success',
    'title' => 'Saved!',
    'duration' => 0, // Forces user to manually close
]);

// Good: Auto-dismiss after reasonable time
Strata::toast($this)->success('Saved!', 'Your changes have been saved.');
```

**Don't forget to pass $this in Livewire**
```php
// Bad: Will not work
Strata::toast()->success('Title', 'Message');

// Good: Always pass component instance
Strata::toast($this)->success('Title', 'Message');
```

**Don't use dismissible: false with duration: 0**
```php
// Bad: Toast cannot be closed at all!
Strata::toast($this)->show([
    'variant' => 'info',
    'title' => 'Info',
    'dismissible' => false,
    'duration' => 0,
]);

// Good: Either allow dismissal OR auto-dismiss
Strata::toast($this)->show([
    'variant' => 'info',
    'title' => 'Info',
    'dismissible' => true,
    'duration' => 0,
]);
```

**Don't add multiple toast containers**
```blade
{{-- Bad: Multiple containers conflict --}}
<x-strata::toast position="top-right" />
<x-strata::toast position="bottom-right" />

{{-- Good: Single container --}}
<x-strata::toast position="bottom-right" />
```

**Don't use toasts for input or interaction**
```php
// Bad: Toasts shouldn't require user input
Strata::toast($this)->warning(
    'Confirm Deletion',
    'Click here to confirm or cancel'
);

// Good: Use a modal for confirmation
$this->dispatch('open-modal', name: 'confirm-delete');
```

## Advanced Examples

### Success After Form Submission

```php
<?php

namespace App\Livewire;

use Livewire\Component;
use Stratos\StrataUI\Strata;

class CreatePost extends Component
{
    public $title;
    public $content;

    public function save()
    {
        $this->validate([
            'title' => 'required|min:3',
            'content' => 'required|min:10',
        ]);

        $post = Post::create([
            'title' => $this->title,
            'content' => $this->content,
        ]);

        $this->reset(['title', 'content']);

        Strata::toast($this)->success(
            'Post Created',
            "Your post '{$post->title}' has been published."
        );

        $this->redirect(route('posts.index'));
    }
}
```

### Error Handling

```php
public function delete($postId)
{
    try {
        $post = Post::findOrFail($postId);
        $title = $post->title;

        $post->delete();

        Strata::toast($this)->success(
            'Post Deleted',
            "'{$title}' has been removed."
        );
    } catch (\Exception $e) {
        Strata::toast($this)->error(
            'Delete Failed',
            'Could not delete the post. Please try again.'
        );

        Log::error('Post deletion failed', [
            'post_id' => $postId,
            'error' => $e->getMessage()
        ]);
    }
}
```

### API Response Handling (JavaScript)

```javascript
async function saveProfile() {
    try {
        const response = await fetch('/api/profile', {
            method: 'POST',
            body: JSON.stringify(formData),
            headers: { 'Content-Type': 'application/json' }
        });

        if (response.ok) {
            toast.success('Profile Saved', 'Your changes have been saved.');
        } else {
            const error = await response.json();
            toast.error('Save Failed', error.message);
        }
    } catch (error) {
        toast.error('Network Error', 'Could not connect to server.');
    }
}
```

### Conditional Messages

```php
public function bulkDelete(array $ids)
{
    $deleted = 0;
    $failed = 0;

    foreach ($ids as $id) {
        try {
            Post::findOrFail($id)->delete();
            $deleted++;
        } catch (\Exception $e) {
            $failed++;
        }
    }

    if ($failed === 0) {
        Strata::toast($this)->success(
            'All Posts Deleted',
            "{$deleted} posts have been removed."
        );
    } else if ($deleted === 0) {
        Strata::toast($this)->error(
            'Delete Failed',
            "Could not delete any of the {$failed} selected posts."
        );
    } else {
        Strata::toast($this)->warning(
            'Partial Success',
            "Deleted {$deleted} posts, but {$failed} failed."
        );
    }
}
```

### Background Jobs

```php
public function processImport()
{
    ImportJob::dispatch($this->file);

    Strata::toast($this)->info(
        'Import Started',
        'Your file is being processed. You will be notified when complete.'
    );
}

// In ImportJob...
public function handle()
{
    // Process import...

    // Send browser event to show toast
    event(new ImportCompleted($this->userId, $this->results));
}

// Listen for event in Livewire component
protected $listeners = ['importCompleted'];

public function importCompleted($results)
{
    Strata::toast($this)->success(
        'Import Complete',
        "{$results['count']} records have been imported."
    );
}
```

### Custom Duration Based on Context

```php
public function notify($type, $message)
{
    $duration = match($type) {
        'quick' => 2000,   // Quick confirmation
        'normal' => 5000,  // Standard notification
        'important' => 10000, // Important notice
        'critical' => 0,   // Must be manually dismissed
        default => 5000,
    };

    Strata::toast($this)->show([
        'variant' => $type === 'critical' ? 'error' : 'info',
        'title' => 'Notification',
        'description' => $message,
        'duration' => $duration,
    ]);
}
```

## Accessibility

The toast component includes built-in accessibility features:

- **ARIA role**: `role="alert"` for screen reader announcements
- **Keyboard navigation**: Focus management for dismiss button
- **Focus trap**: Close button is keyboard accessible
- **Semantic icons**: Each variant has appropriate icon
- **Color contrast**: Meets WCAG AA standards
- **Reduced motion**: Respects user's motion preferences

## Features

✅ **Four semantic variants** (info, success, warning, error)
✅ **Six positioning options** (top/bottom × left/center/right)
✅ **Auto-dismiss with progress bar** (configurable duration)
✅ **Pause on hover** (stops auto-dismiss timer)
✅ **Manual dismissal** (close button)
✅ **Persistent mode** (duration: 0)
✅ **Smooth animations** (slide in/out with fade)
✅ **Stacking support** (multiple toasts)
✅ **Livewire integration** (PHP facade)
✅ **JavaScript API** (global function)
✅ **Fully accessible** (ARIA, keyboard navigation)

## Browser Support

Works in all modern browsers that support:
- CSS `@starting-style`
- CSS `transition-behavior: allow-discrete`
- Alpine.js 3.x
- Livewire 3.x

For older browsers, toasts will still function but without smooth animations.
