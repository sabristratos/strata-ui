<?php

namespace Stratos\StrataUI\Support;

class PositioningHelper
{
    /**
     * Maps placement string to CSS anchor positioning properties.
     *
     * @param  string  $placement  The placement (e.g., 'bottom-start', 'right-end')
     * @param  int  $offset  Offset in pixels
     * @param  bool  $isRTL  Whether to flip placement for RTL
     * @return array{style: string, insetProperty: string, anchorSide: string, alignProperty: string, alignSide: string}
     */
    public static function getAnchorPositioning(string $placement, int $offset = 8, bool $isRTL = false): array
    {
        if ($isRTL) {
            $placement = static::flipPlacementForRTL($placement);
        }
        [$insetProperty, $anchorSide, $alignProperty, $alignSide, $marginProperty] = match ($placement) {
            'bottom-start' => ['top', 'bottom', 'left', 'left', 'margin-top'],
            'bottom-end' => ['top', 'bottom', 'right', 'right', 'margin-top'],
            'bottom' => ['top', 'bottom', null, null, 'margin-top'],
            'top-start' => ['bottom', 'top', 'left', 'left', 'margin-bottom'],
            'top-end' => ['bottom', 'top', 'right', 'right', 'margin-bottom'],
            'top' => ['bottom', 'top', null, null, 'margin-bottom'],
            'right-start' => ['left', 'right', 'top', 'top', 'margin-left'],
            'right-end' => ['left', 'right', 'bottom', 'bottom', 'margin-left'],
            'right' => ['left', 'right', null, null, 'margin-left'],
            'left-start' => ['right', 'left', 'top', 'top', 'margin-right'],
            'left-end' => ['right', 'left', 'bottom', 'bottom', 'margin-right'],
            'left' => ['right', 'left', null, null, 'margin-right'],
            default => ['top', 'bottom', null, null, 'margin-top'],
        };

        if ($alignProperty === null && $alignSide === null) {
            if (in_array($placement, ['top', 'bottom'])) {
                $style = "position: absolute; inset: auto; {$marginProperty}: {$offset}px; {$insetProperty}: anchor({$anchorSide}); justify-self: anchor-center;";
            } elseif (in_array($placement, ['left', 'right'])) {
                $style = "position: absolute; inset: auto; {$marginProperty}: {$offset}px; {$insetProperty}: anchor({$anchorSide}); top: anchor(top);";
            } else {
                $style = "position: absolute; inset: auto; {$marginProperty}: {$offset}px; {$insetProperty}: anchor({$anchorSide}); justify-self: anchor-center;";
            }
        } else {
            $style = "position: absolute; inset: auto; {$marginProperty}: {$offset}px; {$insetProperty}: anchor({$anchorSide}); {$alignProperty}: anchor({$alignSide});";
        }

        return [
            'style' => $style,
            'insetProperty' => $insetProperty,
            'anchorSide' => $anchorSide,
            'alignProperty' => $alignProperty ?? '',
            'alignSide' => $alignSide ?? '',
        ];
    }

    /**
     * Flips horizontal placements for RTL languages.
     *
     * @param  string  $placement  Original placement
     * @return string Flipped placement for RTL
     */
    public static function flipPlacementForRTL(string $placement): string
    {
        return match ($placement) {
            'left' => 'right',
            'right' => 'left',
            'left-start' => 'right-start',
            'left-end' => 'right-end',
            'right-start' => 'left-start',
            'right-end' => 'left-end',
            'bottom-start' => 'bottom-end',
            'bottom-end' => 'bottom-start',
            'top-start' => 'top-end',
            'top-end' => 'top-start',
            default => $placement,
        };
    }
}
