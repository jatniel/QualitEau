<?php
/**
 * Water quality status levels
 * @author    Jatniel Guzmán https://jatniel.dev
 * @copyright    2025
 * @license    MIT
 */

declare(strict_types=1);

namespace App\Enums;

/**
 * Water quality status levels
 */
enum WaterQualityStatus: string
{
    case EXCELLENT = 'excellent';
    case GOOD = 'good';
    case ACCEPTABLE = 'acceptable';
    case CRITICAL = 'critical';
    case UNKNOWN = 'unknown';
    case SOFT = 'soft';
    case HARD = 'hard';

    /**
     * Get status label in French
     */
    public function label(): string
    {
        return match ($this) {
            self::EXCELLENT => 'Excellente',
            self::GOOD => 'Bonne',
            self::ACCEPTABLE => 'Acceptable',
            self::CRITICAL => 'Critique',
            self::UNKNOWN => 'Inconnue',
            self::SOFT => 'Eau douce',
            self::HARD => 'Eau dure',
        };
    }

    /**
     * Get semantic color name from design system
     */
    public function color(): string
    {
        return match ($this) {
            self::EXCELLENT => 'safe',         // Green
            self::GOOD => 'pure',              // Blue
            self::ACCEPTABLE => 'caution',     // Yellow/Amber
            self::CRITICAL => 'contaminated',  // Red
            self::UNKNOWN => 'mist',           // Gray
            self::SOFT => 'pure',              // Cyan -> Pure (Blue-ish)
            self::HARD => 'caution',           // Orange -> Caution
        };
    }

    /**
     * Get icon name for display
     */
    public function icon(): string
    {
        return match ($this) {
            self::EXCELLENT => 'check-circle',
            self::GOOD => 'thumbs-up',
            self::ACCEPTABLE => 'alert-circle',
            self::CRITICAL => 'x-circle',
            self::UNKNOWN => 'help-circle',
            self::SOFT => 'droplet',
            self::HARD => 'droplets',
        };
    }

    /**
     * Get numeric score (0-100)
     */
    public function score(): int
    {
        return match ($this) {
            self::EXCELLENT => 100,
            self::GOOD => 75,
            self::ACCEPTABLE => 50,
            self::CRITICAL => 0,
            self::UNKNOWN => 0,
            self::SOFT => 75,
            self::HARD => 50,
        };
    }
}
