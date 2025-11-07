<?php

namespace Stratos\StrataUI\Support;

class PositioningHelper
{
    /**
     * Maps placement string to CSS anchor positioning properties.
     *
     * @param  string  $placement  The placement (e.g., 'bottom-start', 'right-end')
     * @param  int  $offset  Offset in pixels
     * @return array{style: string, insetProperty: string, anchorSide: string, alignProperty: string, alignSide: string}
     */
    public static function getAnchorPositioning(string $placement, int $offset = 8): array
    {
        [$insetProperty, $anchorSide, $alignProperty, $alignSide, $marginProperty] = match ($placement) {
            'bottom-start' => ['top', 'bottom', 'left', 'left', 'margin-top'],
            'bottom-end' => ['top', 'bottom', 'right', 'right', 'margin-top'],
            'bottom' => ['top', 'bottom', 'left', 'left', 'margin-top'],
            'top-start' => ['bottom', 'top', 'left', 'left', 'margin-bottom'],
            'top-end' => ['bottom', 'top', 'right', 'right', 'margin-bottom'],
            'top' => ['bottom', 'top', 'left', 'left', 'margin-bottom'],
            'right-start' => ['left', 'right', 'top', 'top', 'margin-left'],
            'right-end' => ['left', 'right', 'bottom', 'bottom', 'margin-left'],
            'right' => ['left', 'right', 'top', 'top', 'margin-left'],
            'left-start' => ['right', 'left', 'top', 'top', 'margin-right'],
            'left-end' => ['right', 'left', 'bottom', 'bottom', 'margin-right'],
            'left' => ['right', 'left', 'top', 'top', 'margin-right'],
            default => ['top', 'bottom', 'left', 'left', 'margin-top'],
        };

        $style = "position: absolute; inset: auto; {$marginProperty}: {$offset}px; {$insetProperty}: anchor({$anchorSide}); {$alignProperty}: anchor({$alignSide});";

        return [
            'style' => $style,
            'insetProperty' => $insetProperty,
            'anchorSide' => $anchorSide,
            'alignProperty' => $alignProperty,
            'alignSide' => $alignSide,
        ];
    }
}
